<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSales extends ListRecords
{
    protected static string $resource = SaleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
