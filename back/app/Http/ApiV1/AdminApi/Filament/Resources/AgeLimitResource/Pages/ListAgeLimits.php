<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAgeLimits extends ListRecords
{
    protected static string $resource = AgeLimitResource::class;

    protected ?string $heading = 'Возрастные ограничения';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
