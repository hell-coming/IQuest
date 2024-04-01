<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\QuestResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQuests extends ListRecords
{
    protected static string $resource = QuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
