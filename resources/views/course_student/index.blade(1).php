@extends('format.layout')

@section('title', 'Course-Student Assignments')

@section('content')
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: #ec4899; font-size: 2.5rem; font-weight: 700; margin: 0;">Course-Student Assignments</h1>
            <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Manage course enrollments</p>
        </div>
        <a href="{{ route('course_students.create') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(16, 185, 129, 0.25); text-decoration: none; display: inline-block;" onmouseover="this.style.boxShadow='0 8px 12px rgba(16, 185, 129, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(16, 185, 129, 0.25)';">+ New Assignment</a>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;" role="alert">
            <strong>Success!</strong> {{ $message }}
        </div>
    @endif

    <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3e8ff; border-bottom: 2px solid #ec4899;">
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">#</th>
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">Course</th>
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">Student</th>
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">Enrollment Date</th>
                    <th style="padding: 1rem; text-align: center; color: #ec4899; font-weight: 600;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courseStudents as $courseStudent)
                    <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='#fdf2f8';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 1rem; color: #333;">{{ $loop->iteration }}</td>
                        <td style="padding: 1rem; color: #333;">
                            <span style="font-weight: 600;">{{ $courseStudent->course->name ?? 'N/A' }}</span>
                        </td>
                        <td style="padding: 1rem; color: #333;">
                            {{ $courseStudent->student->fname ?? 'N/A' }} {{ $courseStudent->student->lname ?? '' }}
                        </td>
                        <td style="padding: 1rem; color: #666;">
                            {{ $courseStudent->created_at ? $courseStudent->created_at->format('M d, Y') : 'N/A' }}
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('course_students.show', $courseStudent->id) }}" style="padding: 0.5rem 1rem; background: #3b82f6; color: #fff; border: none; border-radius: 6px; font-size: 0.875rem; text-decoration: none; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 2px 4px rgba(59, 130, 246, 0.25); display: inline-block; margin-right: 0.5rem;" onmouseover="this.style.boxShadow='0 4px 8px rgba(59, 130, 246, 0.4)';" onmouseout="this.style.boxShadow='0 2px 4px rgba(59, 130, 246, 0.25)';">View</a>
                            <a href="{{ route('course_students.edit', $courseStudent->id) }}" style="padding: 0.5rem 1rem; background: #f59e0b; color: #fff; border: none; border-radius: 6px; font-size: 0.875rem; text-decoration: none; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 2px 4px rgba(245, 158, 11, 0.25); display: inline-block; margin-right: 0.5rem;" onmouseover="this.style.boxShadow='0 4px 8px rgba(245, 158, 11, 0.4)';" onmouseout="this.style.boxShadow='0 2px 4px rgba(245, 158, 11, 0.25)';">Edit</a>
                            <form action="{{ route('course_students.destroy', $courseStudent->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="padding: 0.5rem 1rem; background: #ef4444; color: #fff; border: none; border-radius: 6px; font-size: 0.875rem; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 2px 4px rgba(239, 68, 68, 0.25);" onmouseover="this.style.boxShadow='0 4px 8px rgba(239, 68, 68, 0.4)';" onmouseout="this.style.boxShadow='0 2px 4px rgba(239, 68, 68, 0.25)';">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="padding: 2rem; text-align: center; color: #999;">
                            No course-student assignments available. <a href="{{ route('course_students.create') }}" style="color: #ec4899; text-decoration: none; font-weight: 600;">Create one</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($courseStudents->hasPages())
        <div style="margin-top: 2rem; display: flex; justify-content: center;">
            {{ $courseStudents->links('pagination::bootstrap-4') }}
        </div>
    @endif
@endsection
