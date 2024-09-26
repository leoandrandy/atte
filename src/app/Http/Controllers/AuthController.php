<?php

namespace App\Http\Controllers;

use App\Models\Work;

class AuthController extends Controller
{
    public function index()
    {
        $user_id = auth()->user()->id;
        $now_date = now()->toDateString();
        $work = Work::where('user_id', $user_id)
            ->where('date', $now_date)
            ->first();

        return view('index', ['work' => $work]);
    }
}
