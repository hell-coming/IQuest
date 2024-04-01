<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\ScheduleLoungeResource;
use Filament\Resources\Pages\CreateRecord;

class CreateScheduleLounge extends CreateRecord
{
    protected static string $resource = ScheduleLoungeResource::class;

    protected ?string $heading = 'Создание слота';
}
