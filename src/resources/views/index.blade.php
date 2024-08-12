@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('content')
<div class="attendance__comment">
    <!-- todo ユーザー名表示されるようにする  -->
    <h1>さんお疲れ様です</h1>
</div>
<div class="attendance__content">
    <div class="attendance__panel">
        <form class="attendance__button">
            <button class="attendance__button-submit" type="submit">勤務開始</button>
        </form>
        <form class="attendance__button">
            <button class="attendance__button-submit" type="submit">勤務終了</button>
        </form>
        <form class="attendance__button">
            <button class="attendance__button-submit" type="submit">休憩開始</button>
        </form>
        <form class="attendance__button">
            <button class="attendance__button-submit" type="submit">休憩終了</button>
        </form>
    </div>
</div>
@endsection