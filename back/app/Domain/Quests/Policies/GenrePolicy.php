<?php

namespace App\Domain\Quests\Policies;

use App\Domain\Quests\Models\Genre;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class GenrePolicy
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
    public function update(User $user, Genre $genre): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Genre $genre): bool
    {
        return $user->role === Role::ADMIN && $genre->quests()->doesntExist();
    }
}
