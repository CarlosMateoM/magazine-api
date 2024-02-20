<?php

use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\FileController;
use App\Http\Controllers\Admin\MunicipalityController;
use App\Http\Controllers\ArticleSectionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SectionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Controllers\CsrfCookieController;

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
    Route::get('sanctum/csrf-cookie', [CsrfCookieController::class, 'show']);


    Route::middleware('auth:sanctum')->group(function () {

        Route::get('user', function (Request $request) {return $request->user();});

        Route::post('auth/logout', [AuthController::class, 'logout']);
        
        Route::resource('files', FileController::class);
        Route::resource('sections', SectionController::class);
        Route::resource('articles', ArticleController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('departments', DepartmentController::class);
        Route::resource('municipalities', MunicipalityController::class);
        Route::resource('articles/sections', ArticleSectionController::class);
        
        

    }); 
});




    
