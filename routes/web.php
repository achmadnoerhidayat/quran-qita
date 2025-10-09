<?php

use App\Http\Controllers\web\AyatController;
use App\Http\Controllers\web\DashController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\NewsHajiUmrohhController;
use App\Http\Controllers\web\QuranController;
use App\Http\Controllers\web\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/terms', function () {
    return view('terms');
});

Route::get('/terms-user', function () {
    return view('termsuser');
});

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/about', function () {
    return view('about');
});
Route::group(['prefix' => '/'], function () {
    Route::get('login', [LoginController::class, 'index']);
    Route::post('login', [LoginController::class, 'login'])->name('login');
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [DashController::class, 'index']);
    // Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->prefix('haji-umroh')->group(function () {
    Route::get('/', [NewsHajiUmrohhController::class, 'index']);
    Route::get('/{id}', [NewsHajiUmrohhController::class, 'show']);
    Route::post('/', [NewsHajiUmrohhController::class, 'store'])->name('store-haji');
    Route::put('/{id}', [NewsHajiUmrohhController::class, 'update'])->name('update-haji');
    // Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store'])->name('store-user');
    Route::put('/{id}', [UserController::class, 'update'])->name('update-user');
});

Route::middleware('auth')->prefix('quran')->group(function () {
    Route::get('/', [QuranController::class, 'index']);
    Route::get('/{id}', [QuranController::class, 'show']);
    Route::get('/edit/{id}', [QuranController::class, 'edit']);
    Route::put('/{id}', [QuranController::class, 'update'])->name('edit-quran');
    Route::post('/upload-audio', [QuranController::class, 'uploadAudio'])->name('upload-audio-quran');
    Route::post('/delete-audio/{id}', [QuranController::class, 'deleteAudio'])->name('delete-audio-quran');
});

Route::middleware('auth')->prefix('ayat')->group(function () {
    Route::get('/edit/{id}', [AyatController::class, 'edit']);
    Route::put('/{id}', [AyatController::class, 'update'])->name('edit-ayat');
    Route::post('/upload-audio', [AyatController::class, 'uploadAudio'])->name('upload-audio-ayat');
    Route::post('/delete-audio/{id}', [AyatController::class, 'deleteAudio'])->name('delete-audio-ayat');
});
