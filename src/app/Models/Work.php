<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $dates = [
        'work_start',
        'work_end',
    ];

    protected $fillable = [
        'user_id',
        'date',
        'work_start',
        'work_end',
        'status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rests()
    {
        return $this->hasMany(Rest::class, 'work_id');
    }

    // 休憩時間計算
    public function getTotalRestTime()
    {
        $rests = Rest::where('works_id', $this->id)->get();
        $totalRestTime = 0;

        foreach ($rests as $rest) {
            if ($rest->rest_start && $rest->rest_end) {
                $totalRestTime += $rest->rest_end->diffInSeconds($rest->rest_start);
            }
        }

        return $totalRestTime;
    }

    public function getTotalWorkTimeAttribute()
    {
        // 勤務時間（出勤から退勤まで）
        if ($this->work_start && $this->work_end) {
            $totalWorkTime = $this->work_end->diffInSeconds($this->work_start);
        } else {
            return 0;
        }

        // 休憩時間の合計を計算
        $totalRestTime = $this->getTotalRestTime();

        // 実働時間 = 勤務時間 - 休憩時間
        return $totalWorkTime - $totalRestTime;
    }


}
