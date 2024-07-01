<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// フォルダーモデルを名前空間でインポートする
use App\Models\Folder;

// FormRequestクラスを名前空間でインポートする
use App\Http\Requests\CreateFolder;

use App\Http\Requests\EditFolder;

// Authクラスをインポートする
use Illuminate\Support\Facades\Auth;


class FolderController extends Controller
{
    /**
     *  【フォルダ作成ページの表示機能】
     *
     *  GET /folders/create
     *  @return \Illuminate\View\View
     */
    public function showCreateForm()
    {
        /* フォルダの新規作成ページを呼び出す */
        // view('遷移先のbladeファイル名');
        // return view('folders/create');
        $folders = Auth::user()->folders;
        
        return view('folders/create', compact('folders'));

    }

    /**
     *  【フォルダの作成機能】
     *  
     *  POST /folders/create
     *  @param Request $request （リクエストクラスの$request）
     *  @return \Illuminate\Http\RedirectResponse
     *   @var App\Http\Requests\CreateFolder
     */
    public function create(CreateFolder $request)
    {
        /* 新規作成のフォルダー名（タイトル）をDBに書き込む処理 */
        // フォルダモデルのインスタンスを作成する
        $folder = new Folder();
        // タイトルに入力値を代入する
        $folder->title = $request->title;
        // インスタンスの状態をデータベースに書き込む
        // $folder->save();
        
                // （ログイン）ユーザーに紐づけて保存する
                Auth::user()->folders()->save($folder);

        /* タスク一覧ページにリダイレクトする */
        // リダイレクト：別URLへの転送（リクエストされたURLとは別のURLに直ちに再リクエストさせます）
        // route('遷移先のbladeファイル名', [連想配列：渡したい変数についての情報]);
        // 連想配列：['キー（テンプレート側で参照する際の変数名）' => '渡したい変数']
        // redirect():リダイレクトを実施する関数
        // route():ルートPathを指定する関数
        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }
    /**
     *  【フォルダ編集ページの表示機能】
     *
     *  GET /folders/{id}/edit
     *  @param int $id
     *  @return \Illuminate\View\View
     */
    public function showEditForm(int $id)
    {
               /** @var App\Models\User **/
               $user = Auth::user();
        // $folder = Folder::find($id);
        $folder = $user->folders()->findOrFail($id);

        return view('folders/edit', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }
    /**
     *  【フォルダの編集機能】
     *
     *  POST /folders/{id}/edit
     *  @param int $id
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    public function edit(int $id, EditFolder $request)
    {
              /** @var App\Models\User **/
              $user = Auth::user();
              $folder = $user->folders()->findOrFail($id);
        // $folder = Folder::find($id);

        $folder->title = $request->title;
        $folder->save();

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }


        /**
     *  【フォルダ削除ページの表示機能】
     *  機能：フォルダIDをフォルダ編集ページに渡して表示する
     *
     *  GET /folders/{id}/delete
     *  @param int $id
     *  @return \Illuminate\View\View
     */
    public function showDeleteForm(int $id)
    {
        
        /** @var App\Models\User **/
        $user = Auth::user();
        // $folder = Folder::find($id);
        $folder = $user->folders()->findOrFail($id);

        return view('folders/delete', [
            'folder_id' => $folder->id,
            'folder_title' => $folder->title,
        ]);
    }

    /**
     *  【フォルダの削除機能】
     *  機能：フォルダが削除されたらDBから削除し、フォルダ一覧にリダイレクトする
     *
     *  POST /folders/{id}/delete
     *  @param int $id
     *  @return RedirectResponse
     */
    public function delete(int $id)
    {
         /** @var App\Models\User **/
         $user = Auth::user();
         
        // $folder = Folder::find($id);
         $folder = $user->folders()->findOrFail($id);
 

        $folder->tasks()->delete();
        $folder->delete();

        $folder = Folder::first();

        return redirect()->route('tasks.index', [
            'id' => $folder->id
        ]);
    }

    


}