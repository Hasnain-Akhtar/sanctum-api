<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/admin/signup', [AuthController::class, 'signup']);
Route::post('/admin/login', [AuthController::class, 'login']);
Route::group(['prefix' => 'admin', 'middleware' => 'auth:sanctum'], function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::apiResource('posts', PostController::class);
});
Route::get('/user/posts', [PostController::class, 'indexForUsers']);