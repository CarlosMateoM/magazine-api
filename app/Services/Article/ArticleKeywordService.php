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

    public function attachKeywordToArticle(Article $article, StoreArticleKeywordRequest $request)
    {
        $article->keywords()->syncWithoutDetaching($request->input('keywordId'));
    }

    public function detachKeywordFromArticle(Article $article, Keyword $keyword) 
    {
        $article->keywords()->detach($keyword->id);
    }
}