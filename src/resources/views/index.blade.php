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
    $status = $work ? $work->status : null;
    @endphp


    <div class="attendance__panel">
        <form class="attendance__button" action="{{ route('work') }}" method="post">
            <p>現在のステータス: {{ $status }}</p>
            @csrf
            <button class="attendance__button-submit" type="submit" name="action" value="work_start"
                @if($status !==null) disabled @endif>
                勤務開始
            </button>

            <button class="attendance__button-submit" type="submit" name="action" value="work_end"
                @if($status !==1) disabled @endif>
                勤務終了
            </button>

            <button class="attendance__button-submit" type="submit" name="action" value="rest_start"
                @if($status !==1) disabled @endif>
                休憩開始
            </button>

            <button class="attendance__button-submit" type="submit" name="action" value="rest_end"
                @if($status !==3) disabled @endif>
                休憩終了
            </button>
        </form>
    </div>
</div>
@endsection