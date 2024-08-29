<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    //打刻処理
    public function work(Request $request)
    {
        $now_date = now()->toDateString(); // 現在の日付を取得
        $user_id = Auth::user()->id;
        $work = Work::where('user_id', $user_id)
            ->where('date', $now_date)
            ->first();

        if (!$work) {
            // 該当する日付のレコードが存在しない場合、新規作成
            $work = new Work();
            $work->user_id = $user_id;
            $work->date = $now_date;
        }

        switch ($request->input('action')) {
            case 'work_start':
                $work->work_start = now(); // 勤務開始時刻を保存
                break;

            case 'work_end':
                $work->work_end = now(); // 勤務終了時刻を保存
                break;

            case 'break_start':
                $work->break_start = now(); // 休憩開始時刻を保存
                break;

            case 'berak_end':
                $work->break_end = now(); // 休憩終了時刻を保存
                break;
        }

        $work->save();

        return redirect()->back()->with('success', '記録が更新されました');
    
    }
               

}