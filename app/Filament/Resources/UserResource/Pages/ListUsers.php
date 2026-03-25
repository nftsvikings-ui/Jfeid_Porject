<?php

namespace App\Filament\Resources\UserResource\Pages;

use Filament\Tables;
use Filament\Actions;
use App\Models\Notification;
use Google\Client as GoogleClient;
use Filament\Tables\Actions\Action;
use Illuminate\Support\Facades\Http;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Filament\Resources\UserResource;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
