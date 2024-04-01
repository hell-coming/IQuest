<?php

namespace App\Domain\Schedules\Policies;

use App\Domain\Schedules\Models\ScheduleLounge;
use App\Domain\Users\Models\User;

class ScheduleLoungePolicy
{
    public function update(User $user, ScheduleLounge $scheduleLounge): bool
    {
        return !$scheduleLounge->trashed();
    }

    public function delete(User $user, ScheduleLounge $scheduleLounge): bool
    {
        return $scheduleLounge->booking()->doesntExist();
    }
}
