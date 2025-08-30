<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\DoaController;
use App\Http\Controllers\ForumController;
use App\Http\Controllers\JadwalSholatController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\SurahController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('surah', [SurahController::class, 'index']);

Route::get('doa', [DoaController::class, 'index']);

Route::get('jadwal-sholat', [JadwalSholatController::class, 'index']);

Route::get('masjid', [MasjidController::class, 'index']);

Route::get('berita-islami', [MasjidController::class, 'beritaIslami']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('google', [AuthController::class, 'loginGoogle']);
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::post('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
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
