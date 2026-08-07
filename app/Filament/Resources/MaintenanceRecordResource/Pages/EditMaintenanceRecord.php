<?php

namespace App\Filament\Resources\MaintenanceRecordResource\Pages;

use App\Filament\Resources\MaintenanceRecordResource;
use App\Models\MaintenanceRecord;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditMaintenanceRecord extends EditRecord
{
    protected static string $resource = MaintenanceRecordResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    /**
     * The type-specific fields (wheel_name, oil_type, ...) live on the detail
     * tables, not on maintenance_records, so they are absent from the record's
     * attributes and the form would otherwise open blank.
     *
     * @param array<string, mixed> $data
     * @return array<string, mixed>
     */
    protected function mutateFormDataBeforeFill(array $data): array
    {
        $detail = MaintenanceRecord::TYPE_DETAILS[$this->getRecord()->type] ?? null;

        if ($detail === null) {
            return $data;
        }

        $related = $this->getRecord()->{$detail['relation']};

        if ($related === null) {
            return $data;
        }

        foreach ($detail['fields'] as $field) {
            $data[$field] = $related->{$field};
        }

        return $data;
    }

    protected function afterSave(): void
    {
        $this->record->syncTypeDetails($this->data);
    }
}
