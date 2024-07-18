<!--
*   extends：親ビューを継承する（読み込む）
*   親ビュー名：layout を指定
-->
@extends('layout')

<!--
*   section：子ビューにsectionでデータを定義する
*   セクション名：content を指定
*   用途：会員登録ページを表示する
-->
@section('content')
<div class="container">
    <div class="row">
        <div class="col col-md-offset-3 col-md-6">
            <nav class="panel panel-default">
                <div class="panel-heading">会員登録</div>
                <div class="panel-body">
                    <!-- エラーメッセージを表示する -->
                    <!-- エラーがある場合はIF文の処理を実行する -->
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                <!-- エラーメッセージをループで全て列挙して表示する -->
                                @foreach($errors->all() as $message)
                                    <li>{{ $message }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <!-- Auth::routes()に定義されたルートを指定（php artisan route:list で参照できます） -->
                    <form action="{{ route('register') }}" method="POST">
                        <!-- セキュリティ対策：@csrf は、CSRFトークンを含んだ input 要素を出力します -->
                        @csrf
                        <div class="form-group">
                            <label for="email">メールアドレス</label>
                            <!--
                            *   入力値を復元する
                            *   old()：セッション値を取得する関数（この場合は入力されたタイトルをセッションとして扱う）
                            -->
                            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}" />
                        </div>
                        <div class="form-group">
                            <label for="name">ユーザー名</label>
                            <!--
                            *   入力値を復元する
                            *   old()：セッション値を取得する関数（この場合は入力されたタイトルをセッションとして扱う）
                            -->
                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" />
                        </div>
                        <div class="form-group">
                            <label for="password">パスワード</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>
                        <div class="form-group">
                            <label for="password-confirm">パスワード（確認）</label>
                            <!-- 
                            *   パスワード一致確認機能（ confirmed ルール）
                            *   name="目名（password）_confirmation"で表現されて入力値が一致するか検証しています。
                            -->
                            <input type="password" class="form-control" id="password-confirm" name="password_confirmation">
                        </div>
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">送信</button>
                        </div>
                    </form>
                </div>
            </nav>
        </div>
    </div>
</div>
@endsection