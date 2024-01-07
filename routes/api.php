<?php

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

Route::middleware('auth:sanctum')->group(function (){
    Route::get('/user', [\App\Http\Controllers\Api\UserController::class, 'user']);
    Route::put('/user/update/{id}', [\App\Http\Controllers\Api\UserController::class, 'update']);

    Route::get('/articles', [\App\Http\Controllers\Api\ArticleController::class, 'index']);

    Route::get('/api-sources', [\App\Http\Controllers\Api\ApiSourceController::class, 'index']);
    Route::get('/sources', [\App\Http\Controllers\Api\SourceController::class, 'index']);
    Route::get('/authors', [\App\Http\Controllers\Api\AuthorController::class, 'index']);
    Route::get('/categories', [\App\Http\Controllers\Api\CategoryController::class, 'index']);

    Route::get('/logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
});

Route::post('/signup', [\App\Http\Controllers\Api\AuthController::class, 'signup']);
Route::post('/login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
