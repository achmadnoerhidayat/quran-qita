<?php

use App\Http\Controllers\api\AiController;
use App\Http\Controllers\api\AsmaController;
use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BookmarkController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\CoinController;
use App\Http\Controllers\api\CoinPackageController;
use App\Http\Controllers\api\CommentController;
use App\Http\Controllers\api\ComunityController;
use App\Http\Controllers\api\ContentController;
use App\Http\Controllers\api\CourseController;
use App\Http\Controllers\api\DoaController;
use App\Http\Controllers\api\DonasiController;
use App\Http\Controllers\api\DzikirController;
use App\Http\Controllers\api\FollowController;
use App\Http\Controllers\api\ForumController;
use App\Http\Controllers\api\HajiUmrohController;
use App\Http\Controllers\api\HighlightController;
use App\Http\Controllers\api\JadwalSholatController;
use App\Http\Controllers\api\JournalController;
use App\Http\Controllers\api\LessonController;
use App\Http\Controllers\api\MasjidController;
use App\Http\Controllers\api\NoteController;
use App\Http\Controllers\api\PlanController;
use App\Http\Controllers\api\ProdukController;
use App\Http\Controllers\api\QuizzeController;
use App\Http\Controllers\api\RekeningBankController;
use App\Http\Controllers\api\ReminderController;
use App\Http\Controllers\api\ScheduleController;
use App\Http\Controllers\api\SubscriptionController;
use App\Http\Controllers\api\SurahController;
use App\Http\Controllers\api\TanyaUstadController;
use App\Http\Controllers\api\TransaksiProdukController;
use App\Http\Controllers\api\TypeDzikirController;
use App\Http\Controllers\api\UserController;
use Illuminate\Support\Facades\Route;

Route::get('surah', [SurahController::class, 'index']);

Route::get('tafsir', [SurahController::class, 'tafsir']);

Route::get('doa', [DoaController::class, 'index']);

Route::middleware('auth:sanctum')->get('jadwal-sholat', [JadwalSholatController::class, 'index']);

Route::get('masjid', [MasjidController::class, 'index']);

Route::get('berita-islami', [MasjidController::class, 'beritaIslami']);

// callback Duitku
Route::post('coin/callback', [CoinController::class, 'callback']);

Route::post('subscription/callback', [SubscriptionController::class, 'callback']);

Route::group(['prefix' => 'auth'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('google', [AuthController::class, 'loginGoogle']);
});

