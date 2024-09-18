<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RecordActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next): Response
    {
        $description = "ユーザーが" . 
                        $request->method() . 
                        "メソッドで" . $request->fullUrl() . 
                        "にアクセスしました";
        activity()
            ->causedBy(Auth::user())
            ->withProperties([
                'url' => $request->fullUrl(),
                'method' => $request->method(),
                'ip' => $request->ip(),
                'agent' => $request->userAgent(),
            ])
            ->log($description);

        return $next($request);

        
    }
}
