<?php

namespace App\Domain\Contacts\Policies;

use App\Domain\Contacts\Models\ContactType;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class ContactTypePolicy
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
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ContactType $contactType): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ContactType $contactType): bool
    {
        return false;
    }
}
