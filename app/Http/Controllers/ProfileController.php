<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $profiles = Profile::with('user')->latest()->paginate(10);

        return view('profile.index', compact('profiles'));
    }

    public function create()
    {
        $usedUserIds = Profile::pluck('user_id');
        $users = User::whereNotIn('id', $usedUserIds)->orderBy('name')->get();

        return view('profile.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id', 'unique:profiles,user_id'],
            'bio' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
        ]);

        Profile::create($validated);

        return redirect()->route('profiles.index')->with('success', 'Profile created successfully.');
    }

    public function show(string $id)
    {
        $profile = Profile::with('user')->findOrFail($id);

        return view('profile.show', compact('profile'));
    }

    public function edit(string $id)
    {
        $profile = Profile::findOrFail($id);
        $usedUserIds = Profile::where('id', '!=', $profile->id)->pluck('user_id');
        $users = User::whereNotIn('id', $usedUserIds)->orderBy('name')->get();

        return view('profile.edit', compact('profile', 'users'));
    }

    public function update(Request $request, string $id)
    {
        $profile = Profile::findOrFail($id);

        $validated = $request->validate([
            'user_id' => [
                'required',
                'exists:users,id',
                Rule::unique('profiles', 'user_id')->ignore($profile->id),
            ],
            'bio' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url', 'max:255'],
        ]);

        $profile->update($validated);

        return redirect()->route('profiles.show', $profile->id)->with('success', 'Profile updated successfully.');
    }

    public function destroy(string $id)
    {
        $profile = Profile::findOrFail($id);
        $profile->delete();

        return redirect()->route('profiles.index')->with('success', 'Profile deleted successfully.');
    }
}
