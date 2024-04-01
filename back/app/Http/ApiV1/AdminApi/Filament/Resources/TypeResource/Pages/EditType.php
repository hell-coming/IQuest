<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\TypeResource;

class EditType extends BaseEditRecord
{
    protected static string $resource = TypeResource::class;

    protected ?string $heading = 'Редактирование типа';
}
