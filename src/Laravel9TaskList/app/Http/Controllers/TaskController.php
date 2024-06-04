<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* Folderモデル の名前空間をインポートする */
use App\Models\Folder;

class TaskController extends Controller
{
    /**
     *  【タスク一覧ページの表示機能】
     *  
     *  GET /folders/{id}/tasks
     *  @param int $id
     *  @return \Illuminate\View\View
     */
    public function index(int $id)
    {
        /* Folderモデルの全てのデータをDBから取得する */
        $folders = Folder::all();

        /* タスク一覧ページを呼び出す */
        // view('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        return view('tasks/index', [
            'folders' => $folders,
            "folder_id" => $id
        ]);
    }
}