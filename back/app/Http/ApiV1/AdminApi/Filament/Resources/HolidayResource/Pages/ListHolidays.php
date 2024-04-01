<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\HolidayResource;
use Filament\Resources\Pages\ListRecords;

class ListHolidays extends ListRecords
{
    protected static string $resource = HolidayResource::class;
}
