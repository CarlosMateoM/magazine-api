<?php

namespace App\Services;

use App\Enums\ArticleStatus;
use App\Enums\RoleType;
use App\Http\Requests\UpdateArticleRequest;
use App\Http\Requests\StoreArticleRequest;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{
    private const DEFAULT_PER_PAGE = 10;

    public function findArticleBySlug(string $slug): Article
    {
        $article = Article::where('slug', $slug)
            ->with([
                'file',
                'category',
                'sections',
                'author.file',
                'galleries.file',
                'municipality.department',
                'advertisements.advertisement.files.file'
            ])
            ->firstOrFail();

        return $article;
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

        return $articles->paginate(self::DEFAULT_PER_PAGE)
            ->appends($request->query());
    }

    public function getArticle(Article $article): Article
    {
        return $article->load([
            'file',
            'category',
            'sections',
            'author.file',
            'galleries.file',
            'municipality.department',
            'advertisements.advertisement.files.file'
        ]);
    }

    public function createArticle(StoreArticleRequest $request): Article
    {
        $article = new Article();

        $this->handleArticleImage($article, $request);

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

        return $article;
    }

    public function updateArticle(UpdateArticleRequest $request, Article $article): Article
    {

        $this->handleArticleImage($article, $request);

        $article->title = $request->title;
        $article->status = $request->status;
        $article->summary = $request->summary;
        $article->content = $request->content;
        $article->slug = Str::slug($request->title);
        $article->published_at = $request->publishedAt;

        $article->author_id = $request->author['id'];
        $article->category_id = $request->category['id'];
        $article->municipality_id = $request->municipality['id'];

        $article->save();

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
    }


    /**
     * If the article is an opinion article, the author's image will be used
     * as the cover and for SEO purposes. In other cases, the image must be 
     * present in the database and included in the request.
     */
    private function handleArticleImage(Article $article, Request $request): void
    {
        $opinionCategoryId = Category::where('name', 'opinion')->first()->value('id');

        if ($request->category['id'] !== $opinionCategoryId) {

            $request->validate([
                'image.id' => 'required|exists:files,id'
            ]);

            $article->file_id = $request->image['id'];
        }
    }
}
