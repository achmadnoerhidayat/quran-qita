<?php

use App\Http\Controllers\web\AskUstadzController;
use App\Http\Controllers\web\AsmaAlHusnaController;
use App\Http\Controllers\web\AyatController;
use App\Http\Controllers\web\ContentController;
use App\Http\Controllers\web\CourseController;
use App\Http\Controllers\web\DashController;
use App\Http\Controllers\web\DonasiController;
use App\Http\Controllers\web\DzikirController;
use App\Http\Controllers\web\LanggananController;
use App\Http\Controllers\web\LessonController;
use App\Http\Controllers\web\LoginController;
use App\Http\Controllers\web\NewsHajiUmrohhController;
use App\Http\Controllers\web\PlanController;
use App\Http\Controllers\web\QuizController;
use App\Http\Controllers\web\QuranController;
use App\Http\Controllers\web\TypeDzikirController;
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
    Route::delete('/{id}', [NewsHajiUmrohhController::class, 'delete']);
    // Route::post('/', [LoginController::class, 'login'])->name('login');
});

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::get('/{id}', [UserController::class, 'show']);
    Route::post('/', [UserController::class, 'store'])->name('store-user');
    Route::put('/{id}', [UserController::class, 'update'])->name('update-user');
    Route::delete('/{id}', [UserController::class, 'delete']);
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

Route::middleware('auth')->prefix('course')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::get('/edit/{id}', [CourseController::class, 'edit']);
    Route::put('/{id}', [CourseController::class, 'update'])->name('update-course');
    Route::post('/', [CourseController::class, 'store'])->name('store-course');
    Route::delete('/{id}', [CourseController::class, 'delete']);
});

Route::middleware('auth')->prefix('lesson')->group(function () {
    Route::get('/', [LessonController::class, 'index']);
    Route::get('/edit/{id}', [LessonController::class, 'edit']);
    Route::post('/', [LessonController::class, 'store'])->name('store-lesson');
    Route::put('/{id}', [LessonController::class, 'update'])->name('update-lesson');
    Route::delete('/{id}', [LessonController::class, 'delete']);
});

Route::middleware('auth')->prefix('kuis')->group(function () {
    Route::get('/', [QuizController::class, 'index']);
    Route::get('/add-question/{id}', [QuizController::class, 'addQuestion']);
    Route::get('/edit/{id}', [QuizController::class, 'edit']);
    Route::post('/', [QuizController::class, 'store'])->name('store-quiz');
    Route::put('/{id}', [QuizController::class, 'update'])->name('update-quiz');
    Route::delete('/{id}', [QuizController::class, 'delete'])->name('delete-quiz');
    Route::post('/add-soal/{id}', [QuizController::class, 'addSoal'])->name('add-soal-quiz');
    Route::post('/delete-soal/{id}', [QuizController::class, 'deleteSoal']);
});

Route::middleware('auth')->prefix('plan')->group(function () {
    Route::get('/', [PlanController::class, 'index']);
    Route::get('/{id}', [PlanController::class, 'show']);
    Route::post('/', [PlanController::class, 'store'])->name('store-plan');
    Route::put('/{id}', [PlanController::class, 'update'])->name('update-plan');
    Route::delete('/{id}', [PlanController::class, 'delete']);
});

Route::middleware('auth')->prefix('langganan')->group(function () {
    Route::get('/', [LanggananController::class, 'index']);
    Route::get('/{id}', [LanggananController::class, 'show']);
    Route::put('/{id}', [LanggananController::class, 'update']);
    Route::post('/update-status/{id}', [LanggananController::class, 'updateStatus']);
});

Route::middleware('auth')->prefix('donasi')->group(function () {
    Route::get('/', [DonasiController::class, 'index']);
    Route::get('/{id}', [DonasiController::class, 'show']);
    Route::put('/{id}', [DonasiController::class, 'update']);
});

Route::middleware('auth')->prefix('ask-uztadz')->group(function () {
    Route::get('/', [AskUstadzController::class, 'index']);
    Route::put('/{id}', [AskUstadzController::class, 'update']);
});

Route::middleware('auth')->prefix('dzikir')->group(function () {
    Route::get('/', [DzikirController::class, 'index']);
    Route::get('/{id}', [DzikirController::class, 'show']);
    Route::post('/', [DzikirController::class, 'store'])->name('store-dzikir');
    Route::put('/{id}', [DzikirController::class, 'update'])->name('update-dzikir');
    Route::delete('/{id}', [DzikirController::class, 'delete']);
});

Route::middleware('auth')->prefix('asma')->group(function () {
    Route::get('/', [AsmaAlHusnaController::class, 'index']);
    Route::get('/{id}', [AsmaAlHusnaController::class, 'show']);
    Route::post('/', [AsmaAlHusnaController::class, 'store'])->name('store-asma');
    Route::put('/{id}', [AsmaAlHusnaController::class, 'update'])->name('update-asma');
    Route::delete('/{id}', [AsmaAlHusnaController::class, 'delete']);
});

Route::middleware('auth')->prefix('type-dzikir')->group(function () {
    Route::get('/', [TypeDzikirController::class, 'index']);
    Route::get('/{id}', [TypeDzikirController::class, 'show']);
    Route::post('/', [TypeDzikirController::class, 'store'])->name('store-type-dzikir');
    Route::put('/{id}', [TypeDzikirController::class, 'update'])->name('update-type-dzikir');
    Route::delete('/{id}', [TypeDzikirController::class, 'delete']);
});

Route::middleware('auth')->prefix('konten')->group(function () {
    Route::get('/', [ContentController::class, 'index']);
    Route::put('/{id}', [ContentController::class, 'update']);
    Route::delete('/{id}', [ContentController::class, 'delete']);
});
