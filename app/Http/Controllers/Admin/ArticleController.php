<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;
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
                'published_at',
                'category.name',
                AllowedFilter::exact('sections.name'),
                AllowedFilter::exact('status'),
            ])
            ->allowedIncludes([
                'file',
                'author',
                'category',
                'municipality'
            ]);

        if ($request->has('paginate')) {
            $articles = $query->paginate($request->paginate);
            return response()->json(
                new ArticleCollection($articles)
            );
        } else {
            return response()->json(ArticleResource::collection($query->get()));
        }
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
        $article->slug = Str::slug($request->title);
        $article->municipality_id = $request->municipalityId;

        $article->save();

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($article)
    {
        $article = Article::Where('id', $article)
            ->orWhere('slug', $article)
            ->firstOrFail();

        $article->load([
            'file',
            'author',
            'category',
            'sections',
            'municipality.department'
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
        $article->updatePublishedAt();
        $article->slug = Str::slug($request->title);
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
