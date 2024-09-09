<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleSectionRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Section;
use App\Services\Article\ArticleSectionService;
use Illuminate\Http\Request;

class ArticleSectionController extends Controller
{

    public function __construct(
        private ArticleSectionService $articleSectionService
    )
    {
        $this->authorizeResource(Section::class);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Section $section, Request $request)
    {
        $articles = $this->articleSectionService->getArticlesBySection($section, $request);

        return ArticleResource::collection($articles)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Section $section, StoreArticleSectionRequest $request)
    {
        $this->articleSectionService->attachArticleToSection($section, $request);

        return response()->json(['message' => 'Article attached to section successfully'], 201);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, Article $article)
    {
        $this->articleSectionService->detachArticleFromSection($section, $article);

        return response()->json(['message' => 'Article detached from section successfully'], 200);
    }
}
