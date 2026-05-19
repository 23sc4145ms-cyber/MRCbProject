@extends('format.layout')

@section('title', 'Edit Teacher')

@section('content')

<div style="display:flex; justify-content:center; align-items:center; flex-direction:column; min-height:100vh; background:#f0fdf4; padding:20px;">

    <div style="margin-bottom: 40px; text-align:center;">
        <h1 style="color: #059669; font-size: 2.5rem; font-weight: 700; margin: 0;">
            Edit Teacher
        </h1>
        <p style="color: #065f46; font-size: 1rem; margin-top: 0.5rem;">
            Update teacher information.
        </p>
    </div>

    @if ($errors->any())
        <div style="padding: 1rem; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #991b1b; margin-bottom: 1.5rem; width:100%; max-width:760px;">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="width:100%; max-width: 760px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2);">

        <form action="{{ route('teachers.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- TEACHER INFORMATION SECTION -->
            <h3 style="color: #059669; font-size: 1.3rem; margin-bottom: 1rem; border-bottom: 2px solid #d1fae5; padding-bottom: 0.5rem;">
                Teacher Information
            </h3>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">First Name *</label>
                <input type="text" name="fname" value="{{ old('fname', $teacher->fname) }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Middle Name</label>
                <input type="text" name="mname" value="{{ old('mname', $teacher->mname) }}" style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;" placeholder="Optional">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Last Name *</label>
                <input type="text" name="lname" value="{{ old('lname', $teacher->lname) }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Email *</label>
                <input type="email" name="email" value="{{ old('email', $teacher->email) }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Contact Number *</label>
                <input type="text" name="contact" value="{{ old('contact', $teacher->contact) }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;" placeholder="09XXXXXXXXX">
            </div>

            <div style="display:flex; gap:1rem; justify-content:center;">
                <button type="submit"
                    style="padding:0.75rem 1.5rem; background:linear-gradient(135deg,#f59e0b,#d97706); color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">
                    Update Teacher
                </button>

                <a href="{{ route('teachers.show', $teacher->id) }}"
                    style="padding:0.75rem 1.5rem; background:#e5e7eb; color:#374151; border-radius:8px; text-decoration:none;">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
