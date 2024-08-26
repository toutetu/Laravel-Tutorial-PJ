@extends('layout')
@section('content')

    <div class="container mt-5">
        <h1>作業記録ログファイル</h1>
        <pre>{{ $log }}</pre>
    </div>
@endsection
