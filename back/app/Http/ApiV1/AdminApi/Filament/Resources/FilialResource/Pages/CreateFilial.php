<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource;

class CreateFilial extends BaseCreateRecord
{
    protected static string $resource = FilialResource::class;

    protected ?string $heading = 'Создание филиала';
}
