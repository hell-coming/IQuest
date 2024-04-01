<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBookingCertificates extends ListRecords
{
    protected static string $resource = BookingCertificateResource::class;

    protected ?string $heading = 'Заявки на сертификаты';

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()->label('Создать'),
        ];
    }
}
