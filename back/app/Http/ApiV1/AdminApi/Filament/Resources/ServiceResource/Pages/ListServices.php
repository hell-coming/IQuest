<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListServices extends ListRecords
{
    protected static string $resource = ServiceResource::class;

    protected ?string $heading = 'Доп. услуги';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
