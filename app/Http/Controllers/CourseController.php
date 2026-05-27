<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::latest()->get();
        
        // Check if request wants JSON (AJAX request)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'courses' => $courses
            ]);
        }
        
        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', 'unique:courses,code'],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'units' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        Course::create([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'units' => $validated['units'],
        ]);

        return redirect()->route('courses.index')->with('success', 'Course created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $course = Course::findOrFail($id);
        
        // Check if request wants JSON (AJAX request)
        if (request()->wantsJson() || request()->ajax()) {
            return response()->json([
                'course' => $course
            ]);
        }
        
        return view('course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $course = Course::findOrFail($id);
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $course = Course::findOrFail($id);

        $validated = $request->validate([
            'code' => ['required', 'string', 'max:20', Rule::unique('courses', 'code')->ignore($course->id)],
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:255'],
            'units' => ['required', 'integer', 'min:1', 'max:6'],
        ]);

        $course->update([
            'code' => $validated['code'],
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'units' => $validated['units'],
        ]);

        // Check if AJAX request
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Course updated successfully.',
                'course' => $course
            ]);
        }

        return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $course = Course::findOrFail($id);
        $course->delete();

        // Check if AJAX request
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Degree deleted successfully.'
            ]);
        }

        return redirect()->route('courses.index')->with('success', 'Course deleted successfully.');
    }
}
