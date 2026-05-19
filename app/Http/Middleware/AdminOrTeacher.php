<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminOrTeacher
{
    public function handle(Request $request, Closure $next): Response
    {
        if (session('user_role') === 'admin' || session('user_role') === 'teacher') {
            return $next($request);
        }
        
        return redirect()->route('dashboard')->with('error', 'Access denied.');
    }
}
