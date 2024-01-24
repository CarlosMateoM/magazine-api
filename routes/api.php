<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\MunicipalityController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {

    Route::resource('articles', ArticleController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('municipalities', MunicipalityController::class);

    Route::get('files', [FileController::class, 'index']);
    Route::get('files/{File}', [FileController::class, 'show']);
    Route::post('files', [FileController::class, 'store']);
    
    
});
