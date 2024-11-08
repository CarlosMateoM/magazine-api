<?php

namespace App\Services\Article;

use App\Http\Requests\StoreArticleKeywordRequest;
use App\Models\Article;
use App\Models\Keyword;

class ArticleKeywordService
{

    public function getKeywordsByArticle(Article $article)
    {
        return $article->keywords;
    }

    public function attachKeywordToArticle(Article $article, StoreArticleKeywordRequest $request): void
    {
        $article->keywords()->syncWithoutDetaching($request->input('keywords'));
    }

    public function detachKeywordFromArticle(Article $article, Keyword $keyword): void
    {
        $article->keywords()->detach($keyword->id);
    }
}