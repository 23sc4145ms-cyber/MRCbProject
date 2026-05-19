# AJAX Implementation sa Controllers

## Overview
Ang jQuery/AJAX ay naka-implement sa **Controllers** by checking kung AJAX request ba, then returning JSON instead of views.

---

## 1. StudentController.php
**Location:** `app/Http/Controllers/StudentController.php`

### index() - Line ~18-28
```php
public function index()
{
    $students = Student::with(['course', 'user'])->get();
    
    // Check if request wants JSON (AJAX request)
    if (request()->wantsJson() || request()->ajax()) {
        return response()->json([
            'students' => $students
        ]);
    }
    
    // Return view for normal requests
    return view('students.index', compact('students'));
}
```
**Purpose:** Returns all students as JSON for AJAX, or view for normal page load

---

### show($id) - Line ~120-137
```php
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
```
**Purpose:** Returns single student details as JSON for View modal

---

### update($id) - Line ~170-190
```php
public function update(Request $request, string $id)
{
    // ... validation code ...
    
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
```
**Purpose:** Returns success JSON for Edit modal

---

### destroy($id) - Line ~200-220
```php
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
```
**Purpose:** Returns success JSON for Delete confirmation

---

## 2. TeacherController.php
**Location:** `app/Http/Controllers/TeacherController.php`

### index() - Line ~13-24
```php
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
```
**Purpose:** Returns all teachers as JSON for AJAX

---

### show($id) - Line ~88-98
```php
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
```
**Purpose:** Returns single teacher details as JSON for View modal

---

### update($id) - Line ~120-148
```php
public function update(Request $request, string $id)
{
    // ... validation code ...
    
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
```
**Purpose:** Returns success JSON for Edit modal

---

### destroy($id) - Line ~150-168
```php
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
```
**Purpose:** Returns success JSON for Delete confirmation

---

## 3. CourseController.php (Degrees)
**Location:** `app/Http/Controllers/CourseController.php`

### index() - Line ~14-24
```php
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
```
**Purpose:** Returns all degrees as JSON for AJAX

---

### show($id) - Line ~55-65
```php
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
```
**Purpose:** Returns single degree details as JSON for View modal

---

### update($id) - Line ~78-96
```php
public function update(Request $request, string $id)
{
    $validated = $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
    ]);

    $course = Course::findOrFail($id);
    $course->update($validated);

    // Check if AJAX request
    if (request()->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Degree updated successfully.',
            'course' => $course
        ]);
    }

    return redirect()->route('courses.index')->with('success', 'Course updated successfully.');
}
```
**Purpose:** Returns success JSON for Edit modal

---

### destroy($id) - Line ~103-117
```php
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
```
**Purpose:** Returns success JSON for Delete confirmation

---

## How It Works

### Pattern Used:
```php
// Check if AJAX request
if (request()->wantsJson() || request()->ajax()) {
    // Return JSON for AJAX
    return response()->json([
        'success' => true,
        'data' => $data
    ]);
}

// Return view for normal page load
return view('...');
```

### Key Methods:
1. **`request()->ajax()`** - Checks if request is AJAX
2. **`request()->wantsJson()`** - Checks if request expects JSON response
3. **`response()->json([])`** - Returns JSON response

### AJAX Operations:
- **READ (index)** - Returns array of records
- **VIEW (show)** - Returns single record
- **UPDATE** - Returns success message + updated record
- **DELETE** - Returns success message

---

## JavaScript Files (jQuery/AJAX)
Ang actual AJAX calls ay nasa:
- `public/js/students.js` - Students CRUD
- `public/js/teachers.js` - Teachers CRUD
- `public/js/degrees.js` - Degrees CRUD

These files call the controller methods using:
- `$.get()` - for READ/VIEW
- `$.ajax()` with `type: "PUT"` - for UPDATE
- `$.ajax()` with `type: "DELETE"` - for DELETE

---

## Summary
✅ **Controllers** - Check if AJAX, return JSON or View  
✅ **JavaScript files** - Make AJAX calls to controllers  
✅ **Blade files** - Include modals and load JS files  
✅ **No page reload** - All operations via AJAX  
