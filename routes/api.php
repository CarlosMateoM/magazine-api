<?php

use App\Http\Controllers\ArticleContentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleKeywordController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ArticleSectionController;
use App\Http\Controllers\ArticleSlugController;
use App\Http\Controllers\ArticleViewController;
use App\Http\Controllers\AuthenticatedUserController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\ExpenseCategoryController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ExpenseReportController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\IncomeController;
use App\Http\Controllers\IncomeReportController;
use App\Http\Controllers\KeywordController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\SavingGoalController;
use App\Http\Controllers\SavingGoalDepositController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\SuscriberController;
use App\Http\Controllers\UserController;
use App\Models\Income;
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


    Route::post('suscribers', [SuscriberController::class, 'store']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user',                          AuthenticatedUserController::class);
        Route::get('articles/{slug}/slugs',         ArticleSlugController::class);
        Route::get('articles/most-viewed',          [ArticleViewController::class, 'index']);
        Route::post('articles/{article}/views',     [ArticleViewController::class, 'store']);
        Route::put('articles/{article}/content',    [ArticleContentController::class, 'update']);

        Route::apiResource('users',                 UserController::class);
        Route::apiResource('authors',               AuthorController::class);
        Route::apiResource('roles',                 RoleController::class);

        Route::apiResource('files',                 FileController::class);

        Route::get('/storage/usage',          [StorageController::class, 'usage']);


        Route::apiResource('sections',              SectionController::class);
        Route::apiResource('articles',              ArticleController::class);
        Route::apiResource('keywords',              KeywordController::class);
        Route::apiResource('galleries',             GalleryController::class);
        Route::apiResource('categories',            CategoryController::class);
        Route::apiResource('departments',           DepartmentController::class);
        Route::apiResource('permissions',           PermissionController::class);
        Route::apiResource('municipalities',        MunicipalityController::class);

        Route::apiResource('roles.permissions',     RolePermissionController::class)
            ->only(['index', 'store', 'destroy']);
        Route::apiResource('articles.keywords',     ArticleKeywordController::class)
            ->only(['index', 'store', 'destroy']);
        Route::apiResource('sections.articles',     ArticleSectionController::class)
            ->only(['index', 'store', 'destroy']);




        Route::apiResource('incomes/total',         IncomeReportController::class)
            ->only(['index']);

        Route::apiResource('expenses/total',         ExpenseReportController::class)
            ->only(['index']);

        

        Route::apiResource('incomes',               IncomeController::class);
        Route::apiResource('expenses',              ExpenseController::class);
        Route::apiResource('saving-goals',          SavingGoalController::class);
        Route::apiResource('saving-goal-deposits',  SavingGoalDepositController::class);
        Route::apiResource('expense-categories',    ExpenseCategoryController::class);

    });
});
