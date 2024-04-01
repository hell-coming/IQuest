<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Domain\Bookings\Models\Booking;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseCreateRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;
use Illuminate\Database\Eloquent\Model;

class CreateBookingCertificate extends BaseCreateRecord
{
    protected static string $resource = BookingCertificateResource::class;

    protected ?string $heading = 'Создание заявки на сертификат';

    protected function handleRecordCreation(array $data): Model
    {
        $saveData['booking_id'] = Booking::create($data['booking'][0])->id;
        $saveData['certificate_type_id'] = $data['certificateType'][0]['certificate_type_id'];
        return parent::handleRecordCreation($saveData);
    }
}
