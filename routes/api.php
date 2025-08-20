<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\JadwalSholatController;
use App\Http\Controllers\SurahController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('surah', [SurahController::class, 'index']);

Route::get('jadwal-sholat', [JadwalSholatController::class, 'index']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});

Route::middleware('auth:sanctum')->prefix('bookmark')->group(function () {
    Route::get('/', [BookmarkController::class, 'index']);
    Route::post('/', [BookmarkController::class, 'store']);
    Route::put('/{id}', [BookmarkController::class, 'update']);
    Route::delete('/{id}', [BookmarkController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('forum-post')->group(function () {
    Route::get('/', [ForumController::class, 'index']);
    Route::post('/', [ForumController::class, 'store']);
    Route::put('/{id}', [ForumController::class, 'update']);
    Route::delete('/{id}', [ForumController::class, 'delete']);
});
