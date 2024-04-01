<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingHolidays extends ListRecords
{
    protected static string $resource = BookingHolidayResource::class;

    protected ?string $heading = 'Заявки на праздники';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
