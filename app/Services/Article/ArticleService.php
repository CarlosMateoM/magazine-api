<?php

namespace App\Services\Article;

use App\Enums\ArticleStatus;
use App\Enums\RoleType;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{

    public function findArticleBySlug(string $slug): Article
    {
        $article = Article::where('slug', $slug)
            ->with([
                'file',
                'category',
                'sections',
                'keywords',
                'author.file',
                'galleries.file',
                'municipality.department',
                'advertisements.advertisement.files.file'
            ])
            ->firstOrFail();

        return $article;
    }

    public function publishScheduledArticles(): void
    {
        Article::where('status', ArticleStatus::SCHEDULED)
            ->where('published_at', '<=', now())
            ->update(['status' => ArticleStatus::PUBLISHED]);
    }

    public function getArticles(Request $request)
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedFilters([
                'user.id',
                'title',
                'published_at',
                'category.name',
                AllowedFilter::exact('sections.name'),
                AllowedFilter::exact('status'),
            ])
            ->allowedIncludes([
                'file',
                'author.file',
                'category',
                'municipality',
                'sections',
                'keywords',
                'advertisements.file'
            ])
            ->allowedSorts([
                'title',
                'published_at',
                'created_at'
            ])
            ->defaultSort('-created_at');

        if ($request->user()->hasRole(RoleType::READER->value)) {
            $articles->where('status', ArticleStatus::PUBLISHED->value);
        }

        return $articles->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function getArticle(Article $article): Article
    {
        return $article->load([
            'file',
            'category',
            'sections',
            'keywords',
            'author.file',
            'galleries.file',
            'municipality.department',
            'advertisements.advertisement.files.file'
        ]);
    }

    public function createArticle(StoreArticleRequest $request): Article
    {
        $article = new Article();

        $article->title             = $request->input('title');
        $article->status            = $request->input('status');
        $article->summary           = $request->input('summary');
        $article->content           = $request->input('content');
        $article->user_id           = $request->user()->id;
        $article->published_at      = $request->input('publishedAt');
        $article->slug              = Str::slug($request->input('title'));
        $article->author_id         = $request->input('author.id');
        $article->category_id       = $request->input('category.id');
        $article->municipality_id   = $request->input('municipality.id');

        $article->save();

        return $article;
    }

    public function updateArticle(UpdateArticleRequest $request, Article $article): Article
    {

        $article->title             = $request->input('title');
        $article->status            = $request->input('status');
        $article->summary           = $request->input('summary');
        $article->content           = $request->input('content');
        $article->published_at      = $request->input('publishedAt');
        $article->slug              = Str::slug($request->input('title'));
        $article->author_id         = $request->input('author.id');
        $article->category_id       = $request->input('category.id');
        $article->municipality_id   = $request->input('municipality.id');

        $article->save();

        return $article;
    }

    public function deleteArticle(Article $article): void
    {
        $article->delete();
    }
}

