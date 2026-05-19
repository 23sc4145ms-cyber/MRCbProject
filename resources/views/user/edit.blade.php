@extends('format.layout')

@section('title', 'Edit User')

@section('content')
    <div style="margin-bottom: 40px;">
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Edit User</h1>
        <p style="color: #9f1239; font-size: 1rem; margin-top: 0.5rem;">Update a user's account information.</p>
    </div>

    @if ($errors->any())
        <div style="padding: 1rem; background: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; color: #991b1b; margin-bottom: 1.5rem;">
            <ul style="margin-left: 1.5rem;">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="max-width: 760px; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(236, 72, 153, 0.15);">
        <form action="{{ route('users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div style="margin-bottom: 1.5rem;">
                <label for="username" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Username <span style="color: #112C01;">*</span></label>
                <input type="text" name="username" id="username" value="{{ old('username', $user->username) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
                @error('username')
                    <small style="color: #ef4444; display: block; margin-top: 0.25rem;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="email" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Email <span style="color: #112C01;">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
                @error('email')
                    <small style="color: #ef4444; display: block; margin-top: 0.25rem;">{{ $message }}</small>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="role" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Role <span style="color: #112C01;">*</span></label>
                <select name="role" id="role" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role')
                    <small style="color: #ef4444; display: block; margin-top: 0.25rem;">{{ $message }}</small>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Update User</button>
                <a href="{{ route('users.show', $user->id) }}" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border-radius: 8px; text-decoration: none;">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);
                const eyeIcon = this.querySelector('.eye-icon');
                const eyeClosedIcon = this.querySelector('.eye-closed-icon');
                
                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeClosedIcon.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'block';
                    eyeClosedIcon.style.display = 'none';
                }
            });
        });
    </script>
@endsection
