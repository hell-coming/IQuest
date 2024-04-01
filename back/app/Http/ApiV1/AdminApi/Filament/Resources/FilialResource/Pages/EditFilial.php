<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\FilialResource;

class EditFilial extends BaseEditRecord
{
    protected static string $resource = FilialResource::class;

    protected ?string $heading = 'Редактирование филиала';
}
