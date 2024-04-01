<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleLoungeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingScheduleLounge extends EditRecord
{
    protected static string $resource = BookingScheduleLoungeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
