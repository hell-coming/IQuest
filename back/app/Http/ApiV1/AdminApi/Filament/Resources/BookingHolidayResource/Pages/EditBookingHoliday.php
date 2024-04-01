<?php

namespace App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource\Pages;

use App\Domain\Bookings\Models\Booking;
use App\Domain\Bookings\Models\BookingHoliday;
use App\Domain\Holidays\Models\HolidayPackage;
use App\Http\ApiV1\AdminApi\Filament\AbstractClasses\BaseEditRecord;
use App\Http\ApiV1\AdminApi\Filament\Resources\BookingHolidayResource;

class EditBookingHoliday extends BaseEditRecord
{
    protected static string $resource = BookingHolidayResource::class;

    protected ?string $heading = 'Редактирование заявки на праздник';

    protected function mutateFormDataBeforeFill(array $data): array
    {
        $record = $this->getRecord();

        if ($record->holidayPackage->trashed()) {
            $this->form->getComponent('holidayPackage')->hidden();
        }

        return $data;
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        Booking::find($this->record->booking->id)->update($data['booking'][0]);
        $data['holiday_package_id'] = HolidayPackage::query()
            ->where('holiday_id', $data['holidayPackage'][0]['holiday'])
            ->where('package_id', $data['holidayPackage'][0]['package'])
            ->firstOrFail()
            ->id;
        unset($data['holidayPackage']);
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
        $state['booking'][0] = BookingHoliday::find($this->record->id)->booking;
        $state['holidayPackage'][0]['holiday'] = BookingHoliday::find($this->record->id)->holidayPackage->holiday_id;
        $state['holidayPackage'][0]['package'] = BookingHoliday::find($this->record->id)->holidayPackage->package_id;
        $this->form->fill($state);
    }
}
