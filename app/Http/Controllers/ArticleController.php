<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\AllowedFilter;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $query = QueryBuilder::for(Article::class)
            ->allowedFilters([
                'title',
                'content',
                AllowedFilter::exact('status'),
                'summary',
                'published_at',
                'author_id',
                'category_id',
                'file_id',
                'municipality_id'
            ])
            ->allowedIncludes([
                'file',
                'author',
                'category',
                'municipality'
            ]);

        if ($request->has('paginate')) {
            $query = $query->paginate($request->paginate);
        } else  {
            $query = ArticleResource::collection($query->get());
        }

        return response()->json($query);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
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
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $article->title = $request->title;
        $article->content = $request->content;
        $article->status = $request->status;
        $article->summary = $request->summary;
        Log::info('Valor de status antes de llamar a updatePublishedAt: ' . $article->status);
        $article->updatePublishedAt();       
        $article->file_id = $request->image['id'];
        $article->category_id = $request->category['id'];

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
