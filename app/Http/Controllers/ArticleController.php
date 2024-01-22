<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $articles = Article::all();
        
        return response()->json(['articles' => $articles]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $article = new Article();

        $article->title = $request->title;
        $article->content = $request->content;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->author_id = $request->authorId;
        $article->category_id = $request->categoryId;
        $article->image_id = $request->image['id'];
        $article->municipality_id = $request->municipalityId;

        $article->save();

        return response()->json($article, 201);
    }
    
    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        $article->load([
            'image',
            'author',
            'category',
            'municipality'
        ]);

        return response()->json(new ArticleResource($article));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Article $article)
    {
        $article->title = $request->title;
        $article->content = $request->content;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->published_at = $request->publishedAt;
        /*TODO: Fix this when update    
        $article->author_id = $request->authorId;
        $article->category_id = $request->categoryId;
        $article->image_id = $request->imageId;
        $article->municipality_id = $request->municipalityId;
        */

        $article->save();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
