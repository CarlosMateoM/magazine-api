<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepartmentPolicy
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
    public function view(User $user, Department $Department): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->hasAnyRole([
            RoleType::ADMIN->value,
            RoleType::WRITER->value
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Department $Department): bool
    {
        return $user->hasAnyRole([
            RoleType::ADMIN->value,
            RoleType::WRITER->value
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Department $Department): bool
    {
        return $user->hasAnyRole([
            RoleType::ADMIN->value,
            RoleType::WRITER->value
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Department $Department): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Department $Department): bool
    {
        return false;
    }
}
