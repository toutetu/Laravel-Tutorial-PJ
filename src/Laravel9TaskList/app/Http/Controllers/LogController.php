<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

// Authクラスをインポートする
use Illuminate\Support\Facades\Auth;

class LogController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    public function showWorkLog()
    {
        // try {
            // /** @var App\Models\User **/
            $user = Auth::user();
            $path = storage_path('logs/work.log');

            if (!File::exists($path)) {
                return response()->json(['message' => 'Log file not found'], 404);
            }

            $log = File::get($path);

            return view('logs.show', ['log' => $log]);
        // }catch (\Throwable $e) {
        //     Log::error('Error LogController in showWorkLog: ' . $e->getMessage());
        // }
    }
}
