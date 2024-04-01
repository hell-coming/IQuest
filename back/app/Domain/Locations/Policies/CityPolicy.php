<?php

namespace App\Domain\Locations\Policies;

use App\Domain\Locations\Models\City;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class CityPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, City $city): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, City $city): bool
    {
        return $user->role === Role::ADMIN
            && $city->filials()->doesntExist()
            && $city->contacts()->doesntExist()
            && $city->sales()->doesntExist()
            && $city->services()->doesntExist();
    }
}
