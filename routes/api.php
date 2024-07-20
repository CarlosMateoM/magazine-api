<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AuthorController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MunicipalityController;
use App\Http\Controllers\ArticleSectionController;
use App\Http\Controllers\ArticleViewController;
use App\Http\Controllers\AuthController;
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
    
    
    Route::post('auth/login', [AuthController::class, 'login']);
    Route::post('auth/register', [AuthController::class, 'register']);
    


    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', function (Request $request) {
            return $request->user()->load('role');
        });
        
        Route::get('articles/most-viewed', [ArticleViewController::class, 'index']);
        
        Route::resource('users', UserController::class);
        Route::resource('files', FileController::class);
        Route::resource('authors', AuthorController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('articles', ArticleController::class);
        Route::resource('galleries', GalleryController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('municipalities', MunicipalityController::class);
        Route::resource('articles.sections', ArticleSectionController::class);
        
        
        Route::post('articles/{article}/view', [ArticleViewController::class, 'store']);
        

        Route::post('auth/logout', [AuthController::class, 'logout']);        

    }); 
});




    
