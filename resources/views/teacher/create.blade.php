@extends('format.layout')

@section('title', 'Create Teacher')

@section('content')

<div style="display:flex; justify-content:center; align-items:center; flex-direction:column; min-height:100vh; background:#f0fdf4; padding:20px;">

    <div style="margin-bottom: 40px; text-align:center;">
        <h1 style="color: #059669; font-size: 2.5rem; font-weight: 700; margin: 0;">
            Create Teacher
        </h1>
        <p style="color: #065f46; font-size: 1rem; margin-top: 0.5rem;">
            Add a new teacher account to the system.
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

        <!-- Success/Error Messages -->
        <div id="formMessage" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;"></div>

        <form id="addTeacherForm">
            @csrf

            <!-- TEACHER INFORMATION SECTION -->
            <h3 style="color: #059669; font-size: 1.3rem; margin-bottom: 1rem; border-bottom: 2px solid #d1fae5; padding-bottom: 0.5rem;">
                Teacher Information
            </h3>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">First Name *</label>
                <input type="text" name="fname" id="fname" value="{{ old('fname') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
                <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Middle Name</label>
                <input type="text" name="mname" id="mname" value="{{ old('mname') }}" style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;" placeholder="Optional">
                <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Last Name *</label>
                <input type="text" name="lname" id="lname" value="{{ old('lname') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
                <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Email *</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
                <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Contact Number *</label>
                <input type="text" name="contact" id="contact" value="{{ old('contact') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;" placeholder="09XXXXXXXXX">
                <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
            </div>

            <!-- ACCOUNT INFORMATION -->
            <h3 style="color: #059669; font-size: 1.3rem; margin-top:2rem; margin-bottom: 1rem; border-bottom: 2px solid #d1fae5; padding-bottom: 0.5rem;">
                Account Information
            </h3>

            <div style="margin-bottom: 1.5rem;">
                <label style="display:block; color:#065f46; font-weight:600;">Username *</label>
                <input type="text" name="username" id="username" value="{{ old('username') }}" required style="width:100%; padding:0.75rem; border:2px solid #d1fae5; border-radius:8px;">
                <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
            </div>

            <div style="display:flex; gap:1rem; justify-content:center;">
                <button type="submit"
                    style="padding:0.75rem 1.5rem; background:linear-gradient(135deg,#10b981,#059669); color:#fff; border:none; border-radius:8px; font-weight:600; cursor:pointer;">
                    Create Teacher
                </button>

                <a href="{{ route('teachers.index') }}"
                    style="padding:0.75rem 1.5rem; background:#e5e7eb; color:#374151; border-radius:8px; text-decoration:none;">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@endsection
