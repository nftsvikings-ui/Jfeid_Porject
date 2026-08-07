<?php

namespace App\Filament\Resources\MaintenanceRecordResource\Pages;

use App\Filament\Resources\MaintenanceRecordResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMaintenanceRecord extends CreateRecord
{
    protected static string $resource = MaintenanceRecordResource::class;

    protected function afterCreate(): void
    {
        // previously only battery_service was handled here, so wheel services
        // and every oil change type were created without their detail row and
        // came back null in the API.
        $this->record->syncTypeDetails($this->data);
    }
}
