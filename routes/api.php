<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ArticleSectionController;
use App\Http\Controllers\ArticleSlugController;
use App\Http\Controllers\ArticleViewController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;

use Illuminate\Http\Request;
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

    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', function (Request $request) {
            return $request->user()->load('role');
        });

        Route::get('articles/most-viewed',          [ArticleViewController::class, 'show']);
        
        Route::apiResource('users',                 UserController::class);
        Route::apiResource('files',                 FileController::class);
        Route::apiResource('authors',               AuthorController::class);
        Route::apiResource('sections',              SectionController::class);
        
        Route::apiResource('articles',              ArticleController::class);

        Route::get('articles/slugs/{slug}',         [ArticleSlugController::class, 'show']);
        
        Route::apiResource('galleries',             GalleryController::class);
        Route::apiResource('categories',            CategoryController::class);
        Route::apiResource('departments',           DepartmentController::class);
        Route::apiResource('municipalities',        MunicipalityController::class);
        Route::apiResource('articles.sections',     ArticleSectionController::class);
        
        
        Route::post('articles/{article}/view',      [ArticleViewController::class, 'store']);  

    }); 
});




    
