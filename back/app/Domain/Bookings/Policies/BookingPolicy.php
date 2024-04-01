<?php

namespace App\Domain\Bookings\Policies;

use App\Domain\Users\Models\User;

class BookingPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return false;
    }
}
