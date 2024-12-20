<?php

namespace App\Services\Article;

use App\Enums\ArticleStatus;
use App\Enums\RoleType;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{

    public function findArticleBySlug(string $slug): Article
    {
        $article = Article::where('slug', $slug)
            ->with([
                'file',
                'user.file',
                'category',
                'sections',
                'keywords',
                'galleries.file',
                'municipality.department',
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

    public function getMostViewedArticles(int $limit)
    {
        return Cache::remember('most_viewed_articles', now()->addMinutes(20), function () use ($limit) {
            return Article::with(['category','municipality.department', 'file', 'user.file'])
                ->where('status', ArticleStatus::PUBLISHED)
                ->orderByDesc('views', 'desc')
                ->limit($limit)
                ->get();
        });
    }

    public function getArticles(Request $request)
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedFilters([
                'author.id',
                'title',
                'user.name',
                'category.name',
                'municipality.name',
                AllowedFilter::exact('status'),
                
                AllowedFilter::callback('published_at', function ($query, $value, $property) {
                    
                    if (is_array($value)) {
                        $query->whereBetween('published_at', $value);
                    } else {
                        $query->whereDate('published_at', $value);
                    }

                    
                }),
                AllowedFilter::exact('sections.name'),
            ])
            ->allowedIncludes([
                'sections',
                'keywords',
                'advertisements.file'
            ])
            ->allowedSorts([
                'title',
                'published_at',
                'created_at'
            ])
            ->with(['author.user.image', 'category', 'municipality.department', 'coverImage'])
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
            'user.file',
            'galleries.file',
            'municipality.department',
            'advertisements.advertisement.files.file'
        ]);
    }

    public function createArticle(StoreArticleRequest $request): Article
    {
        $article = new Article();

        $article->title             = $request->input('title');
        $article->status            = $request->input('status', ArticleStatus::DRAFT);
        $article->summary           = $request->input('summary');
        $article->content           = $request->input('content', '');
        $article->published_at      = $request->input('publishedAt');
        $article->slug              = Str::slug($request->input('title'));
        $article->user_id           = $request->input('user.id');
        $article->file_id           = $request->input('file.id');
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
        $article->user_id           = $request->input('user.id');
        $article->file_id           = $request->input('file.id');
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
