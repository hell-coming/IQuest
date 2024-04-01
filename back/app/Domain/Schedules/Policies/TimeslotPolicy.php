<?php

namespace App\Domain\Schedules\Policies;

use App\Domain\Schedules\Models\Timeslot;
use App\Domain\Users\Models\User;

class TimeslotPolicy
{
    public function create(User $user): bool
    {
        return false;
    }

    public function update(User $user, Timeslot $timeslot): bool
    {
        return !$timeslot->trashed();
    }
}
