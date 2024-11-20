<?php

use App\Modules\Auth\Infrastructure\Controllers\LoginController;
use App\Modules\Auth\Infrastructure\Controllers\LogoutController;
use App\Modules\Auth\Infrastructure\Controllers\RefreshTokenController;
use App\Modules\Products\Infrastructure\Controllers\ListProductController;
use Illuminate\Support\Facades\Route;

//Auth
Route::post('/auth/login', LoginController::class);

Route::middleware('auth:api')->group(function () {
    Route::post('/auth/refresh', RefreshTokenController::class);
    Route::post('/auth/logout', LogoutController::class);

    Route::get('/products', ListProductController::class);
});


