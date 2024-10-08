<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Services\Article\ArticleService;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    public function __construct(
        private ArticleService $articleService
    ) {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articles = $this->articleService->getArticles($request);

        return ArticleResource::collection($articles)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $article = $this->articleService->createArticle($request);

        return new ArticleResource($article);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article = $this->articleService->getArticle($article);

        return new ArticleResource($article);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article = $this->articleService->updateArticle($request, $article);

        return new ArticleResource($article);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->articleService->deleteArticle($article);

        return response()->noContent();
    }
}
