<?php

namespace App\Domain\Bookings\Policies;

use App\Domain\Bookings\Models\BookingScheduleLounge;
use App\Domain\Users\Models\User;

class BookingScheduleLoungePolicy
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
    public function update(User $user, BookingScheduleLounge $booking): bool
    {
        return false;
    }
}
