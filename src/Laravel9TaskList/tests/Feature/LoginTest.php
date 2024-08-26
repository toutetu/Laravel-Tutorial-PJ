<?php
//参考サイト： https://qiita.com/nakano-shingo/items/1ab4658e0c8a965de796

namespace Tests\Feature;

// use App\User;
use App\Models\User; // App\User から App\Models\User に修正 ララベル８以上の場合

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class LoginTest extends TestCase
{
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
     * ログイン認証テスト
     */
    public function testLogin(): void
    {   
    
        // 作成したテストユーザのemailとpasswordで認証リクエスト
        $response = $this->json('POST', route('login'), [
            // 'email' => 'test2345@email.com',
            'email' => User->email,

            // 'password' =>'test2345',
            'password' =>'password',
        ]);

        // ver_dump($response);
    
        // 正しいレスポンスが返り、ユーザ名が取得できることを確認
        $response
            ->assertStatus(200);
            // ->assertSeeText("メールアドレス");

            // 指定したユーザーが認証されていることを確認
        $this->assertAuthenticatedAs(User);
    }

    // public function testLogin(): void
    // {   
    //     var_dump( "email:".$this->user->email );
    //     var_dump( "name:".$this->user->name );

    //     // 作成したテストユーザのemailとpasswordで認証リクエスト
    //     $response = $this->json('POST', route('login'), [
    //         'email' => $this->user->email,
    //         'password' => 'password',
    //     ]);
    
    //     // 正しいレスポンスが返り、ユーザ名が取得できることを確認
    //     $response
    //         ->assertStatus(204);
    //         // ->assertSeeText("メールアドレスまたはパスワードに誤りがあります。");
    //     $this->get('/') 
    //         ->assertSeeText("メールアドレス",false);
    //         // ->assertJson(['name' => $this->user->name]);

    //     // 指定したユーザーが認証されていることを確認
    //     $this->assertAuthenticatedAs($this->user);
    // }

    /**
     * ログアウトテスト
     */
    public function testLogout(): void
    {
        // actingAsヘルパで現在認証済みのユーザーを指定する
        $response = $this->actingAs($this->user);

        // ログアウトページへリクエストを送信
        // $response->json('POST', route('logout'));
        $response = $this->post(route('logout'));

        // ログアウト後のレスポンスで、HTTPステータスコードが正常であることを確認
        $response->assertStatus(302)
                ->aget('/logout');


        // ユーザーが認証されていないことを確認
        $this->assertGuest();
    }
}