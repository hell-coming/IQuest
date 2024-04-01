<?php

namespace App\Domain\Bookings\Policies;

use App\Domain\Bookings\Models\BookingScheduleQuest;
use App\Domain\Users\Models\User;

class BookingScheduleQuestPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, BookingScheduleQuest $booking): bool
    {
        return false;
    }
}
