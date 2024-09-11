@extends('layouts.app')

<style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        /* 全体を中央に寄せる */
        text-align: center;
    }

    .work_table {
        width: 100%;
        max-width: 1000px;
        /* テーブルの最大幅を制限して中央に配置 */
        margin: 0 auto;
        /* 左右の余白を自動で取ることで中央配置 */
    }

    .list_header--item {
        font-size: 1.5rem;
        /* 文字サイズを大きく */
        display: flex;
        justify-content: center;
        /* 水平方向の中央寄せ */
        align-items: center;
        /* 垂直方向の中央寄せ */
        gap: 10px;
        /* 矢印と日付の間にスペース */
    }

    .table {
        width: 100%;
        /* テーブル全体の幅を100%に */
        table-layout: auto;
        /* 列の幅を自動調整 */
    }

    th,td {
        padding: 15px 20px;
        white-space: nowrap;
        /* 文字が二行になるのを防ぐ */
    }

    th {
        background-color: #289ADC;
        color: white;
        padding: 5px 40px;
    }

    tr:nth-child(odd) td {
        background-color: #FFFFFF;
    }

    td {
        padding: 25px 40px;
        background-color: #EEEEEE;
        text-align: center;
    }

    svg.w-5.h-5 {
        /*paginateメソッドの矢印の大きさ調整のために追加*/
        width: 30px;
        height: 30px;
    }
</style>

@section('css')
<link rel="stylesheet" href="{{ asset('css/list_by_date.css') }}">
@endsection

@section('content')
<div class="container">
    <div class="list_header">
        <h1>勤怠一覧</h1>
        <div class="list_header--item">
            <a href="{{ route('list', ['date' => $previousDate]) }}">◀</a>
            <span>{{ $date }}</span>
            <a href="{{ route('list', ['date' => $nextDate]) }}">▶</a>
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
            {{ $works->appends(['date' => $date])->links() }}
        </div>
    </div>

</div>
@endsection