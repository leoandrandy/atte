<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Work;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class WorkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $randomDate = Carbon::today()->subDays(rand(0, 30));
        $workStart = $randomDate->copy()->setTime(rand(8, 10), rand(0, 59), 0);
        $workEnd = (clone $workStart)->addHours(8);

        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'work_start' => $workStart,
            'work_end' => $workEnd,
            'date' => $randomDate->toDateString(), // 日付を追加
            'status' => 2, // 勤務終了済み
        ];
    }
}
