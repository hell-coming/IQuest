<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGenres extends ListRecords
{
    protected static string $resource = GenreResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
