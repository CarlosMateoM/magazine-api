<?php

namespace App\Services;

use App\Http\Requests\UpdateArticleRequest;
use Illuminate\Support\Str;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{

    public function findArticleBySlug(string $slug): Article
    {
        $article = Article::where('slug', $slug)
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
            ->paginate(10)
            ->appends($request->query());

        if ($request->user()->hasRole('reader')) {
            $articles->where('status', 'published');
        }

        return $articles;
    }

    public function getArticle($id)
    {
        // 
    }

    public function createArticle($data)
    {
        // 
    }

    public function updateArticle(UpdateArticleRequest $request, Article $article): Article
    {


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
        $article->slug = Str::slug($request->title);
        $article->published_at = $request->publishedAt;

        $article->author_id = $request->author['id'];
        $article->category_id = $request->category['id'];
        $article->municipality_id = $request->municipality['id'];

        $article->save();

        $article->load([
            'file',
            'author',
            'category',
            'municipality.department'
        ]);

        return $article;
    }

    public function deleteArticle(Article $article)
    {
        $article->delete();
    }
}
