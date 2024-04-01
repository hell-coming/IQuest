<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource;
use Filament\Resources\Pages\ViewRecord;

class ViewHoliday extends ViewRecord
{
    protected static string $resource = HolidayResource::class;

    protected ?string $heading = 'Просмотр праздника';
}
