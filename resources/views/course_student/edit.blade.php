@extends('format.layout')

@section('title', 'Edit Course-Student Assignment')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Edit Assignment</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Modify course-student enrollment</p>
    </div>

    @if ($errors->any())
        <div style="padding: 1rem; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #991b1b; margin-bottom: 1.5rem;">
            <strong>Validation Errors:</strong>
            <ul style="margin: 0.5rem 0 0 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="max-width: 600px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15);">
        <form action="{{ route('course_students.update', $courseStudent->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Course Selection -->
            <div style="margin-bottom: 1.5rem;">
                <label for="course_id" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Course <span style="color: #ef4444;">*</span></label>
                <select name="course_id" id="course_id" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem; background-color: #f9fafb; color: #333; transition: border-color 0.2s ease;" onchange="this.style.borderColor='#ec4899';" onfocus="this.style.borderColor='#ec4899';" onblur="this.style.borderColor='#e5e7eb';" required>
                    <option value="">-- Select a Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" @selected(old('course_id', $courseStudent->course_id) == $course->id)>
                            {{ $course->name }}
                        </option>
                    @endforeach
                </select>
                @error('course_id')
                    <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Student Selection -->
            <div style="margin-bottom: 2rem;">
                <label for="student_id" style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Student <span style="color: #ef4444;">*</span></label>
                <select name="student_id" id="student_id" style="width: 100%; padding: 0.75rem; border: 2px solid #e5e7eb; border-radius: 6px; font-size: 1rem; background-color: #f9fafb; color: #333; transition: border-color 0.2s ease;" onchange="this.style.borderColor='#ec4899';" onfocus="this.style.borderColor='#ec4899';" onblur="this.style.borderColor='#e5e7eb';" required>
                    <option value="">-- Select a Student --</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}" @selected(old('student_id', $courseStudent->student_id) == $student->id)>
                            {{ $student->fname }} {{ $student->lname }}
                        </option>
                    @endforeach
                </select>
                @error('student_id')
                    <p style="color: #ef4444; font-size: 0.875rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.25);" onmouseover="this.style.boxShadow='0 8px 12px rgba(245, 158, 11, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(245, 158, 11, 0.25)';">Update Assignment</button>
                <a href="{{ route('course_students.index') }}" style="padding: 0.75rem 1.5rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease; display: inline-block;" onmouseover="this.style.backgroundColor='#d1d5db';" onmouseout="this.style.backgroundColor='#e5e7eb';">Cancel</a>
            </div>
        </form>
    </div>
@endsection
