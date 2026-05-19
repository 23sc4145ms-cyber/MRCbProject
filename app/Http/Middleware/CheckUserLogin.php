<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('user_account_id')) {
            return redirect()->route('login')->withErrors(['login' => 'Please login first.']);
        }

        return $next($request);
    }
}
