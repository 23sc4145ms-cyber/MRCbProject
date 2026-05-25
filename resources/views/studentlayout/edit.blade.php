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
    <form id="editStudentForm" onsubmit="return false;" style="max-width: 600px; width: 100%; background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15);">
        @csrf
        <input type="hidden" name="student_id" id="student_id" value="{{ $student->id }}">
        
        <!-- Success/Error Messages -->
        <div id="formMessage" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;"></div>
        
        <!-- First Name -->
        <div style="margin-bottom: 1.5rem;">
            <label for="firstName" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">First Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="first_name" id="firstName" placeholder="Enter first name" value="{{ $student->fname }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <!-- Middle Name -->
        <div style="margin-bottom: 1.5rem;">
            <label for="middleName" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Middle Name</label>
            <input type="text" name="middle_name" id="middleName" placeholder="Enter middle name" value="{{ $student->mname }}" style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <!-- Last Name -->
        <div style="margin-bottom: 1.5rem;">
            <label for="lastName" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Last Name <span style="color: #ef4444;">*</span></label>
            <input type="text" name="last_name" id="lastName" placeholder="Enter last name" value="{{ $student->lname }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <!-- Contact -->
        <div style="margin-bottom: 2rem;">
            <label for="contactNo" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Contact <span style="color: #ef4444;">*</span></label>
            <input type="text" name="contact_no" id="contactNo" placeholder="Enter contact number" value="{{ $student->contact }}" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <!-- Degree -->
        <div style="margin-bottom: 1.5rem;">
            <label for="degree" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Degree <span style="color: #ef4444;">*</span></label>
            <select name="degree_id" id="degree" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
                <option value="" disabled>Select a degree</option>
                @foreach($degrees as $degree)
                    <option value="{{ $degree->id }}" {{ $student->course_id == $degree->id ? 'selected' : '' }}>{{ $degree->name }}</option>
                @endforeach
            </select>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <!-- Courses (Multi-select) -->
        <div style="margin-bottom: 2rem;">
            <label for="courses" style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Courses (Subjects)</label>
            <select name="courses[]" id="courses" multiple style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px; font-size: 1rem; transition: border-color 0.2s ease; min-height: 120px;" onfocus="this.style.borderColor='#ABC28B';" onblur="this.style.borderColor='#e0e7d8';">
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ $student->courses->contains($course->id) ? 'selected' : '' }}>{{ $course->code }} - {{ $course->name }}</option>
                @endforeach
            </select>
            <small style="color: #677C56; font-size: 0.875rem; margin-top: 0.25rem; display: block;">Hold Ctrl (Windows) or Cmd (Mac) to select multiple courses</small>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <!-- Buttons -->
        <div style="display: flex; gap: 1rem; justify-content: center;">
            <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #fff; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: box-shadow 0.2s ease; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.25);" onmouseover="this.style.boxShadow='0 8px 12px rgba(171, 194, 139, 0.4)';" onmouseout="this.style.boxShadow='0 4px 6px rgba(171, 194, 139, 0.25)';">Update Student</button>
            <a href="{{ route('students.index') }}" style="padding: 0.75rem 1.5rem; background-color: #e5e7eb; color: #374151; text-decoration: none; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: background-color 0.2s ease; display: inline-block;" onmouseover="this.style.backgroundColor='#d1d5db';" onmouseout="this.style.backgroundColor='#e5e7eb';">Cancel</a>
        </div>

    </form>
</div>

<!-- All AJAX code is now in app.js -->

@endsection
