@extends('format.layout')

@section('title', 'Course Details')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Course Details</h1>
        <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">View course information</p>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;" role="alert">
            <strong>Success!</strong> {{ $message }}
        </div>
    @endif

    <div style="max-width: 800px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);">
        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Course Code</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #333; font-size: 1.1rem;">{{ $course->code ?? 'N/A' }}</p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Course Name</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #333; line-height: 1.6; white-space: pre-wrap;">{{ $course->name }}</p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Units</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #666; line-height: 1.6;">{{ $course->units ?? 'N/A' }}</p>
        </div>

        <div style="margin-bottom: 1.5rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Created Date</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #666;">{{ $course->created_at ? $course->created_at->format('F d, Y \a\t H:i') : 'N/A' }}</p>
        </div>

        <div style="margin-bottom: 2rem;">
            <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Last Updated</label>
            <p style="padding: 0.75rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 6px; color: #666;">{{ $course->updated_at ? $course->updated_at->format('F d, Y \a\t H:i') : 'N/A' }}</p>
        </div>

        <div class="action-group" style="justify-content: flex-start;">
            <a href="{{ route('courses.edit', $course->id) }}" class="action-btn action-btn-edit">Edit</a>
            <form action="{{ route('courses.destroy', $course->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn action-btn-delete">Delete</button>
            </form>
            <a href="{{ route('courses.index') }}" class="action-btn action-btn-back">Back</a>
        </div>
    </div>

@endsection
