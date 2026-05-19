<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\UserAccount;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('user')->latest()->get();
        
        // Check if request wants JSON (AJAX request)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'teachers' => $teachers
            ]);
        }
        
        return view('teacher.index', compact('teachers'));
    }

    public function create()
    {
        return view('teacher.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'mname' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'lname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email', 'max:255', 'unique:teachers,email', 'unique:user_accounts,email'],
            'contact' => ['required', 'digits:11'],
            'username' => ['required', 'string', 'min:3', 'max:255', 'unique:user_accounts,username'],
        ], [
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 2 letters.',
            'fname.regex' => 'First name must contain letters only.',
            'mname.regex' => 'Middle name must contain letters only.',
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'lname.regex' => 'Last name must contain letters only.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'Email already exists.',
            'contact.required' => 'Contact number is required.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.unique' => 'Username already exists.',
        ]);

        // Create user account
        $user = UserAccount::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => \Hash::make('teacher1234'),
            'role' => 'teacher',
            'is_active' => true,
        ]);

        // Create first login token
        \App\Models\FirstLoginToken::create([
            'user_id' => $user->id,
            'used' => false,
        ]);

        // Create teacher record
        Teacher::create([
            'fname' => $validated['fname'],
            'mname' => $validated['mname'],
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'contact' => $validated['contact'],
            'user_id' => $user->id,
        ]);

        return redirect()->route('teachers.index')->with('success', 'Teacher created successfully.');
    }

    public function show(string $id)
    {
        $teacher = Teacher::with('user')->findOrFail($id);
        
        // Check if request wants JSON (AJAX request)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'teacher' => $teacher
            ]);
        }
        
        return view('teacher.show', compact('teacher'));
    }

    public function edit(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('teacher.edit', compact('teacher'));
    }

    public function update(Request $request, string $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validated = $request->validate([
            'fname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'mname' => ['nullable', 'string', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'lname' => ['required', 'string', 'min:2', 'max:255', 'regex:/^[A-Za-z\s]+$/'],
            'email' => ['required', 'email', 'max:255', Rule::unique('teachers', 'email')->ignore($teacher->id)],
            'contact' => ['required', 'digits:11'],
        ], [
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 2 letters.',
            'fname.regex' => 'First name must contain letters only.',
            'mname.regex' => 'Middle name must contain letters only.',
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'lname.regex' => 'Last name must contain letters only.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'Email already exists.',
            'contact.required' => 'Contact number is required.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',
        ]);

        $teacher->update($validated);

        // Update user account email if changed
        if ($teacher->user && $teacher->user->email !== $validated['email']) {
            $teacher->user->update(['email' => $validated['email']]);
        }

        // Check if AJAX request
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Teacher updated successfully.',
                'teacher' => $teacher->load('user')
            ]);
        }

        return redirect()->route('teachers.show', $teacher->id)->with('success', 'Teacher updated successfully.');
    }

    public function destroy(string $id)
    {
        $teacher = Teacher::findOrFail($id);
        
        // Delete associated user account (will cascade delete teacher due to foreign key)
        if ($teacher->user) {
            $teacher->user->delete();
        } else {
            $teacher->delete();
        }

        // Check if AJAX request
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Teacher deleted successfully.'
            ]);
        }

        return redirect()->route('teachers.index')->with('success', 'Teacher deleted successfully.');
    }
}
