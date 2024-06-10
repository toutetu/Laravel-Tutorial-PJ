<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
    <!--
    *   yield()：子ビューで定義したデータを表示する
    *   セクション名：styles を指定
    *   用途：javascriptライブラリー「flatpickr」のスタイルシートを指定
    -->
    @yield('styles')
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <header>
        <nav class="my-navbar">
            <a class="my-navbar-brand" href="/">ToDo App</a>
        </nav>
    </header>
    <main>
        <!--
        *   yield()：子ビューで定義したデータを表示する
        *   セクション名：content を指定
        *   用途：タスクを追加するHTMLを表示する
        -->
        @yield('content')
    </main>
    <!--
    *   yield()：子ビューで定義したデータを表示する
    *   セクション名：scripts を指定
    *   目的：flatpickr によるカレンダー形式による日付選択
    *   用途：javascriptライブラリー「flatpickr」のインポート
    -->
    @yield('scripts')
</body>
</html>