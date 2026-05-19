<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::with(['course', 'user'])->get();
    
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'students' => $students
            ]);
        }
        
      
        return view('students.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = \App\Models\Course::all();
        return view('studentlayout.addstudent', ['courses' => $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'fname' => 'required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'mname' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'lname' => 'required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'username' => 'required|string|min:3|max:255|unique:user_accounts,username',
            'email' => 'required|email|unique:users,email|unique:user_accounts,email',
            'contact' => 'required|digits:11',
            'course_id' => 'required|exists:courses,id',
        ], [
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 2 letters.',
            'fname.regex' => 'First name must contain letters only.',

            'mname.regex' => 'Middle name must contain letters only.',
            
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'lname.regex' => 'Last name must contain letters only.',

            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.unique' => 'Username already exists.',

            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'Email already exists.',

            'contact.required' => 'Contact number is required.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',

            'course_id.required' => 'Course is required.',
            'course_id.exists' => 'Selected course is invalid.',
        ]);
        
        // Create user account with default password
        $user = \App\Models\UserAccount::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make('student1234'),
            'role' => 'student',
            'is_active' => true,
        ]);

        // Create first login token
        \App\Models\FirstLoginToken::create([
            'user_id' => $user->id,
            'used' => false,
        ]);
        
        $student = Student::create([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'contact' => $request->input('contact'),
            'course_id' => $request->input('course_id'),
            'user_id' => $user->id,
        ]);
        
        // Check if AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student added successfully.',
                'student' => $student
            ]);
        }
        
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with(['course', 'user'])->find($id);
        
        if (!$student) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Student not found'], 404);
            }
            return redirect()->route('students.index')->with('error', 'Student not found');
        }
        
        // Check if request wants JSON (AJAX request)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'student' => $student
            ]);
        }
        
        return view('studentlayout.show')->with("students", [$student]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $student = Student::find($id);
        $courses = \App\Models\Course::all();
        return view('studentlayout.edit')->with('student', $student)->with('courses', $courses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'fname' => 'required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'mname' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'lname' => 'required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'contact' => 'required|digits:11',
            'course_id' => 'required|exists:courses,id',
        ], [
            'fname.required' => 'First name is required.',
            'fname.min' => 'First name must be at least 2 letters.',
            'fname.regex' => 'First name must contain letters only.',
            'mname.regex' => 'Middle name must contain letters only.',
            'lname.required' => 'Last name is required.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'lname.regex' => 'Last name must contain letters only.',
            'contact.required' => 'Contact number is required.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',
            'course_id.required' => 'Degree is required.',
            'course_id.exists' => 'Selected degree is invalid.',
        ]);

        $student = Student::find($id);
        
        if (!$student) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Student not found'], 404);
            }
            return redirect()->route('students.index')->with('error', 'Student not found');
        }
        
        $student->update([
            'fname' => $request->input('fname'),
            'mname' => $request->input('mname'),
            'lname' => $request->input('lname'),
            'contact' => $request->input('contact'),
            'course_id' => $request->input('course_id'),
        ]);

        // Check if AJAX request
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student updated successfully.',
                'student' => $student->load(['course', 'user'])
            ]);
        }

        return redirect()->route('students.show', $student->id)->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $student = Student::find($id);
        
        if ($student) {
            // Delete associated user account and first login token
            if ($student->user_id) {
                \App\Models\FirstLoginToken::where('user_id', $student->user_id)->delete();
                \App\Models\UserAccount::where('id', $student->user_id)->delete();
            }
            
            $student->delete();
            
            // Check if AJAX request
            if (request()->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Student deleted successfully.'
                ]);
            }
        }
        
        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
 

