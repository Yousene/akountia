<?php

use App\Http\Controllers\Api\CourseApiController;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ClientApiController;
use App\Http\Controllers\Api\SearchApiController;
use App\Http\Controllers\Api\ContactApiController;
use App\Http\Controllers\Api\LeadApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Regroupement de toutes les routes API v1
Route::prefix('v1')->group(function () {
    // Routes pour les formations
    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseApiController::class, 'index']);
        Route::get('/search', [CourseApiController::class, 'search']);
        Route::get('/{id}', [CourseApiController::class, 'show'])->where('id', '[0-9]+');
        Route::get('/link/{link}', [CourseApiController::class, 'showByLink']);
        // Route::get('/category/{category}', [CourseApiController::class, 'getByCategory']);
        Route::get('/category/{category}', [CourseApiController::class, 'getByCategoryLink']);
    });

    // Routes pour les catégories
    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryApiController::class, 'index']);
        Route::get('/search', [CategoryApiController::class, 'search']);
        Route::get('/{id}', [CategoryApiController::class, 'show'])->where('id', '[0-9]+');
        Route::get('/link/{link}', [CategoryApiController::class, 'showByLink']);
    });

    // Routes pour les clients
    Route::prefix('clients')->group(function () {
        Route::get('/', [ClientApiController::class, 'index']);
        Route::get('/search', [ClientApiController::class, 'search']);
        Route::get('/{id}', [ClientApiController::class, 'show'])->where('id', '[0-9]+');
        Route::get('/link/{link}', [ClientApiController::class, 'showByLink']);
    });

    Route::get('/search/courses', [SearchApiController::class, 'searchCourses']);

    Route::post('/contacts', [ContactApiController::class, 'store']);

    Route::post('/leads', [LeadApiController::class, 'store']);
});
