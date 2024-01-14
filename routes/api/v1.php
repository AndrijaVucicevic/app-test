<?php

use App\Enums\Routes\V1\RouteEnum as V1RouteEnum;
use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\PostController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes - version 1
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name(V1RouteEnum::LOGIN->value);

    Route::middleware('auth:sanctum')->group(function () {

        Route::resource('posts', PostController::class);
    });
});
