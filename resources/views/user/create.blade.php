@extends('format.layout')

@section('title', 'Create User')

@section('content')

<div style="display:flex; justify-content:center; align-items:center; flex-direction:column; min-height:100vh; background:#f0fdf4; padding:20px;">

    <div style="margin-bottom: 40px; text-align:center;">
        <h1 style="color: #059669; font-size: 2.5rem; font-weight: 700; margin: 0;">
            Create User & Student
        </h1>
        <p style="color: #065f46; font-size: 1rem; margin-top: 0.5rem;">
            Add a new user account with student information to the system.
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

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <!-- STUDENT INFORMATION SECTION -->
            <h3 style="color: #059669; font-size: 1.3rem; margin-bottom: 1rem; border-bottom: 2px solid #d1fae5; padding-bottom: 0.5rem;">
                Student Information
            </h3>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">First Name *</label>
                <input type="text" name="fname" value="{{ old('fname') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Middle Name *</label>
                <input type="text" name="mname" value="{{ old('mname') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Last Name *</label>
                <input type="text" name="lname" value="{{ old('lname') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Contact *</label>
                <input type="text" name="contact" value="{{ old('contact') }}" style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Degree *</label>
                <select name="degree_id" style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
                    <option disabled selected>Select a degree</option>
                    @foreach($degrees ?? [] as $degree)
                        <option value="{{ $degree->id }}">{{ $degree->Degree }}</option>
                    @endforeach
                </select>
            </div>

            <!-- ACCOUNT INFORMATION -->
            <h3 style="color: #059669; font-size: 1.3rem; margin-top:2rem; margin-bottom: 1rem; border-bottom: 2px solid #d1fae5; padding-bottom: 0.5rem;">
                Account Information
            </h3>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Username *</label>
                <input type="text" name="username" value="{{ old('username') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Email *</label>
                <input type="email" name="email" value="{{ old('email') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
            </div>

            <div style="margin-bottom: 1.5rem; padding: 1rem; background:#f0fdf4; border:1px solid #d1fae5; border-radius:8px;">
                <p style="color:#065f46; font-size:0.9rem; margin:0;">
                    🔑 Default passwords will be assigned:<br>
                    <strong>Student:</strong> student1234<br>
                    <strong>Teacher:</strong> teacher1234<br>
                    Users will be required to change their password on first login.
                </p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Role *</label>
                <select name="role" style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            <div style="display:flex; gap:1rem; justify-content:center;">
                <button type="submit"
                    style="padding:0.75rem 1.5rem; background:linear-gradient(135deg,#10b981,#059669); color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">
                    Create User & Student
                </button>

                <a href="{{ route('users.index') }}"
                    style="padding:0.75rem 1.5rem; background:#e5e7eb; color:#374151; border-radius:8px; text-decoration:none;">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection