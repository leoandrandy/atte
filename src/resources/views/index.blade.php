@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__content">
    <div class="attendance__comment">
        <!-- ユーザー名表示する  -->
        <h2 class="attendance__comment-text">{{ Auth::user()->name }}さんお疲れ様です!</h2>
    </div>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @php
    $now_date = now()->toDateString();
    $status = $work ? $work->status : null;
    @endphp


    <div class="attendance__panel">
        <form class="attendance__button" action="{{ route('work') }}" method="post">
            @csrf
                @if ($work && $work->date === $now_date && $work->work_start)
                <button class="attendance__button-submit" type="submit" name="action" value="work_start" disabled>
                    勤務開始
                </button>
                @else
                <button class="attendance__button-submit" type="submit" name="action" value="work_start">
                    勤務開始
                </button>
                @endif
            
                @if ($status == 1)
                <button class="attendance__button-submit" type="submit" name="action" value="work_end">
                    勤務終了
                </button>
                @else
                <button class="attendance__button-submit" type="submit" name="action" value="work_end" disabled>
                    勤務終了
                </button>
                @endif

                @if ($status == 1)
                <button class="attendance__button-submit" type="submit" name="action" value="rest_start">
                    休憩開始
                </button>
                @else
                <button class="attendance__button-submit" type="submit" name="action" value="rest_start" disabled>
                    休憩開始
                </button>
                @endif

                @if ($status == 3)
                <button class="attendance__button-submit" type="submit" name="action" value="rest_end">
                    休憩終了
                </button>
                @else
                <button class="attendance__button-submit" type="submit" name="action" value="rest_end" disabled>
                    休憩終了
                </button>
                @endif
        </form>
    </div>
</div>
@endsection