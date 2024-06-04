<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller
{
     // index メソッドを追加する
     public function index($id)  // $idを受け取るように変更
    {
        return "Hello world";
    }
}
