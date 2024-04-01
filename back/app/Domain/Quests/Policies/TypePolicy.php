<?php

namespace App\Domain\Quests\Policies;

use App\Domain\Quests\Models\Type;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class TypePolicy
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
    public function update(User $user, Type $type): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Type $type): bool
    {
        return $user->role === Role::ADMIN && $type->quests()->doesntExist();
    }
}
