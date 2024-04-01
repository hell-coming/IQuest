<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingResource;

class CreateBooking extends BaseCreateRecord
{
    protected static string $resource = BookingResource::class;

    protected ?string $heading = 'Создание заявки';
}
