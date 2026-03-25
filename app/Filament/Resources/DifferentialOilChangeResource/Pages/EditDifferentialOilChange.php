<?php

namespace App\Filament\Resources\DifferentialOilChangeResource\Pages;

use App\Filament\Resources\DifferentialOilChangeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDifferentialOilChange extends EditRecord
{
    protected static string $resource = DifferentialOilChangeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
