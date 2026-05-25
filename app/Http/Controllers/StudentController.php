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
        $students = Student::with(['degree', 'user'])->get();
    
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'students' => $students
            ]);
        }
        
        return view('students.index', compact('students'));
    }

    /**aaaaaa
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $degrees = \App\Models\Degree::all();
        $courses = \App\Models\Course::all();
        return view('studentlayout.addstudent', ['degrees' => $degrees, 'courses' => $courses]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Accept both old and new field names
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'fname' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'mname' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'last_name' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'lname' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'username' => 'required|string|min:3|max:255|unique:user_accounts,username',
            'email' => 'required|email|unique:users,email|unique:user_accounts,email',
            'contact_no' => 'sometimes|required|digits:11',
            'contact' => 'sometimes|required|digits:11',
            'degree_id' => 'sometimes|required|exists:courses,id',
            'course_id' => 'sometimes|required|exists:courses,id',
            'password' => 'nullable|string|min:6',
        ], [
            'first_name.required' => 'First name is required.',
            'fname.required' => 'First name is required.',
            'first_name.min' => 'First name must be at least 2 letters.',
            'fname.min' => 'First name must be at least 2 letters.',
            'first_name.regex' => 'First name must contain letters only.',
            'fname.regex' => 'First name must contain letters only.',
            'middle_name.regex' => 'Middle name must contain letters only.',
            'mname.regex' => 'Middle name must contain letters only.',
            'last_name.required' => 'Last name is required.',
            'lname.required' => 'Last name is required.',
            'last_name.min' => 'Last name must be at least 2 letters.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'last_name.regex' => 'Last name must contain letters only.',
            'lname.regex' => 'Last name must contain letters only.',
            'username.required' => 'Username is required.',
            'username.min' => 'Username must be at least 3 characters.',
            'username.unique' => 'Username already exists.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email.',
            'email.unique' => 'Email already exists.',
            'contact_no.required' => 'Contact number is required.',
            'contact.required' => 'Contact number is required.',
            'contact_no.digits' => 'Contact number must be exactly 11 digits.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',
            'degree_id.required' => 'Degree is required.',
            'course_id.required' => 'Degree is required.',
            'degree_id.exists' => 'Selected degree is invalid.',
            'course_id.exists' => 'Selected degree is invalid.',
        ]);
        
        // Map field names to database columns
        $fname = $validated['first_name'] ?? $validated['fname'];
        $mname = $validated['middle_name'] ?? $validated['mname'] ?? null;
        $lname = $validated['last_name'] ?? $validated['lname'];
        $contact = $validated['contact_no'] ?? $validated['contact'];
        $course_id = $validated['degree_id'] ?? $validated['course_id'];
        $password = $validated['password'] ?? 'student1234';
        
        // Create user account
        $user = \App\Models\UserAccount::create([
            'username' => $validated['username'],
            'email' => $validated['email'],
            'password' => Hash::make($password),
            'role' => 'student',
            'is_active' => true,
        ]);

        // Create first login token
        \App\Models\FirstLoginToken::create([
            'user_id' => $user->id,
            'used' => false,
        ]);
        
        $student = Student::create([
            'fname' => $fname,
            'mname' => $mname,
            'lname' => $lname,
            'contact' => $contact,
            'course_id' => $course_id,
            'user_id' => $user->id,
        ]);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student added successfully.',
                'student' => $student->load(['degree', 'user'])
            ]);
        }
        
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $student = Student::with(['degree', 'user'])->find($id);
        
        if (!$student) {
            if (request()->ajax()) {
                return response()->json(['error' => 'Student not found'], 404);
            }
            return redirect()->route('students.index')->with('error', 'Student not found');
        }
        
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
        $degrees = \App\Models\Degree::all();
        $courses = \App\Models\Course::all();
        return view('studentlayout.edit')
            ->with('student', $student)
            ->with('degrees', $degrees)
            ->with('courses', $courses);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Accept both old and new field names - NO username/email validation for updates
        $validated = $request->validate([
            'first_name' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'fname' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'middle_name' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'mname' => 'nullable|string|max:255|regex:/^[A-Za-z\s]+$/',
            'last_name' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'lname' => 'sometimes|required|string|min:2|max:255|regex:/^[A-Za-z\s]+$/',
            'contact_no' => 'sometimes|required|digits:11',
            'contact' => 'sometimes|required|digits:11',
            'degree_id' => 'sometimes|required|exists:courses,id',
            'course_id' => 'sometimes|required|exists:courses,id',
        ], [
            'first_name.required' => 'First name is required.',
            'fname.required' => 'First name is required.',
            'first_name.min' => 'First name must be at least 2 letters.',
            'fname.min' => 'First name must be at least 2 letters.',
            'first_name.regex' => 'First name must contain letters only.',
            'fname.regex' => 'First name must contain letters only.',
            'middle_name.regex' => 'Middle name must contain letters only.',
            'mname.regex' => 'Middle name must contain letters only.',
            'last_name.required' => 'Last name is required.',
            'lname.required' => 'Last name is required.',
            'last_name.min' => 'Last name must be at least 2 letters.',
            'lname.min' => 'Last name must be at least 2 letters.',
            'last_name.regex' => 'Last name must contain letters only.',
            'lname.regex' => 'Last name must contain letters only.',
            'contact_no.required' => 'Contact number is required.',
            'contact.required' => 'Contact number is required.',
            'contact_no.digits' => 'Contact number must be exactly 11 digits.',
            'contact.digits' => 'Contact number must be exactly 11 digits.',
            'degree_id.required' => 'Degree is required.',
            'course_id.required' => 'Degree is required.',
            'degree_id.exists' => 'Selected degree is invalid.',
            'course_id.exists' => 'Selected degree is invalid.',
        ]);

        $student = Student::find($id);
        
        if (!$student) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Student not found'], 404);
            }
            return redirect()->route('students.index')->with('error', 'Student not found');
        }
        
        // Map new field names to old database column names
        $updateData = [];
        
        if (isset($validated['first_name']) || isset($validated['fname'])) {
            $updateData['fname'] = $validated['first_name'] ?? $validated['fname'];
        }
        
        if (isset($validated['middle_name']) || isset($validated['mname'])) {
            $updateData['mname'] = $validated['middle_name'] ?? $validated['mname'];
        }
        
        if (isset($validated['last_name']) || isset($validated['lname'])) {
            $updateData['lname'] = $validated['last_name'] ?? $validated['lname'];
        }
        
        if (isset($validated['contact_no']) || isset($validated['contact'])) {
            $updateData['contact'] = $validated['contact_no'] ?? $validated['contact'];
        }
        
        if (isset($validated['degree_id']) || isset($validated['course_id'])) {
            $updateData['course_id'] = $validated['degree_id'] ?? $validated['course_id'];
        }
        
        $student->update($updateData);

        // Sync courses (many-to-many relationship)
        if ($request->has('courses')) {
            $student->courses()->sync($request->courses);
        }

        $msg = "Student updated successfully!";

        
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => $msg,
                'student' => $student->load(['degree', 'user'])
            ]);
        }

        return redirect()->route('students.index')->with('success', $msg);
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


