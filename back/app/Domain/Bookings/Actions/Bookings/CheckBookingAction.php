<?php

namespace App\Domain\Bookings\Actions\Bookings;

use App\Domain\Bookings\Enums\BookingStatus;
use App\Domain\Bookings\Enums\BookingType;
use App\Domain\Bookings\Models\Booking;
use App\Domain\Holidays\Models\HolidayPackage;
use App\Domain\Schedules\Models\ScheduleQuest;
use App\Domain\Schedules\Models\Timeslot;
use Exception;

class CheckBookingAction
{
    /**
     * @throws Exception
     */
    public function execute(array $data): void
    {
        if ($data['booking']['type'] == BookingType::QUEST->value) {
            $this->checkBookingQuest($data['schedule_quest']['timeslot_id']);
        }
    }

    private function checkBookingQuest(int $timeslotId): void
    {
        $timeslot = Timeslot::findOrFail($timeslotId)->booking()->exists();
        if ($timeslot) {
            throw new Exception('Timeslot already booked');
        }
    }
}
