<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\CityResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\CityResource;

class EditCity extends BaseEditRecord
{
    protected static string $resource = CityResource::class;

    protected ?string $heading = 'Редактирование города';
}
