<?php

namespace App\Providers;

use App\Models\Income;
use App\Observers\IncomeObserver;
use App\Policies\ArticleSlugPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(ImageManager::class, function () {
            return new ImageManager(new Driver());
        });

    
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    { 

        Gate::define('showArticleSlug', [ArticleSlugPolicy::class, 'show']);
    }
}
