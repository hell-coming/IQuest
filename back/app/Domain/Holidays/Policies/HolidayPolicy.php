<?php

namespace App\Domain\Holidays\Policies;

use App\Domain\Holidays\Enums\HolidayType;
use App\Domain\Holidays\Models\Holiday;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class HolidayPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Holiday $holiday): bool
    {
        return $user->role !== Role::ADMIN && $holiday->type !== HolidayType::CORPORATE;
    }

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
    public function update(User $user, Holiday $holiday): bool
    {
        return $user->role === Role::ADMIN && $holiday->type !== HolidayType::CORPORATE;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Holiday $holiday): bool
    {
        return $user->role === Role::ADMIN;
    }
}
