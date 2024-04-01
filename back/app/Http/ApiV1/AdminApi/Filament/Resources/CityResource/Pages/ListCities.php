<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCities extends ListRecords
{
    protected static string $resource = CityResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
