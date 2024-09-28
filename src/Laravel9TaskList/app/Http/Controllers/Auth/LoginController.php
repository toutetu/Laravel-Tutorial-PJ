<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\Providers\RouteServiceProvider; // 追加
use Illuminate\Http\Request;

//ログを記録する
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
// use Spatie\Activitylog\Facades\Activity;
use Spatie\Activitylog\Models\Activity;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    
    //ログをとる
    //use LogsActivity;
    
    // public function getActivitylogOptions(): LogOptions
    // {
    //     Activity::all();
    //     return LogOptions::defaults()
    //         ->logOnly([
    //             'title', 
    //             'description',
    //             'due_date', 
    //             'status'])
    //         ->setDescriptionForEvent(function(string $eventName) {
    //                 $translatedEvent = $eventTranslations[$eventName] ?? $eventName;
    //                 return "ログインしました";
    //             });
    // }
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = '/home';
    protected $redirectTo = RouteServiceProvider::HOME;



    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }
    protected function authenticated(Request $request, $user)
    {
        activity()
        ->withProperties(['log_name' => 'ログイン'])
        ->tap(function(Activity $activity) {
            $activity->log_name = 'ログイン';
         })
        ->log("ユーザー {$user->name} がログインしました")
        ;
    }

    protected function loggedOut(Request $request)
    {
        activity()
        ->withProperties(['log_name' => 'ログイン'])
        ->tap(function(Activity $activity) {
            $activity->log_name = 'ログイン';
         })
        ->log("ユーザー がログアウトしました")
        ;
    }

    
}
