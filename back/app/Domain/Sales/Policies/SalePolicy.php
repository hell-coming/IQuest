<?php

namespace App\Domain\Sales\Policies;

use App\Domain\Sales\Models\Sale;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class SalePolicy
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
    public function view(User $user, Sale $sale): bool
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
    public function update(User $user, Sale $sale): bool
    {
        return $user->role === Role::ADMIN;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Sale $sale): bool
    {
        return $user->role === Role::ADMIN;
    }
}
