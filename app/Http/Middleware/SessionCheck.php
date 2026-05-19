<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SessionCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Allow access to login and home routes without session
        if ($request->routeIs('login', 'login.submit')) {
            return $next($request);
        }

        // Check if user is logged in
        if (!Session::has('user_id')) {
            return redirect()->route('login')->with('error', 'You must log in first.');
        }

        // Check if session is still valid (user exists in session)
        if (!Session::has('user')) {
            Session::flush();
            return redirect()->route('login')->with('error', 'Your session has expired. Please log in again.');
        }

        return $next($request);
    }
}
