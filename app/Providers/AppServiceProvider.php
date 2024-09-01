<?php

namespace App\Providers;

use App\Models\Article;
use App\Policies\ArticleSlugPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::define('showArticleSlug', [ArticleSlugPolicy::class, 'show']);
    }
}
