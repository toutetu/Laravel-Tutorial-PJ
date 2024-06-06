<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TasksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * tasksTable用テストデータ
     *
     * @return void
     */
    public function run()
    {
        // ID = 1 のフォルダに対して3つのタスクを登録（挿入）する
        foreach (range(1, 3) as $num) {
            // tasksテーブルにアクセスして行を挿入する
            DB::table('tasks')->insert([
                // folder_idに 1 を代入する
                'folder_id' => 1,
                // titleに "サンプルタスク {$num}" を代入する
                'title' => "サンプルタスク {$num}",
                // status に $num を代入する
                'status' => $num,
                // 期限日に 現在日時 + addDay($num) の期日を設定して代入する
                // addDay()：日単位での加算減算をする関数
                'due_date' => Carbon::now()->addDay($num),
                // 現在の日時を取得してcreated_atに作成日として代入する
                'created_at' => Carbon::now(),
                // 現在の日時を取得してupdated_atに更新日として代入する
                'updated_at' => Carbon::now(),
            ]);
        }
    }
}