<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource;
use Filament\Resources\Pages\EditRecord;

class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected ?string $heading = 'Редактирование праздника';
}
