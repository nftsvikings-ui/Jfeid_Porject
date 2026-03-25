<?php

namespace App\Filament\Resources\MaintenanceRecordsRelationResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\RelationManagers\RelationManager;

class MaintenanceRecordsRelationManager extends RelationManager
{
    protected static string $relationship = 'maintenanceRecords';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('type')
                    ->label('Maintenance Type')
                    ->options([
                        'oil_change' => 'Oil Change',
                        'steering_oil_change' => 'Steering Oil Change',
                        'transmission_oil_change' => 'Transmission Oil Change',
                        'differential_oil_change' => 'Differential Oil Change',
                        'gear_oil_change' => 'Gear Oil Change',
                        'battery_service' => 'Battery Service',
                        'wheel_service' => 'Wheel Service',
                    ])
                    ->required()
                    ->live(),

                Forms\Components\DateTimePicker::make('maintenance_date')
                    ->label('Maintenance Date')
                    ->required()
                    ->default(now()),
                Forms\Components\TextInput::make('brand')
                    ->label('Brand')
                    ->visible(fn($get) => $get('type') === 'battery_service')
                    ->required(fn($get) => $get('type') === 'battery_service'),

                Forms\Components\TextInput::make('size')
                    ->label(' Size')
                    ->visible(fn($get) => $get('type') === 'battery_service')
                    ->required(fn($get) => $get('type') === 'battery_service'),
                Forms\Components\TextInput::make('wheel_name')
                    ->label('Wheel Name')
                    ->visible(fn($get) => $get('type') === 'wheel_service')
                    ->required(fn($get) => $get('type') === 'wheel_service'),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'wheel_service')
                    ->required(fn($get) => $get('type') === 'wheel_service'),

                Forms\Components\TextInput::make('wheel_size')
                    ->label('Wheel Size')
                    ->visible(fn($get) => $get('type') === 'wheel_service')
                    ->required(fn($get) => $get('type') === 'wheel_service'),

                Forms\Components\TextInput::make('oil_type')
                    ->label('Oil Type')
                    ->visible(fn($get) => $get('type') === 'gear_oil_change')
                    ->required(fn($get) => $get('type') === 'gear_oil_change'),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'gear_oil_change')
                    ->required(fn($get) => $get('type') === 'gear_oil_change'),

                Forms\Components\TextInput::make('oil_type')
                    ->label('Oil Type')
                    ->visible(fn($get) => $get('type') === 'differential_oil_change')
                    ->required(fn($get) => $get('type') === 'differential_oil_change'),

                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'differential_oil_change')
                    ->required(fn($get) => $get('type') === 'differential_oil_change'),

                Forms\Components\TextInput::make('oil_type')
                    ->label('Oil Type')
                    ->visible(fn($get) => $get('type') === 'oil_change')
                    ->required(fn($get) => $get('type') === 'oil_change'),
                Forms\Components\TextInput::make('oil_quantity')
                    ->label('Oil Quantity')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'oil_change')
                    ->required(fn($get) => $get('type') === 'oil_change'),
                Forms\Components\TextInput::make('current_km')
                    ->label('Current KM')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'oil_change')
                    ->required(fn($get) => $get('type') === 'oil_change'),
                Forms\Components\TextInput::make('next_change_km')
                    ->label('Next Change KM')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'oil_change')
                    ->required(fn($get) => $get('type') === 'oil_change'),
                Forms\Components\TextInput::make('filter')
                    ->label('Filter Type')
                    ->visible(fn($get) => $get('type') === 'oil_change')
                    ->required(fn($get) => $get('type') === 'oil_change'),
                Forms\Components\TextInput::make('oil_type')
                    ->label('Oil Type')
                    ->visible(fn($get) => $get('type') === 'transmission_oil_change')
                    ->required(fn($get) => $get('type') === 'transmission_oil_change'),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'transmission_oil_change')
                    ->required(fn($get) => $get('type') === 'transmission_oil_change'),
                Forms\Components\TextInput::make('oil_type')
                    ->label('Oil Type')
                    ->visible(fn($get) => $get('type') === 'steering_oil_change')
                    ->required(fn($get) => $get('type') === 'steering_oil_change'),
                Forms\Components\TextInput::make('quantity')
                    ->label('Quantity')
                    ->numeric()
                    ->visible(fn($get) => $get('type') === 'steering_oil_change')
                    ->required(fn($get) => $get('type') === 'steering_o il_change'),
            ])->columns(2);
    }
    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('MaintenanceRecord')
            ->columns([
                Tables\Columns\TextColumn::make('vehicle.user.name')
                    ->label('User Name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('type')
                    ->label('Maintenance Type')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('maintenance_date')
                    ->dateTime()
                    ->label('Maintenance Date')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->after(function ($record, $data) {
                        if ($record->type === 'battery_service') {
                            $record->batteryService()->create([
                                'brand' => $data['brand'],
                                'size' => $data['size'],
                            ]);
                        }
                        if ($record->type === 'wheel_service') {
                            $record->wheelService()->create([
                                'wheel_name' => $data['wheel_name'],
                                'quantity' => $data['quantity'],
                                'wheel_size' => $data['wheel_size'],
                            ]);
                        }
                        if ($record->type === 'gear_oil_change') {
                            $record->gearOilChange()->create([
                                'oil_type' => $data['oil_type'],
                                'quantity' => $data['quantity'],
                            ]);
                        }
                        if ($record->type === 'differential_oil_change') {
                            $record->differentialOilChange()->create([
                                'oil_type' => $data['oil_type'],
                                'quantity' => $data['quantity'],
                            ]);
                        }
                        if ($record->type === 'oil_change') {
                            $record->oilChange()->create([
                                'oil_type' => $data['oil_type'],
                                'oil_quantity' => $data['oil_quantity'],
                                'current_km' => $data['current_km'],
                                'next_change_km' => $data['next_change_km'],
                                'filter' => $data['filter'],
                            ]);
                        }
                        if ($record->type === 'transmission_oil_change') {
                            $record->transmissionOilChange()->create([
                                'oil_type' => $data['oil_type'],
                                'quantity' => $data['quantity'],
                            ]);
                        }
                        if ($record->type === 'steering_oil_change') {
                            $record->steeringOilChange()->create([
                                'oil_type' => $data['oil_type'],
                                'quantity' => $data['quantity'],
                            ]);
                        }
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
