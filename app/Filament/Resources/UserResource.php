<?php

namespace App\Filament\Resources;

use App\Models\User;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Google\Client as GoogleClient;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Tables\Actions\BulkAction;
use Filament\Notifications\Notification;
use App\Filament\Resources\UserResource\Pages;
use App\Models\Notification as NotificationModel;
use Filament\Forms\Components\{TextInput, Toggle};
use Filament\Tables\Columns\{TextColumn, IconColumn};

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationGroup = 'Admin';
    public static string $panel = 'jfeid';

    public static function form(Form $form): Form
    {
        return $form->schema([
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            TextInput::make('email')
                ->email()
                ->nullable()
                ->unique(ignoreRecord: true),
            TextInput::make('phonenumber')
                ->label('Phone Number')
                ->nullable()
                ->maxLength(15),
            TextInput::make('password')
                ->password()
                ->required(fn(string $context) => $context === 'create')
                ->maxLength(255)
                ->dehydrateStateUsing(fn($state) => bcrypt($state)),
            TextInput::make('carplate')
                ->label('Car Plate')
                ->nullable()
                ->maxLength(20),
            Toggle::make('is_admin')
                ->label('Admin Privileges'),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->searchable(),
                TextColumn::make('email')->searchable(),
                IconColumn::make('is_admin')
                    ->label('Admin')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->visible(fn() => Auth::user()?->is_admin)
                    ->colors([
                        'success' => true,
                        'danger' => false,
                    ]),
                TextColumn::make('carplate')->label('Car Plate'),
                TextColumn::make('phonenumber')->label('Phone Number'),
                TextColumn::make('created_at')->dateTime(),
            ])
            ->bulkActions([
                BulkAction::make('send-notification')
                    ->label('Send Notification')
                    ->icon('heroicon-o-paper-airplane')
                    ->form([
                        Select::make('topic')->options([
                            'all_users' => 'All Users',
                        ])->rules('required'),
                        TextInput::make('title')->required(),
                        TextInput::make('body')->required(),
                    ])
                    ->action(function (Collection $records, array $data) {
                        try {
                            $firebaseConfig = self::getFirebaseConfig();
                            $client = self::buildFirebaseClient($firebaseConfig);
                            $tokenData = $client->fetchAccessTokenWithAssertion();
                            $accessToken = $tokenData['access_token'] ?? null;
                            if (!is_string($accessToken) || $accessToken === '') {
                                throw new \RuntimeException('Failed to fetch Firebase access token.');
                            }

                            $payload = [
                                'message' => [
                                    'topic' => $data['topic'],
                                    'notification' => [
                                        'title' => $data['title'],
                                        'body' => $data['body'],
                                    ],
                                ],
                            ];

                            $projectId = (string) ($firebaseConfig['project_id'] ?? '');
                            if ($projectId === '') {
                                throw new \RuntimeException('Firebase project_id is missing in FIREBASE_CREDENTIALS.');
                            }
                            $response = Http::withToken($accessToken)
                                ->post("https://fcm.googleapis.com/v1/projects/{$projectId}/messages:send", $payload);

                            NotificationModel::create([
                                'topic' => $data['topic'],
                                'title' => $data['title'],
                                'body' => $data['body'],
                                'response' => $response->json(),
                            ]);

                            Notification::make()
                                ->title($response->successful() ? 'Notification Sent' : 'Failed to Send')
                                ->{$response->successful() ? 'success' : 'danger'}()
                                ->send();
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Error Sending Notification')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();
                        }
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    protected static function getFirebaseConfig(): array
    {
        $credentialsBase64 = (string) config('services.firebase.credentials');
        if ($credentialsBase64 === '') {
            throw new \RuntimeException('FIREBASE_CREDENTIALS is not configured.');
        }

        $decodedCredentials = base64_decode($credentialsBase64, true);
        if ($decodedCredentials === false) {
            throw new \RuntimeException('FIREBASE_CREDENTIALS must be valid base64.');
        }

        $credentials = json_decode($decodedCredentials, true);
        if (!is_array($credentials)) {
            throw new \RuntimeException('FIREBASE_CREDENTIALS must decode to valid JSON.');
        }

        return $credentials;
    }

    protected static function buildFirebaseClient(array $credentials): GoogleClient
    {
        $client = new GoogleClient();
        $client->setAuthConfig($credentials);
        $client->addScope('https://www.googleapis.com/auth/firebase.messaging');

        return $client;
    }
}
