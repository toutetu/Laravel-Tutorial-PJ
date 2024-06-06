<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* Folderモデル の名前空間をインポートする */
use App\Models\Folder;
// タスククラスを名前空間でインポートする
use App\Models\Task;

class TaskController extends Controller
{
    /**
     *  【タスク一覧ページの表示機能】
     *  
     *  GET /folders/{id}/tasks
     *  @param int $id
     * 
     *  @return \Illuminate\View\View
     */
    public function index(int $id)
    {
        /* Folderモデルの全てのデータをDBから取得する */
        // all()：全てのデータを取得する関数

        $folders = Folder::all();

        /* ユーザーによって選択されたフォルダを取得する */
        // find()：一行分のデータを取得する関数
        $folder = Folder::find($id);

        /* ユーザーによって選択されたフォルダに紐づくタスクを取得する */
        // where(カラム名,カラムに対して比較する値)：特定の条件を指定する関数 ※一致する場合の条件 `'='` を省略形で記述しています
        // get()：値を取得する関数（この場合はwhere関数で生成されたSQL文を発行して値を取得する）
        // $tasks = Task::where('folder_id', $folder->id)->get();
        $tasks = $folder->tasks()->get();

        /* DBから取得した情報をViewに渡す */
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/index', [
            'folders' => $folders,
            "folder_id" => $id,
            'tasks' => $tasks
        ]);
    }
}