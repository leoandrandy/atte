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
    <div class="attendance__panel">
        <form class="attendance__button" action="{{ route('work') }}" method="post">
            @csrf
            <button class="attendance__button-submit" type="submit" name="action" value="work_start">勤務開始</button>
        
            <button class="attendance__button-submit" type="submit" name="action" value="work_end">勤務終了</button>
        
            <button class="attendance__button-submit" type="submit" name="action" value="break_start">休憩開始</button>
        
            <button class="attendance__button-submit" type="submit" name="action" value="berak_end">休憩終了</button>
        </form>
    </div>
</div>
@endsection