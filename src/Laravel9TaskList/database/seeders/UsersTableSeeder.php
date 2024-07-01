<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * usersTable用テストデータ
     * 
     * @return void
     */
    public function run()
    {
        // usersテーブルにアクセスして行を挿入する
        DB::table('users')->insert([
            // nameに test を代入する
            'name' => 'test',
            // emailに dummy@email.com を代入する
            'email' => 'dummy@email.com',
            // passwordに test1234 を代入する
            // bcrypt()：パスワードをハッシュ化する関数
            'password' => bcrypt('test1234'),
            // 現在の日時を取得してcreated_atに作成日として代入する
            'created_at' => Carbon::now(),
            // 現在の日時を取得してupdated_atに更新日として代入する
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'test2',
            'email' => 'test2345@email.com',
            'password' => bcrypt('test2345'),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        $user = DB::table('users')->skip(1)->first();

        $titles = ['サンプルフォルダ01（test2）', 'サンプルフォルダ02（test2）', 'サンプルフォルダ03（test2）'];
    
        foreach ($titles as $title) {
            DB::table('folders')->insert([
                'title' => $title,
                'user_id' => $user->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }


        $user = DB::table('users')->where('id', 2)->first();
        $folder = DB::table('folders')->where('user_id', $user->id)->first();

        foreach (range(1, 3) as $num) {
            DB::table('tasks')->insert([
                'folder_id' => $folder->id,
                'title' => "サンプルタスク {$num}（test2）",
                'status' => $num,
                'due_date' => Carbon::now()->addDay($num),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}