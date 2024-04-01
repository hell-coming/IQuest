<?php

namespace App\Domain\Holidays\Policies;

use App\Domain\Holidays\Models\Package;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class PackagePolicy
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
    public function view(User $user, Package $package): bool
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
    public function update(User $user, Package $package): bool
    {
        return $user->role === Role::ADMIN && !$package->trashed();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Package $package): bool
    {
        return $user->role === Role::ADMIN;
    }
}
