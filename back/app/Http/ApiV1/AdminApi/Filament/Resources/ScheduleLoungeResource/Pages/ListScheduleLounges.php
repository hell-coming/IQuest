<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListScheduleLounges extends ListRecords
{
    protected static string $resource = ScheduleLoungeResource::class;

    protected ?string $heading = 'Расписание лаунжей';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
