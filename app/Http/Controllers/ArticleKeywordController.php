<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleKeywordRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Keyword;
use App\Services\Article\ArticleKeywordService;

class ArticleKeywordController extends Controller
{

    public function __construct(
        private ArticleKeywordService $articleKeywordService
    )
    {
        $this->authorizeResource(Article::class, 'article');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Article $article)
    {
        $articles = $this->articleKeywordService->getKeywordsByArticle($article);

        return ArticleResource::collection($articles)->resource;
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Article $article, StoreArticleKeywordRequest $request)
    {
        $this->articleKeywordService->attachKeywordToArticle($article, $request);

        return response()->json(['message' => 'Keyword attached to article successfully'], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article, Keyword $keyword)
    {
        $this->articleKeywordService->detachKeywordFromArticle($article, $keyword);

        return response()->json(['message' => 'Keyword detached from article successfully'], 200);
    }

}
