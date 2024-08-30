<?php

namespace App\Policies;

use App\Models\Article;
use App\Models\User;

class ArticleSlugPolicy
{

    public function show(User $user, Article $article): bool
    {
        return $article->isPublished();
    }
}
