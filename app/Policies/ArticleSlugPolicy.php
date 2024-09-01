<?php

namespace App\Policies;

use App\Enums\RoleType;
use App\Models\Article;
use App\Models\User;

class ArticleSlugPolicy
{

    public function show(User $user, Article $article): bool
    {
        return $user->hasAnyRole([
            RoleType::ADMIN->value,
            RoleType::WRITER->value,
        ])
        || $user->hasRole(RoleType::READER->value) && $article->isPublished();
    }
}
