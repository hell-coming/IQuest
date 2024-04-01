<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\ServiceResource;

class CreateService extends BaseCreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected ?string $heading = 'Создание услуги';
}
