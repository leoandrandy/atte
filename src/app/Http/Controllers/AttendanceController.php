<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    // ログインフォームを表示
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // ログイン処理
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/'); // ログイン成功時
        }

        return back()->withErrors([
            'email' => '認証情報が正しくありません。',
        ]);
    }

    // ログアウト処理
    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    // 会員登録フォームを表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 会員登録処理
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice'); // メール認証ページへリダイレクト
        }

        return redirect()->route('home'); // 認証済みの場合はホームへ
    }
    
    //打刻処理
    public function work(Request $request)
    {
        $now_date = now()->toDateString(); // 現在の日付を取得
        $user_id = Auth::user()->id;
        $work = Work::where('user_id', $user_id)
            ->where('date', $now_date)
            ->first();   // 現在の日付に対応する出勤記録を取得

        if ($work) {
            if ($work->status === 2) {
                return redirect()->back()->with('error', 'すでに出勤済みです。日付が変わるまで出勤できません。');
            }
        }

        //勤務開始の処理
        if ($request->input('action') === 'work_start') {
            if (!$work) {
                // 該当する日付のレコードが存在しない場合、新規作成
                $work = new Work();
                $work->user_id = $user_id;
                $work->date = $now_date;
            }

            if ($work->status === 1) {
                return redirect()->back()->with('error', 'すでに勤務を開始しています。');
            }

            $work->work_start = now(); // 勤務開始時刻を保存
            $work->status = 1; // 出勤中
            $message = '勤務を開始しました';
            $work->save();

            return redirect()->back()->with('success', $message)->with('work', $work);

        } 
        
        // 勤務終了の処理
        if ($request->input('action') === 'work_end') {
            $work->work_end = now(); // 勤務終了時刻を保存
            $work->status = 2; //退勤済
            $message = '勤務を終了しました';
            $work->save();

            return redirect()->back()->with('success', $message)->with('work', $work);

        }
        if ($request->input('action') === 'rest_start') {
            $rest = new Rest();
            $rest->works_id = $work->id; // works_idを設定 
            $rest->rest_start = now(); // 休憩開始時刻を保存
            $rest->save();

            $work->status = 3; // 休憩中
            $message = '休憩開始しました';
            $work->save();

            return redirect()->back()->with('success', $message)->with('work', $work);

        }
        if ($request->input('action') === 'rest_end') {
            $rest = Rest::where('works_id', $work->id)
            ->whereNull('rest_end') // 終了していない休憩を探す
                ->first();
            if ($rest) {
                $rest->rest_end = now(); // 休憩終了時刻を保存
                $rest->save();
            }

            $work->status = 1; // 出勤中に戻す
            $message = '休憩終了しました';
            $work->save();
            
            return redirect()->back()->with('success', $message)->with('work', $work);
        }
    }

    // 日付別一覧表示
    public function list(Request $request)
    {
        // 日付の取得。デフォルトは本日の日付
        $date = $request->query('date', now()->format('Y-m-d'));

        // 日付に基づいてデータを取得
        $works = Work::whereDate('date', $date)
        ->with('user') // リレーションをロード
        ->paginate(5);

        // 「前へ」「次へ」のための日付計算
        $previousDate = Carbon::parse($date)->subDay()->format('Y-m-d');
        $nextDate = Carbon::parse($date)->addDay()->format('Y-m-d');

        // ビューにデータと日付を渡す
        return view('attendance', compact('date', 'works', 'previousDate', 'nextDate'));
    }
}