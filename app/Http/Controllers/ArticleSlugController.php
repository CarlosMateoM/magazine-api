<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleSlugController extends Controller
{

    public function __construct(
        private ArticleService $articleService
    ) {}


    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        $article = $this->articleService->findArticleBySlug($slug);

        $this->authorize('showArticleSlug', $article);
        
        return response()->json(new ArticleResource($article), 200);
    }
}
