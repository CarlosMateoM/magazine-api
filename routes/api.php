<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleKeywordController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ArticleSectionController;
use App\Http\Controllers\ArticleSlugController;
use App\Http\Controllers\ArticleViewController;
use App\Http\Controllers\AuthenticatedUserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\NewsLetterSubscriptionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('v1')->group(function () {

    // authentication routes
    Route::middleware("web")->group(function () {

        Route::post('/newsLetterSubscription', [NewsLetterSubscriptionController::class, 'store']);
        Route::put('/newsLetterSubscription/{newsLetterSubscription}', [NewsLetterSubscriptionController::class, 'update']);

        Route::prefix('auth')->group(function () {
            Route::post('register', [AuthController::class, 'register']);
            Route::post('login', [AuthController::class, 'login']);
            Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
            Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
            Route::post('reset-password', [AuthController::class, 'resetPassword']);
            Route::post('/email/verify', [AuthController::class, 'verifyEmail']);
            Route::post('/email/resend', [AuthController::class, 'resendEmail'])->middleware('auth:sanctum');
        });

    });

    Route::middleware(['auth:sanctum', 'verified.api'])->group(function () {

        Route::get('prueba', [AuthController::class, function () {
            return response()->json(["messaget"=>"hola mundo"]);
        }]);

        Route::get('user',                          AuthenticatedUserController::class);
        Route::get('articles/{slug}/slugs',         ArticleSlugController::class);
        Route::get('articles/most-viewed',          [ArticleViewController::class, 'index']);
        Route::post('articles/{article}/views',     [ArticleViewController::class, 'store']);
        Route::get('newsLetterSubscription', [NewsLetterSubscriptionController::class, 'index']);
        Route::get('newsLetterSubscription/{newsLetterSubscription}', [NewsLetterSubscriptionController::class, 'show']);
        Route::delete('newsLetterSubscription/{newsLetterSubscription}', [NewsLetterSubscriptionController::class, 'destroy']);

        Route::apiResource('users',                 UserController::class);
        Route::apiResource('authors',               AuthorController::class);
        Route::apiResource('roles',                 RoleController::class);
        Route::apiResource('files',                 FileController::class);
        Route::apiResource('sections',              SectionController::class);
        Route::apiResource('articles',              ArticleController::class);
        Route::apiResource('keywords',              KeywordController::class);
        Route::apiResource('galleries',             GalleryController::class);
        Route::apiResource('categories',            CategoryController::class);
        Route::apiResource('departments',           DepartmentController::class);
        Route::apiResource('permissions',           PermissionController::class);
        Route::apiResource('municipalities',        MunicipalityController::class);

        //Route::apiResource('newsLetterSubscription', NewsLetterSubscriptionController::class);
        //Route::put('newsLetterSubscription/isNotificationEnable/{newsLetterSubscription}', [NewsLetterSubscriptionController::class, 'updateStatusIsNotificationEnabled']);

        Route::apiResource('roles.permissions',     RolePermissionController::class)
            ->only(['index', 'store', 'destroy']);
        Route::apiResource('articles.keywords',     ArticleKeywordController::class)
            ->only(['index', 'store', 'destroy']);
        Route::apiResource('sections.articles',     ArticleSectionController::class)
            ->only(['index', 'store', 'destroy']);

    });
});
