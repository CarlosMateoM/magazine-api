<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use App\Models\Article;
use App\Models\Author;
use App\Models\User;
use App\Policies\ArticlePolicy;
use App\Policies\AuthorPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
        User::class => UserPolicy::class,
        Article::class => ArticlePolicy::class,
        Author::class => AuthorPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        Gate::before(function (User $user, $ability) {
            if ($user->hasRole('admin')) {
                return true;
            }
        });
        
    }
}
