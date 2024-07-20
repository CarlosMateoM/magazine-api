<?php

namespace App\Http\Controllers;

use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Models\ArticleView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class ArticleViewController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $mostViewedArticles = Cache::remember('most_viewed_articles', now()->addMinutes(10), function () {

            return Article::with(['category', 'file','author.file'])
                ->orderByDesc('views', 'desc')
                ->limit(5)
                ->get();
        });

        return response()->json(ArticleResource::collection($mostViewedArticles));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Article $article)
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

        return response()->json(['success' => true], 201);
    }
}
