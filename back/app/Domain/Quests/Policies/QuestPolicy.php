<?php

namespace App\Domain\Quests\Policies;

use App\Domain\Quests\Models\Quest;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class QuestPolicy
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
    public function view(User $user, Quest $quest): bool
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
    public function update(User $user, Quest $quest): bool
    {
        return $user->role === Role::ADMIN && !$quest->trashed();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Quest $quest): bool
    {
        return $user->role === Role::ADMIN;
    }
}
