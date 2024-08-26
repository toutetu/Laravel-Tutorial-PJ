<?php

use Illuminate\Support\Facades\Route;
/* TaskControllerクラスを名前空間でインポートする */
use App\Http\Controllers\TaskController;

use App\Http\Controllers\FolderController;

use App\Http\Controllers\HomeController;

use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\LogController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/* Laravel welcome Page */
Route::get('/', function () {
    return view('welcome');
});


// /* index page */
// Route::get("/folders/{id}/tasks", [TaskController::class,"index"])->name("tasks.index");

// /* folders new create page */
// Route::get('/folders/create', [FolderController::class,"showCreateForm"])->name('folders.create');
// Route::post('/folders/create', [FolderController::class,"create"]);

// /* folders new edit page */
// Route::get('/folders/{id}/edit', [FolderController::class,"showEditForm"])->name('folders.edit');
// Route::post('/folders/{id}/edit', [FolderController::class,"edit"]);

// /* tasks new create page */
// Route::get('/folders/{id}/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
// Route::post('/folders/{id}/tasks/create', [TaskController::class,"create"]);


// /* tasks new edit page */
// Route::get('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
// Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,"edit"]);

// /* folders new delete page */
// Route::get('/folders/{id}/delete', [FolderController::class,"showDeleteForm"])->name('folders.delete');
// Route::post('/folders/{id}/delete', [FolderController::class,"delete"]);

// /* tasks new delete page */
// Route::get('/folders/{id}/tasks/{task_id}/delete', [TaskController::class,"showDeleteForm"])->name('tasks.delete');
// Route::post('/folders/{id}/tasks/{task_id}/delete', [TaskController::class,"delete"]);

// /* home page */
// Route::get('/', [HomeController::class,"index"])->name('home');
// Auth::routes();

// // Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//  /* certification page （会員登録・ログイン・ログアウト・パスワード再設定など） */
// //  Auth::routes();
//  Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 /*
 * 認証を求めるミドルウェアのルーティング
 * 機能：ルートグループによる一括適用とミドルウェアによるページ認証
 * 用途：全てのページに対してページ認証を求める
 */
Route::group(['middleware' => 'auth'], function() {
    /* home page */
    Route::get('/', [HomeController::class,"index"])->name('home');
    
     /* folders new create page */
     Route::get('/folders/create', [FolderController::class,"showCreateForm"])->name('folders.create');
     Route::post('/folders/create', [FolderController::class,"create"]);
     
     /*
    * ポリシーをミドルウェアを介して使用するルーティング
    * 機能：ルートグループによる一括適用とミドルウェアによるポリシーの呼び出し
    * 用途：Folderモデル(FolderPolicyポリシー)で定義されたviewメソッドのポリシーを使用する
    * can:認可処理の種類,ポリシーに渡すルートパラメーター（URLの変数部分）
    */
    Route::group(['middleware' => 'can:view,folder'], function() {
        /* index page */
        Route::get("/folders/{folder}/tasks", [TaskController::class,"index"])->name("tasks.index");


        /* folders new create page */
        Route::get('/folders/create', [FolderController::class,"showCreateForm"])->name('folders.create');
        Route::post('/folders/create', [FolderController::class,"create"]);

        /* folders new edit page */
        Route::get('/folders/{folder}/edit', [FolderController::class,"showEditForm"])->name('folders.edit');
        Route::post('/folders/{folder}/edit', [FolderController::class,"edit"]);

        /* folders new delete page */
        Route::get('/folders/{folder}/delete', [FolderController::class,"showDeleteForm"])->name('folders.delete');
        Route::post('/folders/{folder}/delete', [FolderController::class,"delete"]);

        /* tasks new create page */
        // Route::get('/folders/{id}/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
        Route::get('/folders/{folder}/tasks/create', [TaskController::class,"showCreateForm"])->name('tasks.create');
        // Route::post('/folders/{id}/tasks/create', [TaskController::class,"create"]);
        Route::post('/folders/{folder}/tasks/create', [TaskController::class,"create"]);

        /* tasks new edit page */
        // Route::get('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
        Route::get('/folders/{folder}/tasks/{task}/edit', [TaskController::class,"showEditForm"])->name('tasks.edit');
        // Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class,"edit"]);
        Route::post('/folders/{folder}/tasks/{task}/edit', [TaskController::class,"edit"]);
        
        /* tasks new delete page */
        // Route::get('/folders/{id}/tasks/{task_id}/delete', [TaskController::class,"showDeleteForm"])->name('tasks.delete');
        Route::get('/folders/{folder}/tasks/{task}/delete', [TaskController::class,"showDeleteForm"])->name('tasks.delete');
        // Route::post('/folders/{id}/tasks/{task_id}/delete', [TaskController::class,"delete"]);
        Route::post('/folders/{folder}/tasks/{task}/delete', [TaskController::class,"delete"]);

        
    });
    
    Route::get('/logs/work', [LogController::class, 'showWorkLog'])->name('logs.work');
});

    /* certification page （会員登録・ログイン・ログアウト・パスワード再設定など） */
    Auth::routes();
    