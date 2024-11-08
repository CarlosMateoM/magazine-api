<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\Article\ArticleService;
use App\Services\Article\ArticleViewService;
use Illuminate\Http\Request;


class ArticleViewController extends Controller
{

    public function __construct(
        private ArticleService $articleService,
        private ArticleViewService $articleViewService
    )
    {}

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mostViewedArticles = $this->articleService->getMostViewedArticles(5);

        return ArticleResource::collection($mostViewedArticles);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Article $article, Request $request)
    {
        $this->articleViewService->createArticleView($article, $request);

        return response()->json(['message' => 'Article viewed']);
    }
}
