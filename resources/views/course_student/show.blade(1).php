@extends('format.layout')

@section('title', 'Course-Student Assignment Details')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Assignment Details</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">View course-student enrollment information</p>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;" role="alert">
            <strong>Success!</strong> {{ $message }}
        </div>
    @endif

    <div style="max-width: 700px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15);">
        
        <!-- Course Information -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Course Name</label>
            <p style="padding: 0.75rem; background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 6px; color: #333; font-size: 1.1rem;">{{ $courseStudent->course->name ?? 'N/A' }}</p>
        </div>

        <!-- Course Description -->
        @if($courseStudent->course)
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Course Description</label>
                <p style="padding: 0.75rem; background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 6px; color: #666; line-height: 1.6;">{{ $courseStudent->course->description ?? 'No description available' }}</p>
            </div>
        @endif

        <!-- Student Information -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Student Name</label>
            <p style="padding: 0.75rem; background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 6px; color: #333; font-size: 1.1rem;">{{ $courseStudent->student->fname ?? 'N/A' }} {{ $courseStudent->student->lname ?? '' }}</p>
        </div>

        <!-- Enrollment Date -->
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Enrollment Date</label>
            <p style="padding: 0.75rem; background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 6px; color: #666;">{{ $courseStudent->created_at ? $courseStudent->created_at->format('F d, Y \a\t H:i') : 'N/A' }}</p>
        </div>

        <!-- Assignment ID -->
        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #ec4899; font-weight: 600; margin-bottom: 0.5rem;">Assignment ID</label>
            <p style="padding: 0.75rem; background: #fdf2f8; border-left: 4px solid #ec4899; border-radius: 6px; color: #666; font-family: 'Courier New', monospace;">{{ $courseStudent->id }}</p>
        </div>

        <!-- Action Buttons -->
        <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
            <a href="{{ route('course_students.edit', $courseStudent->id) }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(245, 158, 11, 0.25); text-decoration: none; display: inline-block;" onmouseover="this.style.boxShadow='0 8px 12px rgba(245, 158, 11, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(245, 158, 11, 0.25)';">Edit</a>
            
            <form action="{{ route('course_students.destroy', $courseStudent->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this assignment?');">
                @csrf
                @method('DELETE')
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(239, 68, 68, 0.25);" onmouseover="this.style.boxShadow='0 8px 12px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(239, 68, 68, 0.25)';">Delete</button>
            </form>

            <a href="{{ route('course_students.index') }}" style="padding: 0.75rem 1.5rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease; display: inline-block;" onmouseover="this.style.backgroundColor='#d1d5db';" onmouseout="this.style.backgroundColor='#e5e7eb';">Back</a>
        </div>
    </div>

@endsection
