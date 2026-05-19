@extends('format.layout')

@section('title', 'Teacher Details')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Teacher Details</h1>
        <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">View teacher information.</p>
    </div>

    @if (session('success'))
        <div style="padding: 1rem; background: #d1fae5; border: 1px solid #6ee7b7; border-radius: 8px; color: #065f46; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="max-width: 760px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);">
        
        <div style="margin-bottom: 2rem;">
            <h3 style="color: #ABC28B; font-size: 1.3rem; margin-bottom: 1rem; border-bottom: 2px solid #e0e7d8; padding-bottom: 0.5rem;">Teacher Information</h3>
            
            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #677C56; font-weight: 600; margin-bottom: 0.25rem;">Name</label>
                <p style="color: #333; margin: 0;">{{ $teacher->fname }} {{ $teacher->mname }} {{ $teacher->lname }}</p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #677C56; font-weight: 600; margin-bottom: 0.25rem;">Email</label>
                <p style="color: #333; margin: 0;">{{ $teacher->email }}</p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #677C56; font-weight: 600; margin-bottom: 0.25rem;">Contact Number</label>
                <p style="color: #333; margin: 0;">{{ $teacher->contact }}</p>
            </div>

            @if($teacher->user)
            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #677C56; font-weight: 600; margin-bottom: 0.25rem;">Username</label>
                <p style="color: #333; margin: 0;">{{ $teacher->user->username }}</p>
            </div>

            <div style="margin-bottom: 1rem;">
                <label style="display: block; color: #677C56; font-weight: 600; margin-bottom: 0.25rem;">Account Status</label>
                <p style="color: #333; margin: 0;">{{ $teacher->user->is_active ? 'Active' : 'Inactive' }}</p>
            </div>
            @endif
        </div>

        <div style="display: flex; gap: 1rem;">
            <a href="{{ route('teachers.edit', $teacher->id) }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border-radius: 8px; text-decoration: none; font-weight: 600;">Edit Teacher</a>
            <a href="{{ route('teachers.index') }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Back to List</a>
        </div>
    </div>
@endsection
