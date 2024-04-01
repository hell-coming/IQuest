<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;

class CreateCity extends BaseCreateRecord
{
    protected static string $resource = CityResource::class;

    protected ?string $heading = 'Создание города';
}
