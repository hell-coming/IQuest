<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
