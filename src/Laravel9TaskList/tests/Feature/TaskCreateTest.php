<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Http\Requests\CreateTask;
use Carbon\Carbon;
use Tests\TestCase;

use Illuminate\Support\Facades\Auth;

use App\Models\User;


/**
 * タスクのバリデーションテスト用のクラス
 * 用途：期限のバリデーションをテストする
 * 
 */



class TaskCreateTest extends TestCase
{
    
    // テストケースごとにデータベースをリフレッシュしてマイグレーションを再実行する
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザ作成
        // $this->user = factory(User::class)->create();
        // factory(User::class) から User::factory() に修正 ララベル８以上の場合
        $this->user = User::factory()->create(); 
        
    }
    
    /**
     * 各テストメソッドの実行前に呼ばれるメソッド
     * 用途：タスクのテストに必要な FoldersTableSeeder を実行する
     * 
     */
    // public function setUp():void
    // {
    //     // 親クラスの抽象クラスにアクセスして自身のsetUp()を実行する
    //     parent::setUp();

    //     // テストケース実行前にフォルダデータを作成（実行）する
    //     $this->seed('FoldersTableSeeder');
    // }

    
    /**
     * タスク作成のテスト
     * 正常な場合 
     * @test
     */

    public function tasks_create_test()
    {
        // テスト用のユーザーを作成する
        // $user = User::factory()->create(['user_id' => 1]);
        $user = User::factory()->create();
        // $response = $this->actingAs($user)->get(route('tasks.create',10));
        // 指定したユーザーとして認証する
        $this->actingAs($user);

        // 第一引数 … アクセスする URL
        // 第二引数 … 入力値
        // タスクを新規作成する -> post(アクセスURL, 入力値);
        $response = $this->post('/folders/10/tasks/create', [


            // タイトルを入力する
            'title' => 'Sample task',
            // 期限日を入力する（不正なデータ（数値））
            'due_date' => Carbon::today()->format('Y/m/d'),
        ]);

        var_dump('title');
        var_dump('due_date');
        var_dump('attribute');

        /* LaravelのphpUnit で TestCase からエラーメッセージを確認するためセッションの中身を確認する（TestCase からはセッションの中身を見ないとエラーメッセージを確認できない） */
        // assertSessionHasErrors()：セッションが指定したエラーバッグの中に、指定した$keysのエラーを持っていることを宣言する
        $response->assertStatus(404);
    
    }
}
