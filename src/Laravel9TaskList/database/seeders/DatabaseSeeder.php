<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // runメソッド内に追加する
        // $this->call(TasksTableSeeder::class);

        // runメソッド内に追加して順番を入れ替える
        $this->call(UsersTableSeeder::class);
        $this->call(FoldersTableSeeder::class);
        $this->call(TasksTableSeeder::class);




    }

}
