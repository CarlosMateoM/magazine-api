<?php

namespace App\Services\Article;

use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ArticleViewService
{
    public function createArticleView(Article $article, Request $request): void 
    {
        $cacheKey = "article_viewed:{$article->id}:{$request->ip()}";

        if (!Cache::has($cacheKey)) {

            $articleView = new ArticleView();
            $articleView->article_id = $article->id;
            $articleView->ip_address = $request->ip();
            $articleView->user_agent = $request->userAgent();
            $articleView->save();

            Cache::put($cacheKey, true, now()->addMinutes(10));

            $article->increment('views');

            Cache::forget('most_viewed_articles');
        }
    }
}
