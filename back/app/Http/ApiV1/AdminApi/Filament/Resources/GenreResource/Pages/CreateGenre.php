<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource;

class CreateGenre extends BaseCreateRecord
{
    protected static string $resource = GenreResource::class;

    protected ?string $heading = 'Создание жанра';
}
