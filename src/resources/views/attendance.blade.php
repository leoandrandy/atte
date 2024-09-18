@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/attendance.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="list_header">
        <div class="list_header--item">
            <a href="{{ route('list', ['date' => $previousDate]) }}">&lt;</a>
            <span>{{ $date }}</span>
            <a href="{{ route('list', ['date' => $nextDate]) }}">&gt;</a>
        </div>
    </div>

    <div class="work_table">
        <table class="table">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>勤務開始</th>
                    <th>勤務終了</th>
                    <th>休憩時間</th>
                    <th>勤務時間</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($works as $work)
                <tr>
                    <td>{{ $work->user->name }}</td>
                    <td>{{ $work->work_start ? $work->work_start->format('H:i:s') : '未設定' }}</td>
                    <td>{{ $work->work_end ? $work->work_end->format('H:i:s') : '未設定' }}</td>
                    <td>{{ gmdate('H:i:s', $work->getTotalRestTime()) }}</td>
                    <td>{{ gmdate('H:i:s', $work->total_work_time) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pagination-links">
            {{ $works->appends(['date' => $date])->links('vendor.pagination.default') }}
        </div>
    </div>

</div>
@endsection