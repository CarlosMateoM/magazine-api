<?php

namespace App\Services;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleService
{

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

    public function updateArticle($id, $data)
    {
        // 
    }

    public function deleteArticle($id)
    {
        // 
    }
}
