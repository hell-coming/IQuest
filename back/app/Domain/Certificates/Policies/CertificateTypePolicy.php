<?php

namespace App\Domain\Certificates\Policies;

use App\Domain\Certificates\Models\CertificateType;
use App\Domain\Users\Enums\Role;
use App\Domain\Users\Models\User;

class CertificateTypePolicy
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
    public function view(User $user, CertificateType $certificateType): bool
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
    public function update(User $user, CertificateType $certificateType): bool
    {
        return $user->role === Role::ADMIN && !$certificateType->trashed();
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, CertificateType $certificateType): bool
    {
        return $user->role === Role::ADMIN;
    }
}
