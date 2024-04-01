<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\SaleResource;

class EditSale extends BaseEditRecord
{
    protected static string $resource = SaleResource::class;

    protected ?string $heading = 'Редактирование акции';
}
