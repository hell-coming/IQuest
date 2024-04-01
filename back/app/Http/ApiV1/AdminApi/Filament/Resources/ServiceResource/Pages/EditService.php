<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource;

class EditService extends BaseEditRecord
{
    protected static string $resource = ServiceResource::class;

    protected ?string $heading = 'Редактирование услуги';
}
