<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
        /**
     * ステータスコードのテスト
     * 200 成功
     * 300 リダイレクト
     * 400 クライアントエラー
     * 500 サーバーエラー
     *
     * @return void
     */
    
    public function test_the_application_returns_a_successful_response()
    {
        $response = $this->get('/');

        // $response->assertStatus(302);
        $response->assertStatus(302)->assertRedirect(route('login'));
    }
    public function test_the_application_returns_login()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

}
