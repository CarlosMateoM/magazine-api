<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Article;
use App\Models\User;

class ArticlePolicy
{

    public function viewAny(User $user): bool
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
    public function update(User $user, Article $article): bool
    {
        return $user->hasRole(RoleType::ADMIN->value)
            || $user->hasRole(RoleType::WRITER->value)
            && $user->id === $article->user_id;
    }


    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Article $article): bool
    {
        return $user->hasRole(RoleType::ADMIN->value)
            || $user->hasRole(RoleType::WRITER->value)
            && $user->id === $article->user_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Article $article): bool
    {
        return $user->hasRole(RoleType::ADMIN->value)
            || $user->hasRole(RoleType::WRITER->value)
            && $user->id === $article->user_id;
    }
}
