<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource;

class EditBooking extends BaseEditRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Редактирование заявки';
}
