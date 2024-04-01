<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Holidays\Models\HolidayPackage;

/**
 * Class CreateBookingAction
 *
 * @property CheckBookingAction $checkBookingAction
 */
readonly class CreateBookingAction
{
    public function __construct(private CheckBookingAction $checkBookingAction)
    {

    }

    public function execute(array $data): Booking
    {
        $this->checkBookingAction->execute($data);

        $booking = Booking::create([...$data['booking'], 'status' => BookingStatus::NEW->value]);

        if ($booking->type->value == BookingType::QUEST->value && $data['schedule_quest']) {
            $booking->bookingScheduleQuest()->create([...$data['schedule_quest'], 'booking_id' => $booking->id]);
        } else if ($booking->type->value == BookingType::LOUNGE->value) {
            resolve(SendMessageBookingAction::class)->execute($booking);
        } else if ($booking->type->value == BookingType::HOLIDAY->value && $data['holiday']) {
            $this->createBookingHoliday($booking, $data);
        } else if ($booking->type->value == BookingType::CERTIFICATE->value && $data['certificate_type_id']) {
            $booking->bookingCertificate()->create([
                'certificate_type_id' => $data['certificate_type_id'],
                'booking_id' => $booking->id
            ]);
        }

        return $booking;
    }

    private function createBookingHoliday(Booking $booking, array $data): void
    {
        $holidayPackagedId = HolidayPackage::query()
            ->where('holiday_id', $data['holiday']['holiday_id'])
            ->where('package_id', $data['holiday']['package_id'])
            ->firstOrFail()
            ->id;
        unset($data['holiday']['holiday_id'], $data['holiday']['package_id']);

        $booking->bookingHoliday()->create([
            'booking_id' => $booking->id,
            'holiday_package_id' => $holidayPackagedId,
        ]);
    }
}
