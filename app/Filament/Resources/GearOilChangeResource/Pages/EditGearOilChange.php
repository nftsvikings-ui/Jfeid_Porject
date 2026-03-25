<?php

namespace App\Filament\Resources\GearOilChangeResource\Pages;

use App\Filament\Resources\GearOilChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGearOilChange extends EditRecord
{
    protected static string $resource = GearOilChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
