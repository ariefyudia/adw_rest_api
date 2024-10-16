<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});

Route::group([
    'middleware' => 'api',
    'prefix' => 'user-management'
], function ($router) {
    Route::get('/', [UserController::class, 'index'])->middleware('auth:api');
    Route::post('/', [UserController::class, 'store'])->middleware('auth:api');
    Route::get('/view/{id}', [UserController::class, 'show'])->middleware('auth:api');
});
