<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ToDo App</title>
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
<header>
    <nav class="my-navbar">
        <a class="my-navbar-brand" href="/">ToDo App</a>
    </nav>
</header>
<main>
    <div class="container">
        <div class="row">
            <div class="col col-md-4">
                <nav class="panel panel-default">
                    <div class="panel-heading">フォルダ</div>
                    <div class="panel-body">
                        <a href="#" class="btn btn-default btn-block">
                            フォルダを追加する
                        </a>
                    </div>
                    <div class="list-group">
                        <table class="table foler-table">
                            <!--
                            * 【folder一覧セクション】
                            * foreach の中で TaskController から渡されたデータ $folders を参照する
                            * $folders をループしてタイトルを全て表示する
                            -->
                            @foreach($folders as $folder)
                            <tr>
                                <td>
                                    <!--
                                    * アンカーリンクのhref属性を変数展開してルートを呼び出している
                                    * ルート関数：route('ルート名', [ルートURLのうち変数になっている部分（$folder->id）])
                                    -->
                                    <a href="{{ route('tasks.index', ['id' => $folder->id]) }}" class="list-group-item {{ $folder_id === $folder->id ? 'active' : '' }}">
                                    <!-- フォルダのタイトルを表示する -->        
                                        {{ $folder->title }}
                                    </a>
                                </td>
                                <td><a href="#">編集</a></td>
                                <td><a href="#">削除</a></td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </nav>
            </div>
            <div class="column col-md-8">
            <!-- ここにタスクが表示される -->
                <div class="panel panel-default">
                    <div class="panel-heading">タスク</div>
                    <div class="panel-body">
                        <div class="text-right">
                            <a href="#" class="btn btn-default btn-block">
                                タスクを追加する
                            </a>
                        </div>
                    </div>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>タイトル</th>
                                <th>状態</th>
                                <th>期限</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <!--
                            * 【task一覧セクション】
                            * foreach の中でTaskControllerから渡されたデータ $tasks を参照する
                            * $tasks をループして値を全て表示する
                            -->
                            @foreach($tasks as $task)
                                <tr>
                                    <!-- タスクのタイトルを表示する -->
                                    <td>{{ $task->title }}</td>
                                    <!-- タスクの状態を表示する -->
                                    <td>
                                        <span class="label {{ $task->status_class }}">{{ $task->status_label }}</span>
                                    </td>
                                    <!-- タスクの期限を表示する -->
                                    <td>{{ $task->formatted_due_date }}

                                    </td>
                                    <!-- 編集と削除のリンクを表示する -->
                                    <td><a href="#">編集</a></td>
                                    <td><a href="#">削除</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
</body>
</html>