<?php

namespace App\Services\Article;

use App\Http\Requests\StoreArticleSectionRequest;
use App\Models\Article;
use App\Models\Section;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class ArticleSectionService
{

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

        return $articles->paginate($request->input('per_page', config('constants.default_per_page')))
            ->appends($request->query());
    }

    public function attachArticleToSection(Section $section, StoreArticleSectionRequest $request): void
    {
        $section->articles()->syncWithoutDetaching($request->input('articleId'));
    }

    public function detachArticleFromSection(Section $section, Article $article): void
    {
        $section->articles()->detach($article->id);
    }
}