Route::middleware('auth:sanctum')->prefix('user')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/', [UserController::class, 'store']);
    Route::post('/generate-token', [UserController::class, 'updateFcmToken']);
    Route::post('/upload', [UserController::class, 'upload']);
    Route::put('/{id}', [UserController::class, 'update']);
    Route::delete('/{id}', [UserController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('bookmark')->group(function () {
    Route::get('/', [BookmarkController::class, 'index']);
    Route::post('/', [BookmarkController::class, 'store']);
    Route::put('/{id}', [BookmarkController::class, 'update']);
    Route::delete('/{id}', [BookmarkController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('comunity')->group(function () {
    Route::get('/', [ComunityController::class, 'index']);
    Route::post('/', [ComunityController::class, 'store']);
    Route::put('/{id}', [ComunityController::class, 'update']);
    Route::post('/join/{id}', [ComunityController::class, 'join']);
    Route::post('/leave/{id}', [ComunityController::class, 'leave']);
});

Route::middleware('auth:sanctum')->prefix('forum-post')->group(function () {
    Route::get('/', [ForumController::class, 'index']);
    Route::post('/', [ForumController::class, 'store']);
    Route::post('/like', [ForumController::class, 'like']);
    Route::put('/{id}', [ForumController::class, 'update']);
    Route::delete('/{id}', [ForumController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('comment')->group(function () {
    // Route::get('/', [ForumController::class, 'index']);
    Route::post('/', [CommentController::class, 'store']);
    Route::post('/like', [CommentController::class, 'like']);
    Route::put('/{id}', [CommentController::class, 'update']);
    Route::delete('/{id}', [CommentController::class, 'delete']);
});

Route::prefix('rekening-bank')->group(function () {
    Route::get('/', [RekeningBankController::class, 'index']);
    Route::post('/', [RekeningBankController::class, 'store'])->middleware('auth:sanctum');
    Route::put('/{id}', [RekeningBankController::class, 'update'])->middleware('auth:sanctum');
    Route::delete('/{id}', [RekeningBankController::class, 'delete'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->prefix('donasi')->group(function () {
    Route::get('/', [DonasiController::class, 'index']);
    Route::post('/', [DonasiController::class, 'store']);
    Route::put('/{id}', [DonasiController::class, 'update']);
    Route::delete('/{id}', [DonasiController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('note')->group(function () {
    Route::get('/', [NoteController::class, 'index']);
    Route::post('/', [NoteController::class, 'store']);
    Route::put('/{id}', [NoteController::class, 'update']);
    Route::delete('/{id}', [NoteController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('highlight')->group(function () {
    Route::get('/', [HighlightController::class, 'index']);
    Route::post('/', [HighlightController::class, 'store']);
    Route::put('/{id}', [HighlightController::class, 'update']);
    Route::delete('/{id}', [HighlightController::class, 'delete']);
    Route::post('/delete-all', [HighlightController::class, 'deleteAll']);
});

Route::middleware('auth:sanctum')->prefix('plan')->group(function () {
    Route::get('/', [PlanController::class, 'index']);
    Route::post('/', [PlanController::class, 'store']);
    Route::put('/{id}', [PlanController::class, 'update']);
    Route::delete('/{id}', [PlanController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('subscription')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index']);
    Route::post('/', [SubscriptionController::class, 'store']);
    Route::post('/renew', [SubscriptionController::class, 'renew']);
    Route::post('/status-payment', [SubscriptionController::class, 'cekTransaksi']);
    Route::put('/{id}', [SubscriptionController::class, 'update']);
    Route::delete('/{id}', [SubscriptionController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('reminder')->group(function () {
    Route::get('/', [ReminderController::class, 'index']);
    Route::get('/test-notif', [ReminderController::class, 'testingNotifikasi']);
    Route::post('/', [ReminderController::class, 'store']);
    Route::put('/{id}', [ReminderController::class, 'update']);
    Route::delete('/{id}', [ReminderController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('schedule')->group(function () {
    Route::get('/', [ScheduleController::class, 'index']);
    Route::post('/', [ScheduleController::class, 'store']);
    Route::put('/{id}', [ScheduleController::class, 'update']);
    Route::delete('/{id}', [ScheduleController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('journal')->group(function () {
    Route::get('/', [JournalController::class, 'index']);
    Route::post('/', [JournalController::class, 'store']);
    Route::put('/{id}', [JournalController::class, 'update']);
    Route::delete('/{id}', [JournalController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('course')->group(function () {
    Route::get('/', [CourseController::class, 'index']);
    Route::post('/', [CourseController::class, 'store']);
    Route::put('/{id}', [CourseController::class, 'update']);
    Route::delete('/{id}', [CourseController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('lesson')->group(function () {
    Route::get('/', [LessonController::class, 'index']);
    Route::post('/', [LessonController::class, 'store']);
    Route::put('/{id}', [LessonController::class, 'update']);
    Route::delete('/{id}', [LessonController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('quiz')->group(function () {
    Route::get('/result', [QuizzeController::class, 'result']);
    Route::get('/leaderboard', [QuizzeController::class, 'leaderboard']);
    Route::post('/', [QuizzeController::class, 'store']);
    Route::put('/{id}', [QuizzeController::class, 'update']);
    Route::post('/start', [QuizzeController::class, 'start']);
    Route::post('/submit', [QuizzeController::class, 'submit']);
    // Route::delete('/{id}', [QuizzeController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('haji-umroh')->group(function () {
    Route::get('/', [HajiUmrohController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('ask-ustad')->group(function () {
    Route::get('/', [TanyaUstadController::class, 'index']);
    Route::post('/', [TanyaUstadController::class, 'store']);
    Route::put('/{id}', [TanyaUstadController::class, 'update']);
    Route::delete('/{id}', [TanyaUstadController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('asma')->group(function () {
    Route::get('/', [AsmaController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('zikir')->group(function () {
    Route::get('/', [DzikirController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('type-zikir')->group(function () {
    Route::get('/', [TypeDzikirController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('content')->group(function () {
    Route::get('/', [ContentController::class, 'index']);
    Route::post('/', [ContentController::class, 'store']);
    Route::put('/{id}', [ContentController::class, 'update']);
    Route::post('/view', [ContentController::class, 'view']);
    Route::post('/like', [ContentController::class, 'like']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/follow/{user}', [FollowController::class, 'follow']);
    Route::delete('/unfollow/{user}', [FollowController::class, 'unfollow']);
    Route::get('/followers/{user}', [FollowController::class, 'followers']);
    Route::get('/following/{user}', [FollowController::class, 'following']);
});

Route::middleware('auth:sanctum')->prefix('paket')->group(function () {
    Route::get('/', [CoinPackageController::class, 'index']);
    Route::post('/', [CoinPackageController::class, 'store']);
    Route::put('/{id}', [CoinPackageController::class, 'update']);
    Route::delete('/{id}', [CoinPackageController::class, 'delete']);
});

Route::middleware('auth:sanctum')->prefix('coin')->group(function () {
    Route::get('/', [CoinController::class, 'index']);
    Route::get('/purchase', [CoinController::class, 'purchase']);
    Route::post('/topup', [CoinController::class, 'topup']);
    Route::post('/status-payment', [CoinController::class, 'cekTransaksi']);
    Route::post('/payment-methode', [CoinController::class, 'paymentMethode']);
});

Route::middleware('auth:sanctum')->prefix('kategori')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
});

Route::middleware('auth:sanctum')->prefix('produk')->group(function () {
    Route::get('/', [ProdukController::class, 'index']);
    Route::prefix('transaksi')->group(function () {
        Route::get('/', [TransaksiProdukController::class, 'index']);
        Route::post('/', [TransaksiProdukController::class, 'store']);
        Route::post('/refund', [TransaksiProdukController::class, 'refund']);
    });
});

Route::middleware('auth:sanctum')->prefix('chat-ai')->group(function () {
    Route::post('/', [AiController::class, 'chat']);
});
