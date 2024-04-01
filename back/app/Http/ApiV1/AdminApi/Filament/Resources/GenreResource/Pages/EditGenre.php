<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\GenreResource;

class EditGenre extends BaseEditRecord
{
    protected static string $resource = GenreResource::class;

    protected ?string $heading = 'Редактирование жанра';
}
