<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\LoungeResource;

class CreateLounge extends BaseCreateRecord
{
    protected static string $resource = LoungeResource::class;

    protected ?string $heading = 'Создание лаунжа';
}
