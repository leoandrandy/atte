<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Work;
use Carbon\Carbon;

class RestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $work = Work::inRandomOrder()->first(); // ランダムに勤務を取得

        // ランダムな休憩開始時間
        $restStart = Carbon::parse($work->work_start)->addHours(rand(1, 3))->setMinutes(rand(0, 59));

        // 休憩終了時間を開始時間の30〜60分後に設定
        $restEnd = (clone $restStart)->addMinutes(rand(30, 60));

        return [
            'works_id' => $work->id,
            'rest_start' => $restStart,
            'rest_end' => $restEnd,
        ];
    }

}
