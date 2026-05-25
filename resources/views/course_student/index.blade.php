@extends('format.layout')

@section('title', 'Course-Student Assignments')

@section('content')
    <div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Course-Student Assignments</h1>
            <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Manage course enrollments</p>
        </div>
        <a href="{{ route('course_students.create') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.25); text-decoration: none; display: inline-block;" onmouseover="this.style.boxShadow='0 8px 12px rgba(171, 194, 139, 0.4);" onmouseout="this.style.boxShadow='0 4px 6px rgba(171, 194, 139, 0.25);">+ New Assignment</a>
    </div>

    @if ($message = Session::get('success'))
        <div style="padding: 1rem; background: #f0f5eb; border-left: 4px solid #ABC28B; border-radius: 4px; margin-bottom: 1.5rem; color: #677C56;" role="alert">
            {{ $message }}
        </div>
    @endif

    <div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15); overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f3e8ff; border-bottom: 2px solid #ec4899;">
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">#</th>
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">Student Name</th>
                    <th style="padding: 1rem; text-align: left; color: #ec4899; font-weight: 600;">Course Code</th>
                    <th style="padding: 1rem; text-align: center; color: #ec4899; font-weight: 600;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courseStudents as $courseStudent)
                    <tr style="border-bottom: 1px solid #e5e7eb; transition: background-color 0.2s ease;" onmouseover="this.style.backgroundColor='#fdf2f8';" onmouseout="this.style.backgroundColor='transparent';">
                        <td style="padding: 1rem; color: #333;">{{ $loop->iteration }}</td>
                        <td style="padding: 1rem; color: #333;">
                            <span style="font-weight: 600;">{{ $courseStudent->student->fname ?? 'N/A' }} {{ $courseStudent->student->lname ?? '' }}</span>
                        </td>
                        <td style="padding: 1rem; color: #333;">
                            {{ $courseStudent->course->code ?? 'N/A' }}
                        </td>
                        <td style="padding: 1rem; text-align: center;">
                            <a href="{{ route('course_students.show', $courseStudent->id) }}" title="View" style="padding: 0.5rem 0.75rem; background: none; color: #ABC28B; border: 2px solid #ABC28B; border-radius: 6px; text-decoration: none; margin-right: 0.5rem; display: inline-block; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(171, 194, 139, 0.1)';" onmouseout="this.style.backgroundColor='transparent';">👁️</a>
                            <a href="{{ route('course_students.edit', $courseStudent->id) }}" title="Edit" style="padding: 0.5rem 0.75rem; background: none; color: #ABC28B; border: 2px solid #ABC28B; border-radius: 6px; text-decoration: none; margin-right: 0.5rem; display: inline-block; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(171, 194, 139, 0.1)';" onmouseout="this.style.backgroundColor='transparent';">✏️</a>
                            <form action="{{ route('course_students.destroy', $courseStudent->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" title="Delete" style="padding: 0.5rem 0.75rem; background: none; color: #ABC28B; border: 2px solid #ABC28B; border-radius: 6px; cursor: pointer; font-size: 1rem; transition: all 0.2s ease;" onmouseover="this.style.backgroundColor='rgba(171, 194, 139, 0.1)';" onmouseout="this.style.backgroundColor='transparent';">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 2rem; text-align: center; color: #999;">
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
