<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

//ページネーションのuse宣言
use Illuminate\Pagination\Paginator;

// Authクラスをインポートする
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    public function showLog()
    {
        $activities = Activity::orderBy('created_at', 'desc')->paginate(10);
        return view('logs.log', compact('activities'));
    }
}