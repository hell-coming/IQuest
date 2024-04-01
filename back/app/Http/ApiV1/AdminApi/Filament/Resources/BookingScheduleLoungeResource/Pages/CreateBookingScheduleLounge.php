<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateBookingScheduleLounge extends CreateRecord
{
    protected static string $resource = BookingScheduleLoungeResource::class;
}
