<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource\Pages;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingCertificate;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingCertificateResource;

class EditBookingCertificate extends BaseEditRecord
{
    protected static string $resource = BookingCertificateResource::class;

    protected ?string $heading = 'Редактирование заявки на сертификат';

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Booking::find($this->record->booking->id)->update($data['booking'][0]);
        return parent::mutateFormDataBeforeSave($data);
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);
        $this->fillState();
    }

    private function fillState(): void
    {
        $state = $this->form->getState();
        $state['booking'][0] = BookingCertificate::find($this->record->id)->booking;
        $state['certificateType'][0] = BookingCertificate::find($this->record->id)->certificateType;
        $this->form->fill($state);
    }
}
