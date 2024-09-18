<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Schema;

class CustomMigrateFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:custom-fresh {--seed : Seed the database after migration}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh the database and run all database migrations, excluding specific tables';
    
    

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
            // 保持したいテーブルのリスト
            $excludedTables = ['activity_log'];
            
            // 除外テーブル以外のすべてのテーブルを削除
            $tables = Schema::getConnection()->getDoctrineSchemaManager()->listTableNames();
            foreach ($tables as $table) {
                if (!in_array($table, $excludedTables)) {
                    Schema::drop($table);
                }
            }

            Schema::disableForeignKeyConstraints();

            // テーブルの削除処理
        
            Schema::enableForeignKeyConstraints();

            // マイグレーションを実行
            $this->call('migrate');
            
            // シーディングを実行（オプション）
            if ($this->option('seed')) {
                $this->call('db:seed');
            }
            Schema::table('child_table', function (Blueprint $table) {
                $table->dropForeign(['folder_id']);
            });
            
            // folders テーブルの削除
            
            // マイグレーションで外部キー制約を再作成
            $this->info('Custom fresh migration completed successfully.');
    }
}
