<?php

namespace App\Http\Controllers;

use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class PasswordController extends Controller
{
    public function showChangeForm()
    {
        return view('user.password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'old_password'          => ['required', 'string'],
            'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'old_password.required'         => 'Old password is required.',
            'new_password.required'         => 'New password is required.',
            'new_password.min'              => 'New password must be at least 8 characters.',
            'new_password.confirmed'        => 'New passwords do not match.',
        ]);

        $user = UserAccount::findOrFail(Session::get('user_id'));

        if (!Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'The old password is incorrect.']);
        }

        if ($request->old_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'New password must be different from the old password.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Mark first login token as used
        $user->firstLoginToken()->update([
            'used' => true,
            'used_at' => now(),
        ]);

        // Refresh session user data
        Session::put('user', $user->fresh());

        // Redirect to dashboard based on role
        return redirect()->route('dashboard')->with('success', 'Password changed successfully! Welcome to your dashboard.');
    }

    public function studentPasswordUpdate(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', 'string'],
            'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required'     => 'Current password is required.',
            'new_password.required'         => 'New password is required.',
            'new_password.min'              => 'New password must be at least 8 characters.',
            'new_password.confirmed'        => 'New passwords do not match.',
        ]);

        $user = UserAccount::findOrFail(Session::get('user_id'));

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'New password must be different from the current password.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Refresh session user data
        Session::put('user', $user->fresh());

        return back()->with('success', 'Password changed successfully!');
    }

    public function teacherPasswordUpdate(Request $request)
    {
        $request->validate([
            'current_password'      => ['required', 'string'],
            'new_password'          => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required'     => 'Current password is required.',
            'new_password.required'         => 'New password is required.',
            'new_password.min'              => 'New password must be at least 8 characters.',
            'new_password.confirmed'        => 'New passwords do not match.',
        ]);

        $user = UserAccount::findOrFail(Session::get('user_id'));

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        if ($request->current_password === $request->new_password) {
            return back()->withErrors(['new_password' => 'New password must be different from the current password.']);
        }

        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        // Refresh session user data
        Session::put('user', $user->fresh());

        return back()->with('success', 'Password changed successfully!');
    }
}
