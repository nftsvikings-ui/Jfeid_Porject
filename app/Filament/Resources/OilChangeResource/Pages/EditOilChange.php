<?php

namespace App\Filament\Resources\OilChangeResource\Pages;

use App\Filament\Resources\OilChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditOilChange extends EditRecord
{
    protected static string $resource = OilChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
