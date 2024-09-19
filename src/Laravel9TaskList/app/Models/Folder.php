<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

//ログを記録する
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\LogsActivityInterface;　不要かも？


class Folder extends Model
{
    use HasFactory;

    //ログを記録する
    //at the top of your file you should import the facade.
    use LogsActivity    ;


    // テーブル名を明示的に指定する
    protected $table = 'folders';

    /*
    * フォルダクラスとタスククラスを関連付けするメソッド
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function tasks()
    {
        /* フォルダクラスのタスククラスのリストを取得して返す */
        // hasMany()：テーブルの関係性を辿ってインスタンスから紐づく情報を取得する関数
        // hasMany(モデル名, 関連するテーブルが持つ外部キーカラム名, hasManyが定義された外部キーに紐づけられたカラム)
        return $this->hasMany('App\Models\Task');
    }

        //モデルでの自動記録:TaskモデルにLogsActivityトレイトを使用して、モデルイベントを自動的に記録
        public function getActivitylogOptions(): LogOptions
        {
            return LogOptions::defaults()
                ->logOnly(['title', 'description', 'due_date', 'status'])
                // ->setDescriptionForEvent(fn(string $eventName) => "フォルダーが{$eventName}されました");
                ->setDescriptionForEvent(function(string $eventName) {
                    $eventTranslations = [
                        'created' => '作成',
                        'updated' => '更新',
                        'deleted' => '削除',
                        // 他のイベントに応じて追加
                    ];
                    $translatedEvent = $eventTranslations[$eventName] ?? $eventName;
                    return "フォルダーが{$translatedEvent}されました";
                });
            }
}
