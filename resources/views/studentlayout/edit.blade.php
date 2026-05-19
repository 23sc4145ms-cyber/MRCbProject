@extends('format.layout')

@section('title')
    Edit Student
@endsection

@section('content')
<style>
    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper input {
        width: 100%;
        padding-right: 40px;
    }

    .toggle-password {
        position: absolute;
        right: 12px;
        top: 50%;
        transform: translateY(-50%);
        cursor: pointer;
        color: #ABC28B;
        font-size: 1.2rem;
        user-select: none;
    }

    .toggle-password:hover {
        color: #90A854;
    }
</style>
<div style="display: flex; justify-content: center; align-items: center; flex-direction: column; margin-top: 2rem;">

    <!-- Page Header -->
    <div style="margin-bottom: 40px; text-align: center;">
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Edit Student</h1>
        <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Update student information</p>
    </div>

    <!-- Form Container -->
    <form action="{{ route('students.update', $student->id) }}" method="POST" style="max-width: 600px; width: 100%; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);">
        @csrf
        @method('PUT')
        
        <!-- First Name -->
        <div style="margin-bottom: 1.5rem;">
            <label for="fname" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">First Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="fname" id="fname" placeholder="Enter first name" value="{{ old('fname', $student->fname) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
        </div>

        <!-- Middle Name -->
        <div style="margin-bottom: 1.5rem;">
            <label for="mname" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Middle Name</label>
            <input type="text" name="mname" id="mname" placeholder="Enter middle name" value="{{ old('mname', $student->mname) }}" style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
        </div>

        <!-- Last Name -->
        <div style="margin-bottom: 1.5rem;">
            <label for="lname" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Last Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="lname" id="lname" placeholder="Enter last name" value="{{ old('lname', $student->lname) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
        </div>

        <!-- Contact -->
        <div style="margin-bottom: 2rem;">
            <label for="contact" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Contact <span style="color: #ef4444;">*</span></label>
            <input type="text" name="contact" id="contact" placeholder="Enter contact number" value="{{ old('contact', $student->contact) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
        </div>

        <!-- Course -->
        <div style="margin-bottom: 2rem;">
            <label for="course_id" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Course <span style="color: #ef4444;">*</span></label>
            <select name="course_id" id="course_id" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
                <option value="" disabled>Select a course</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $student->course_id) == $course->id ? 'selected' : '' }}>{{ $course->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Email -->
        <div style="margin-bottom: 2rem;">
            <label for="email" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Email <span style="color: #ef4444;">*</span></label>
            <input type="email" name="email" id="email" placeholder="Enter email" value="{{ old('email', $student->email) }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
        </div>

        <!-- Password -->
        <div style="margin-bottom: 1.5rem;">
            <label for="password" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Password (Leave blank to keep current)</label>
            <div class="password-wrapper">
                <input type="password" name="password" id="password" placeholder="Enter new password" style="padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
                <span class="toggle-password" onclick="togglePassword('password')">👁️</span>
            </div>
        </div>

        <!-- Confirm Password -->
        <div style="margin-bottom: 2rem;">
            <label for="password_confirmation" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Confirm Password</label>
            <div class="password-wrapper">
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirm password" style="padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
                <span class="toggle-password" onclick="togglePassword('password_confirmation')">👁️</span>
            </div>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.25);" onmouseover="this.style.boxShadow='0 8px 12px rgba(171, 194, 139, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(171, 194, 139, 0.25)';">Update Student</button>
            <a href="{{ route('students.show', $student->id) }}" style="padding: 0.75rem 1.5rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease; display: inline-block;" onmouseover="this.style.backgroundColor='#d1d5db';" onmouseout="this.style.backgroundColor='#e5e7eb';">Cancel</a>
        </div>

    </form>
</div>

<script>
    function togglePassword(fieldId) {
        const field = document.getElementById(fieldId);
        const icon = event.target;
        
        if (field.type === 'password') {
            field.type = 'text';
            icon.textContent = '🙈';
        } else {
            field.type = 'password';
            icon.textContent = '👁️';
        }
    }
</script>

@endsection
