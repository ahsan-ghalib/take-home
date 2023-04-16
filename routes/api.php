<?php

use App\Http\Controllers\API\Auth\LoginControler;
use App\Http\Controllers\API\Auth\RegisterControler;
use App\Http\Controllers\API\NewsController;
use App\Http\Controllers\API\NewsFeedController;
use App\Http\Controllers\API\SearchNewsController;
use App\Http\Controllers\API\UserNewsFeedPreferenceController;
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

Route::post('login', LoginControler::class);
Route::post('register', RegisterControler::class);

Route::apiResource('news', NewsController::class)->only(['index', 'show']);
Route::post('search-news', SearchNewsController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserNewsFeedPreferenceController::class)->group(function () {
        Route::get('news-feed-preferences', 'show');
        Route::put('news-feed-preferences', 'update');
    });

    Route::get('news-feeds', NewsFeedController::class);
});


