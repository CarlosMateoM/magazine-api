<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{

    /**
     * Display the specified resource.
     */
    public function show(String $slug, Request $request)
    {
        $article = Article::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $article->load([
            'file',
            'author',
            'category',
            'municipality.department'
        ]);

        return response()->json(new ArticleResource($article));
    }
}
