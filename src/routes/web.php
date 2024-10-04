<?php

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AttendanceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

Auth::routes(['verify' => true]);

// ログインホーム画面
Route::get('/', function () {
    if (Auth::check()) {
        // ユーザーがログイン済みで、メール確認も完了している場合にのみホームへ
        return redirect()->route('home');
    } else {
        return redirect()->route('login'); // 未ログインの場合、ログイン画面へリダイレクト
    }
})->middleware(['auth', 'verified']);  // ログインとメール確認を両方要求するミドルウェア


// ホーム画面
Route::middleware('auth')->get('/home', [AuthController::class, 'index'])->name('home');


// ログイン画面へのルート
Route::get('/login', [AttendanceController::class, 'showLoginForm'])->name('login');
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

Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');
