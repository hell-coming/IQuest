<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource;
use Filament\Resources\Pages\CreateRecord;

class CreateQuest extends CreateRecord
{
    protected static string $resource = QuestResource::class;

    protected ?string $heading = 'Создание квеста';
}
