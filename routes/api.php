<?php

use App\Http\Controllers\API\Auth\LoginControler;
use App\Http\Controllers\API\Auth\RegisterControler;
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

Route::post('login', LoginControler::class);
Route::post('register', RegisterControler::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


