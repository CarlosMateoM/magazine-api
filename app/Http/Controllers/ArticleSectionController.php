<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleSectionRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Section;
use App\Services\ArticleSectionService;
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
    public function index(Section $section)
    {
        $articles = $this->articleSectionService->getArticlesBySection($section);

        return ArticleResource::collection($articles)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Section $section, StoreArticleSectionRequest $request)
    {
        $this->articleSectionService->attachArticleToSection($section, $request);

        $section->articles()->attach($request->article_id);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Section $section, Article $article)
    {
        
    }
}
