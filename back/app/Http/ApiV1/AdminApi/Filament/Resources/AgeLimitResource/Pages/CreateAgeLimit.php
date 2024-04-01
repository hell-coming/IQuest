<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource;

class CreateAgeLimit extends BaseCreateRecord
{
    protected static string $resource = AgeLimitResource::class;

    protected ?string $heading = 'Создание возрастного ограничения';
}
