<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource;

class CreateSale extends BaseCreateRecord
{
    protected static string $resource = SaleResource::class;

    protected ?string $heading = 'Создание акции';
}
