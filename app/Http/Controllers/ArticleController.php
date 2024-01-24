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
        
        return response()->json([
            'articles' => ArticleResource::collection($articles)
        ]);
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
        $article->file_id = $request->fileId;
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
            'file',
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
        $article->file_id = $request->image['id'];
        $article->category_id = $request->category['id'];
        
        /*
        TODO: Fix this when update    
        $article->author_id = $request->author['id'];
        $article->municipality_id = $request->municipalityId;
        */

        $article->save();

        $article->load([
            'file',
            'author',
            'category',
            'municipality'
        ]);

        return response()->json(new ArticleResource($article), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $article->delete();
    }
}
