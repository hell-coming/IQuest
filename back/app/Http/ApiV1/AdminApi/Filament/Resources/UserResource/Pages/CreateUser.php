<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\UserResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\UserResource;

class CreateUser extends BaseCreateRecord
{
    protected static string $resource = UserResource::class;

    protected ?string $heading = 'Создание пользователя';
}
