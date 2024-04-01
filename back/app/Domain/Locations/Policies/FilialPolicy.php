<?php

namespace App\Domain\Locations\Policies;

use App\Domain\Locations\Models\Filial;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class FilialPolicy
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
    public function update(User $user, Filial $filial): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Filial $filial): bool
    {
        return $user->role === Role::ADMIN
            && $filial->quests()->withTrashed()->doesntExist()
            && $filial->lounges()->withTrashed()->doesntExist();
    }
}
