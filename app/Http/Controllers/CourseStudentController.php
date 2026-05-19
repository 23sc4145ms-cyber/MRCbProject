<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Course_Student;
use App\Models\Student;
use Illuminate\Http\Request;

class CourseStudentController extends Controller
{
    public function index()
    {
        $courseStudents = Course_Student::with(['course', 'student'])->latest()->paginate(10);
        return view('course_student.index', compact('courseStudents'));
    }

    public function create()
    {
        $courses = Course::orderBy('name')->get();
        $students = Student::orderBy('fname')->get();
        return view('course_student.create', compact('courses', 'students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        Course_Student::create($validated);

        return redirect()->route('course_students.index')->with('success', 'Course student assignment created successfully.');
    }

    public function show(string $id)
    {
        $courseStudent = Course_Student::with(['course', 'student'])->findOrFail($id);
        return view('course_student.show', compact('courseStudent'));
    }

    public function edit(string $id)
    {
        $courseStudent = Course_Student::findOrFail($id);
        $courses = Course::orderBy('name')->get();
        $students = Student::orderBy('fname')->get();
        return view('course_student.edit', compact('courseStudent', 'courses', 'students'));
    }

    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'course_id' => ['required', 'exists:courses,id'],
            'student_id' => ['required', 'exists:students,id'],
        ]);

        $courseStudent = Course_Student::findOrFail($id);
        $courseStudent->update($validated);

        return redirect()->route('course_students.index')->with('success', 'Course student assignment updated successfully.');
    }

    public function destroy(string $id)
    {
        $courseStudent = Course_Student::findOrFail($id);
        $courseStudent->delete();

        return redirect()->route('course_students.index')->with('success', 'Course student assignment deleted successfully.');
    }
}
