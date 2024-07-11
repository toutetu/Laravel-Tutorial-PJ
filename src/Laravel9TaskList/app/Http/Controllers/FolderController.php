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

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Log;

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
        // $folders = Auth::user()->folders;
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            $user->folders;

            // return view('folders/create', compact('folders'));
            return view('folders/create');

        } catch (\Throwable $e) {
            Log::error('Error FolderController in showCreateForm: ' . $e->getMessage());
        }
        


    }

    /**
     *  【フォルダの作成機能】
     *  
     *  POST /folders/create
     *  @param CreateFolder $request （Requestクラスの機能は引き継がれる）
     *  @return \Illuminate\Http\RedirectResponse
     *   @var App\Http\Requests\CreateFolder
     */

    //  *  @param Request $request （リクエストクラスの$request）
    public function create(CreateFolder $request)
    {
        try {
            /* 新規作成のフォルダー名（タイトル）をDBに書き込む処理 */
            // フォルダモデルのインスタンスを作成する
            $folder = new Folder();
            // タイトルに入力値を代入する
            $folder->title = $request->title;
            // インスタンスの状態をデータベースに書き込む
            // $folder->save();
            
                    // （ログイン）ユーザーに紐づけて保存する
                    // Auth::user()->folders()->save($folder);
                    /** @var App\Models\User **/
                    $user = Auth::user();
                    $user->folders()->save($folder);


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
        } catch (\Exception $e) {
            Log::error('Error FolderController in create: ' . $e->getMessage());
        }
    }
    /**
     *  【フォルダ編集ページの表示機能】
     *
     *  GET /folders/{id}/edit
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    // *  @param int $id

    // public function showEditForm(int $id)
    public function showEditForm(Folder $folder)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            // $folder = Folder::find($id);
            // $folder = $user->folders()->findOrFail($id);
            $folder = $user->folders()->findOrFail($folder->id);

            return view('folders/edit', [
                'folder_id' => $folder->id,
                'folder_title' => $folder->title,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in showEditForm: ' . $e->getMessage());
        }
    }
    /**
     *  【フォルダの編集機能】
     *
     *  POST /folders/{id}/edit
     *  @param Folder $folder
     *  @param EditTask $request
     *  @return \Illuminate\Http\RedirectResponse
     */
    // @param int $id
    // public function edit(int $id, EditFolder $request)
    public function edit(Folder $folder, EditFolder $request)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            //   $folder = $user->folders()->findOrFail($id);
            $folder = $user->folders()->findOrFail($folder->id);
            // $folder = Folder::find($id);

            // $folder->title = $request->title;
            // $folder->save();

            $folder = DB::transaction(function () use ($folder) {
                if($folder) throw new \Exception('500');
                $folder->tasks()->delete();
                $folder->delete();
                return $folder;
            });

            $folder = Folder::first();

            return redirect()->route('tasks.index', [
                // 'id' => $folder->id,
                'folder' => $folder->id,
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in delete: ' . $e->getMessage());
        }
    }


        /**
     *  【フォルダ削除ページの表示機能】
     *  機能：フォルダIDをフォルダ編集ページに渡して表示する
     *
     *  GET /folders/{id}/delete
     *  @param Folder $folder
     *  @return \Illuminate\View\View
     */
    // @param int $id
    // public function showDeleteForm(int $id)
    public function showDeleteForm(Folder $folder)
    {
        
        /** @var App\Models\User **/
        $user = Auth::user();
        // $folder = Folder::find($id);
        // $folder = $user->folders()->findOrFail($id);
        $folder = $user->folders()->findOrFail($folder->id);

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
     *  @param Folder $folder
     *  @return RedirectResponse
     */
    // @param int $id
    // public function delete(int $id)
    public function delete(Folder $folder)
    {
        try {
            /** @var App\Models\User **/
            $user = Auth::user();
            
            // $folder = Folder::find($id);
            //  $folder = $user->folders()->findOrFail($id);
            $folder = $user->folders()->findOrFail($folder->id);

            $folder = DB::transaction(function () use ($folder) {
                if($folder) throw new \Exception('500');

                        $folder->tasks()->delete();
                        $folder->delete();
                        return $folder;
            });

            $folder = Folder::first();

            return redirect()->route('tasks.index', [
                // 'id' => $folder->id
                'folder' => $folder->id
            ]);
        } catch (\Throwable $e) {
            Log::error('Error FolderController in delete: ' . $e->getMessage());
        }
    }

    


}