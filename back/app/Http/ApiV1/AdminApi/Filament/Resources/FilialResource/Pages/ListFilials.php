<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFilials extends ListRecords
{
    protected static string $resource = FilialResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
