<?php

namespace App\Services\Article;

use App\Http\Requests\StoreArticleSectionRequest;
use App\Models\Article;
use App\Models\Section;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleSectionService
{

    private const DEFAULT_PER_PAGE = 10;

    public function getArticlesBySection(Section $section, Request $request)
    {
        $articles = QueryBuilder::for(Article::class)
            ->allowedFilters('title')
            ->allowedIncludes([
                'file',
                'author.file',
                'category',
                'municipality',
            ])
            ->whereHas('sections', function ($query) use ($section) {
                $query->where('sections.id', $section->id);
            });

        return $articles->paginate($request->input('per_page', self::DEFAULT_PER_PAGE))
            ->appends($request->query());
    }

    public function attachArticleToSection(Section $section, StoreArticleSectionRequest $request)
    {
        $section->articles()->syncWithoutDetaching($request->input('articleId'));
    }

    public function detachArticleFromSection(Section $section, Article $article)
    {
        $section->articles()->detach($article->id);
    }
}
