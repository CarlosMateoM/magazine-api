<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleCollection;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Str;
use Spatie\QueryBuilder\AllowedFilter;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                'user.id',
                AllowedFilter::exact('sections.name'),
                AllowedFilter::exact('status'),
            ])
            ->allowedIncludes([
                'file',
                'author',
                'category',
                'municipality',
                'advertisements.file'
            ])
            ->allowedSorts([
                'title',
                'published_at',
                'created_at'
            ]);

        if ($request->user()->hasRole('reader')) {
            $query->where('status', 'published');
        }


        if ($request->has('paginate')) {
            $articles = $query->paginate($request->paginate);
            return response()->json(
                new ArticleCollection($articles)
            );
        } else {
            return response()->json(
                ArticleResource::collection($query->get())
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $this->authorize('create', Article::class, $request->user());

        $article = new Article();

        $article->title = $request->title;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);

        $article->user_id = $request->user()->id;
        $article->file_id = $request->image['id'];
        $article->author_id = $request->author['id'];
        $article->category_id = $request->category['id'];
        $article->municipality_id = $request->municipality['id'];

        $article->updatePublishedAt();

        $article->save();

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show($article, Request $request)
    {
        $article = Article::Where('id', $article)
            ->orWhere('slug', $article)
            ->firstOrFail();

        $article->load([
            'file',
            'author',
            'sections',
            'category',
            'galleries.file',
            'municipality.department',
            'advertisements.advertisement.files.file'
        ]);

        if ($request->user()->hasRole('reader') && $article->isPublished()) {
            throw new NotFoundHttpException('No query results for model.');
        }

        return response()->json(new ArticleResource($article));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article, $request->user());

        $article->title = $request->title;
        $article->content = $request->content;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->slug = Str::slug($request->title);
        
        $article->file_id = $request->image['id'];
        $article->author_id = $request->author['id'];
        $article->category_id = $request->category['id'];
        $article->municipality_id = $request->municipality['id'];

        $article->updatePublishedAt();
        
        $article->save();

        $article->load([
            'file',
            'author',
            'category',
            'municipality.department'
        ]);

        return response()->json(new ArticleResource($article), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article, request()->user());

        $article->delete();
    }
}
