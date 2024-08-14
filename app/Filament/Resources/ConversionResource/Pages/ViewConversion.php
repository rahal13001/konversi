<?php

namespace App\Filament\Resources\ConversionResource\Pages;

use App\Filament\Resources\ConversionResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewConversion extends ViewRecord
{
    protected static string $resource = ConversionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
