<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;
namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class AuthTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */

     public function  test_an_action_that_requires_authentication()
     {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
                        //  ->withSession(['banned' => false])
                         ->get('/');
        $response->assertStatus(200);
    }

    use RefreshDatabase;



    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        // テストユーザーを作成
        $this->user = User::factory()->create([
            'password' => bcrypt($password = 'password123')
        ]);

        // パスワードを保持
        $this->password = $password;
    }

    /**
     * ログイン認証テスト
     */
    public function testLogin(): void
    {
        // 作成したテストユーザーのemailとpasswordで認証リクエスト
        $response = $this->json('POST', route('login'), [
            'email' => $this->user->email,
            'password' => $this->password,
        ]);

        // 正しいレスポンスが返り、ユーザーが認証されていることを確認
        $response->assertStatus(204);

        // 指定したユーザーが認証されていることを確認
        $this->assertAuthenticatedAs($this->user);
    }

    /**
     * ログアウトテスト
     */
    public function testLogout(): void
    {
        // actingAsヘルパで現在認証済みのユーザーを指定する
        $response = $this->actingAs($this->user);

        // ログアウトページへリクエストを送信
        $response = $this->post(route('logout'));

        // ログアウト後のレスポンスで、HTTPステータスコードが正常であることを確認
        $response->assertStatus(302);

        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }
}
