<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')
<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：scripts を指定
*   用途：javascriptライブラリー「flatpickr」のスタイルシートを指定
-->
{{-- <script src="https://cdn.tailwindcss.com"></script> --}}

@section('styles')
    <!-- 「flatpickr」の デフォルトスタイルシートをインポート -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <!-- 「flatpickr」の ブルーテーマの追加スタイルシートをインポート -->
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/material_blue.css">
@endsection

{{-- @section('content')
<div class="container mt-4">
    <h1 class="mb-4">ログ管理画面</h1>
    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th class="col-1">ID</th>
                    <th class="col-2">日時</th>
                    <th class="col-2">ユーザー</th>
                    <th class="col-2">ログ名</th>
                    <th class="col-5">説明</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr>
                    <td class="col-1">{{ $activity->id }}</td>
                    <td class="col-2">{{ $activity->created_at->format('Y/m/d H:i') }}</td>
                    <td class="col-2">{{ $activity->causer ? $activity->causer->name : 'システム' }}</td>
                    <td class="col-2">{{ $activity->log_name }}</td>
                    <td class="col-5">{{ $activity->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between mt-4">
        {{ $activities->links() }}
    </div>
</div>
@endsection --}}

@section('content')

<style>
    .table th:nth-child(1), .table td:nth-child(1) { width: 50px; } /* ID列 */
    .table th:nth-child(3), .table td:nth-child(3) { width: 150px; } /* ユーザー列 */
    .table th:nth-child(5), .table td:nth-child(5) { width: auto; } /* 説明列 */
</style>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <nav class="panel panel-default">
                <div class="panel-heading">ログ管理</div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th >ID</th>
                                    <th>日時</th>
                                    <th>ユーザー名</th>
                                    <th>画面</th>
                                    <th>説明</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($activities as $activity)
                                <tr>
                                    <td>{{ $activity->id }}</td>
                                    <td>{{ $activity->created_at->format('Y/m/d H:i') }}</td>
                                    <td>{{ $activity->causer ? $activity->causer->name : 'システム' }}</td>
                                    <td>{{ $activity->log_name }}</td>
                                    <td>{{ $activity->description }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="text-center">
                {{ $activities->links() }}
            </div>
        </div>
    </div>
</div>
@endsection