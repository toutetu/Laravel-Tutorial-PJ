<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
/* Folderモデル の名前空間をインポートする */
use App\Models\Folder;
// タスククラスを名前空間でインポートする
use App\Models\Task;

use App\Http\Requests\CreateTask;

use App\Http\Requests\EditTask;

// Authクラスをインポートする
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    // /**
    //  *  【タスク一覧ページの表示機能】
    //  *  
    //  *  GET /folders/{id}/tasks
    //  *  @param int $id
    //  * 
    //  *  @return \Illuminate\View\View
    //  */
    /**
     *  【タスク一覧ページの表示機能】
     *
     *  GET /folders/{folder}/tasks
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */


    public function index(Folder $folder)
    {

                // // id と user_id をコンソールに表示
                // dump('Auth user id: ' . Auth::user()->id);
                // dump('Folder user id: ' . $folder->user_id);
        
                // /* 権限がないコンテンツを403エラーで返す */
                // if (Auth::user()->id !== $folder->user_id) {
                    
        
                //     abort(403);
                // }



        // /* Folderモデルの全てのデータをDBから取得する */
        // // all()：全てのデータを取得する関数

        // $folders = Folder::all();

        // /* ユーザーによって選択されたフォルダを取得する */
        // // find()：一行分のデータを取得する関数
        // $folder = Folder::find($id);

        //     // 指定したフォルダが存在しない場合 if文 を実行する
        //     if (is_null($folder)) {
        //         /* abort関数で404ステータスを実行する */
        //         // abort() : 全ての処理を止めて、指定したエラーページを表示する
        //     abort(404);
        // }

            /** @var App\Models\User **/
            $user = auth()->user();
            $folders = $user->folders()->get();


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
            "folder_id" =>  $folder->id,
            'tasks' => $tasks
        ]);
    }

    /**
     *  【タスク作成ページの表示機能】
     *  
     *  GET /folders/{id}/tasks/create
     *  @param int $id
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    // public function showCreateForm(int $id)
    public function showCreateForm(Folder $folder)
    {
            /** @var App\Models\User **/
            $user = Auth::user();
            //    $folder = $user->folders()->findOrFail($id);
            $folder = $user->folders()->findOrFail($folder->id);

        return view('tasks/create', [
            // 'folder_id' => $id
            'folder_id' => $folder->id,
        ]);
    }

     /**
     *  【タスクの作成機能】
     *
     *  POST /folders/{id}/tasks/create
     *  @param int $id
     *  @param Folder $folder
     *  @param CreateTask $request
     *  @return \Illuminate\Http\RedirectResponse
     *  @var App\Http\Requests\CreateTask
     */
    // public function create(int $id, CreateTask $request)
    public function create(Folder $folder, CreateTask $request)
    {
        
          /** @var App\Models\User **/
          $user = Auth::user();
        
        /* ユーザーによって選択されたフォルダを取得する */
        // find()：一行分のデータを取得する関数
        // $folder = Folder::find($id);
        // $folder = $user->folders()->findOrFail($id);
        $folder = $user->folders()->findOrFail($folder->id);

        /* 新規作成のタスク（タイトル）をDBに書き込む処理 */
        // タスクモデルのインスタンスを作成する
        $task = new Task();
        // タイトルに入力値を代入する
        $task->title = $request->title;
        // 期限に入力値を代入する
        $task->due_date = $request->due_date;
        // $folderに紐づくタスクを生成する（インスタンスの状態をデータベースに書き込む）
        $folder->tasks()->save($task);

        /* タスク一覧ページにリダイレクトする */
        // リダイレクト：別URLへの転送（リクエストされたURLとは別のURLに直ちに再リクエストさせます）
        // route('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        // redirect():リダイレクトを実施する関数
        // route():ルートPathを指定する関数
        return redirect()->route('tasks.index', [
            // 'id' => $folder->id,
            'folder' => $folder->id,
        ]);
    }

        /**
     *  【タスク編集ページの表示機能】
     *  機能：タスクIDをフォルダ編集ページに渡して表示する
     *  
     *  GET /folders/{id}/tasks/{task_id}/edit
     *  @param int $task_id
     *  @return \Illuminate\View\View
     */
    // *  @param int $id

    // public function showEditForm(int $id, int $task_id)
    public function showEditForm(Folder $folder, Task $task)
    {
        
                /** @var App\Models\User **/
                $user = Auth::user();
                // $folder = $user->folders()->findOrFail($id);
                $folder = $user->folders()->findOrFail($folder->id);
        
                // $task = Task::find($task_id);
                // $task = $folder->find($task_id);
                // $task = $folder->tasks()->findOrFail($task_id);
                $task = $folder->tasks()->findOrFail($task->id);

        return view('tasks/edit', [
            'task' => $task,
        ]);
    }


      /**
     *  【タスクの編集機能】
     *  機能：タスクが編集されたらDBを更新処理をしてタスク一覧にリダイレクトする
     *  
     *  POST /folders/{id}/tasks/{task_id}/edit

     *  @param Folder $folder
     *  @param Task $task
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    // *  @param int $id
    // *  @param int $task_id


     // public function edit(int $id, int $task_id, EditTask $request)
    public function edit(Folder $folder, Task $task, EditTask $request)
    {
                /** @var App\Models\User **/
                $user = Auth::user();
                // $folder = $user->folders()->findOrFail($id);
                $folder = $user->folders()->findOrFail($folder->id);
                
                
                // $task = Task::find($task_id);
                // $task = $folder->find($task_id);
                // $task = $folder->tasks()->findOrFail($task_id);
                $task = $folder->tasks()->findOrFail($task->id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            // 'id' => $task->folder_id,
            'folder' => $task->folder_id,
        ]);
    }

        /**
     *  【タスク削除ページの表示機能】
     *
     *  GET /folders/{id}/tasks/{task_id}/delete
     *  @param Folder $folder
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    // *  @param int $id
    // *  @param int $task_id

    // public function showDeleteForm(int $id, int $task_id)
    public function showDeleteForm(Folder $folder, Task $task)
    {

        /** @var App\Models\User **/
        $user = Auth::user();
        // $folder = $user->folders()->findOrFail($id);
        $folder = $user->folders()->findOrFail($folder->id);

        // $task = Task::find($task_id);
        // $task = $folder->tasks()->findOrFail($task_id);
        $task = $folder->tasks()->findOrFail($task->id);


        return view('tasks/delete', [
            'task' => $task,
        ]);
    }
    
    /**
     *  【タスクの削除機能】
     *
     *  POST /folders/{id}/tasks/{task_id}/delete
     *  @param Folder $folder
     *  @param Task $task
     *  @return \Illuminate\View\View
     */
    // *  @param int $id
    // *  @param int $task_id
    // public function delete(int $id, int $task_id)
    public function delete(Folder $folder, Task $task)
    {

                /** @var App\Models\User **/
                $user = Auth::user();
                //  $folder = $user->folders()->findOrFail($id);
                $folder = $user->folders()->findOrFail($folder->id);
                
                // $task = Task::find($task_id);
                //  $task = $folder->tasks()->findOrFail($task_id);
                $task = $folder->tasks()->findOrFail($task->id);
        

                $task->delete();

                return redirect()->route('tasks.index', [
                    // 'id' => $id
                    'folder' => $task->folder_id
                ]);
    }
}