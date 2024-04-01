<?php

namespace App\Domain\Lounges\Policies;

use App\Domain\Lounges\Models\Lounge;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class LoungePolicy
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
    public function view(User $user, Lounge $lounge): bool
    {
        return $user->role !== Role::ADMIN;
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
    public function update(User $user, Lounge $lounge): bool
    {
        return $user->role === Role::ADMIN && !$lounge->trashed();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Lounge $lounge): bool
    {
        return $user->role === Role::ADMIN;
    }
}
