<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


//ログインホーム画面
Route::middleware('auth')->group(function () {
    Route::get('/', [AuthController::class, 'index']);
});

// ログイン画面へのルート
Route::get('/login', [AttendanceController::class, 'showLoginForm']);
Route::post('/login', [AttendanceController::class, 'login']);

// ログアウトのルート
Route::post('/logout', [AttendanceController::class, 'logout']);

// 登録画面へのルート
Route::get('/register', [AttendanceController::class, 'showRegistrationForm']);
Route::post('/register', [AttendanceController::class, 'register']);

//打刻処理
Route::post('/work', [AttendanceController::class, 'work'])->name('work');

//日付別一覧ページ
Route::get('/attendance', [AttendanceController::class, 'list'])->name('list');