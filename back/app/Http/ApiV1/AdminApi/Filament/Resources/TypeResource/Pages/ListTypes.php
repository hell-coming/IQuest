<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTypes extends ListRecords
{
    protected static string $resource = TypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
