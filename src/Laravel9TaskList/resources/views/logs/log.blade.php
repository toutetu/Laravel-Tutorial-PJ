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

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">ログ管理画面</h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead class="thead-light">
                <tr>
                    <th>no</th>
                    <th>日時</th>
                    <th>ユーザー名</th>
                    <th>画面</th>
                    <th>アクション</th>
                </tr>
            </thead>
            <tbody>
                @foreach($activities as $activity)
                <tr>
                    <td>{{ $activity->id}}</td>
                    <td>{{ $activity->created_at->format('Y/m/d H:i') }}</td>
                    <td>{{ $activity->causer ? $activity->causer->name : 'システム' }}</td>
                    <td>{{ $activity->properties['screen'] ?? 'N/A' }}</td>
                    <td>{{ $activity->description }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between mt-4">
        {{ $activities->links() }}
    </div>
</div>
@endsection