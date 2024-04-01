<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource;
use Filament\Resources\Pages\CreateRecord;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;
}
