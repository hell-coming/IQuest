<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListLounges extends ListRecords
{
    protected static string $resource = LoungeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
