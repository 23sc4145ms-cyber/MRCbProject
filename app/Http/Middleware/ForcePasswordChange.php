<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\UserAccount;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Session::has('user_id')) {
            $user = UserAccount::find(Session::get('user_id'));

            if ($user) {
                // If STUDENT or TEACHER needs to change password, only allow password change routes
                if (($user->role === 'student' || $user->role === 'teacher') && $user->needsPasswordChange()) {
                    if (!$request->routeIs('password.change.form', 'password.change.update', 'logout')) {
                        return redirect()->route('password.change.form')
                            ->with('info', 'You must change your default password before continuing.');
                    }
                }
                // Allow students to access their dashboard
                elseif ($user->role === 'student') {
                    $allowedRoutes = [
                        'dashboard', 
                        'password.change.form', 
                        'password.change.update',
                        'student.password.update',
                        'logout',
                        'posts.index',
                        'posts.show',
                        'profiles.index',
                        'profiles.show'
                    ];
                    
                    if (!$request->routeIs($allowedRoutes)) {
                        return redirect()->route('dashboard')
                            ->with('info', 'You do not have access to this page.');
                    }
                }
                // Admin has full access (no restrictions, no forced password change)
                // Teachers have full access after changing password
            }
        }

        return $next($request);
    }
}
