<?php

namespace App\Filament\Resources\MaintenanceRecordResource\Pages;

use App\Filament\Resources\MaintenanceRecordResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceRecord extends CreateRecord
{
    protected static string $resource = MaintenanceRecordResource::class;
protected function afterCreate(): void
{
    $record = $this->record;

    if ($record->type === 'battery_service') {
        $record->batteryService()->create([
            'brand' => 'Default Brand',
            'size' => 'Default Size',
        ]);
    }
}
}
