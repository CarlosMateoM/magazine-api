<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\Category;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleController extends Controller
{

    public function __construct(
        private ArticleService $articleService
    ) {}


    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $articles = $this->articleService->getArticles($request);

        return ArticleResource::collection($articles)->resource;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        $this->authorize('create', Article::class, $request->user());

        $article = new Article();

        if ($request->category['id'] !== Category::where('name', 'opinion')->first()->id) {

            $request->validate([
                'image.id' => 'required|exists:files,id'
            ]);

            $article->file_id = $request->image['id'];
        }

        $article->title = $request->title;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->content = $request->content;
        $article->user_id = $request->user()->id;
        $article->slug = Str::slug($request->title);
        $article->author_id = $request->author['id'];
        $article->category_id = $request->category['id'];
        $article->municipality_id = $request->municipality['id'];
        $article->published_at = $request->publishedAt;

        $article->save();

        return response()->json($article, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article, Request $request)
    {       
        $this->authorize('show', Article::class, $request->user());

        /* Article::Where('id', $article)
            ->orWhere('slug', $article)
            ->firstOrFail();

        $article->load([
            'file',
            'category',
            'sections',
            'author.file',
            'galleries.file',
            'municipality.department',
            'advertisements.advertisement.files.file'
        ]);

        if ($request->user()->hasRole('reader') && !$article->isPublished()) {
            throw new NotFoundHttpException('No query results for model.');
        } */

        return response()->json(new ArticleResource($article));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        $this->authorize('update', $article, $request->user());

        $article = $this->articleService->updateArticle($request, $article);

        return response()->json(new ArticleResource($article), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        $this->authorize('delete', $article, request()->user());

        $this->articleService->deleteArticle($article);

        return response()->json(['deleted_id' => $article->id], 204);
    }
}
