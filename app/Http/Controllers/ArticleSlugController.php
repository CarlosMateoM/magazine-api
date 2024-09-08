<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleSlugController extends Controller
{

    public function __construct(
        private ArticleService $articleService
    ) {}


    public function __invoke($slug)
    {
        $article = $this->articleService->findArticleBySlug($slug);

        $this->authorize('showArticleSlug', $article);

        return new ArticleResource($article);
    }

}
