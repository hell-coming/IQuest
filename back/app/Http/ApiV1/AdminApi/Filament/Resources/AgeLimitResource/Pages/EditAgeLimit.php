<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\AgeLimitResource;

class EditAgeLimit extends BaseEditRecord
{
    protected static string $resource = AgeLimitResource::class;

    protected ?string $heading = 'Редактирование возрастного ограничения';
}
