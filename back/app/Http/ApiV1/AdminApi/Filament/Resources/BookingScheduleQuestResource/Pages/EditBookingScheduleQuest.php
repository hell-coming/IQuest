<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingScheduleQuestResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBookingScheduleQuest extends EditRecord
{
    protected static string $resource = BookingScheduleQuestResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
