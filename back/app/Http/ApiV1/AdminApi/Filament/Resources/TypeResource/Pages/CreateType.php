<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource;

class CreateType extends BaseCreateRecord
{
    protected static string $resource = TypeResource::class;

    protected ?string $heading = 'Создание типа';
}
