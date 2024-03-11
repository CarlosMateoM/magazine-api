<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleSectionRequest;
use App\Models\ArticleSection;
use Illuminate\Http\Request;

class ArticleSectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articleSections = ArticleSection::all();

        return response()->json($articleSections);  
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleSectionRequest $request)
    {
        $articleSection = new ArticleSection();

        $articleSection->article_id = $request->articleId;
        $articleSection->section_id = $request->sectionId;

        $articleSection->save();
    }

    /**
     * Display the specified resource.
     */
    public function show(ArticleSection $articleSection)
    {
        $articleSection->load('article', 'section');

        return response()->json($articleSection);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArticleSection $articleSection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArticleSection $articleSection)
    {
        //
    }
}
