<?php 

namespace App\Services;

use App\Http\Requests\StoreArticleSectionRequest;
use App\Models\Article;
use App\Models\Section;

class ArticleSectionService
{

    public function getArticlesBySection(Section $section)
    {
        return $section->articles;
    }

    public function attachArticleToSection(Section $section, StoreArticleSectionRequest $request)
    {
        $section->articles()->attach($request->articleId);
    }

    public function detachArticleFromSection(Section $section, Article $article)
    {
        $section->articles()->detach($article->id);
    }

}