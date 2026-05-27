<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Show the login form
     */
    public function showLogin()
    {
        if (Session::has('user_id')) {
            return redirect()->route('dashboard');
        }
        
        // Prevent caching of login page
        return response()
            ->view('auth.login')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Handle login submission
     */
    public function submitLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
        ]);

        // Find user by email nila
        $user = UserAccount::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }
        //okay na

        Session::put('user_id', $user->id);
        Session::put('user', $user);
        Session::put('user_email', $user->email);
        Session::put('user_role', $user->role);

        // First-time login: force password change (students and teachers)
        if (($user->role === 'student' || $user->role === 'teacher') && $user->needsPasswordChange()) {
            return redirect()->route('password.change.form')->with('info', 'Please change your default password before continuing.');
        }

        return redirect()->route('dashboard')->with('success', 'Welcome ' . $user->username . '!');
    }

    /**
     * Handle logout
     */
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }
}
