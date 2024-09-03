<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Work;
use App\Models\Rest;
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
                $work->status = 1; // 出勤中
                $message = '勤務を開始しました';
                break;

            case 'work_end':
                $work->work_end = now(); // 勤務終了時刻を保存
                $work->status = 2; //退勤済
                $message ='勤務を終了しました';
                break;

            case 'rest_start':
                $rest = new Rest();
                $rest->works_id = $work->id; // works_idを設定 
                $rest->rest_start = now(); // 休憩開始時刻を保存
                $rest->save();

                $work->status = 3; // 休憩中
                $message = '休憩開始しました';
                break;

            case 'rest_end':
                $rest = Rest::where('works_id', $work->id)
                ->whereNull('rest_end') // 終了していない休憩を探す
                ->first();

                if ($rest) {
                    $rest->rest_end = now(); // 休憩終了時刻を保存
                    $rest->save();
                }          
                
                $work->status = 1; // 出勤中に戻す
                $message = '休憩終了しました';
                break;
        }

        $work->save();

        return redirect()->back()->with('success', $message)->with('work', $work);
    
    }
               

}