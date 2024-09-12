<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Keyword;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class KeywordPolicy
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
    public function view(User $user, Keyword $keyword): bool
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
    public function update(User $user, Keyword $keyword): bool
    {
        return $user->hasAnyRole([
            RoleType::ADMIN->value,
            RoleType::WRITER->value
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Keyword $keyword): bool
    {
        return $user->hasAnyRole([
            RoleType::ADMIN->value,
            RoleType::WRITER->value
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Keyword $keyword): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Keyword $keyword): bool
    {
        return false;
    }
}