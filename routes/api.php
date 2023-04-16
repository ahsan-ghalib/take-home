<?php

use App\Http\Controllers\API\Auth\LoginControler;
use App\Http\Controllers\API\Auth\RegisterControler;
use App\Http\Controllers\API\NewsController;
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

Route::get('test', function () {
//    echo phpinfo();
        return (new \App\Services\NewsApiScrapperService())->execute();
});

Route::middleware('auth:sanctum')->group(function () {

});


