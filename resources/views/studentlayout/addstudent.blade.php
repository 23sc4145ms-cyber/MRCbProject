@extends('format.layout')

@section('title')
    Add Student
@endsection

@section('content')
<style>
    /* BACKGROUND DESIGN */
    body {
        background: linear-gradient(135deg, #f0f5eb, #f8faf5);
    }

    .background-design {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(circle at top left, rgba(171,194,139,0.15), transparent 40%),
                    radial-gradient(circle at bottom right, rgba(144,168,84,0.15), transparent 40%);
        z-index: -1;
    }

    /* CENTER EVERYTHING */
    .center-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        min-height: 80vh;
        text-align: center;
    }

    /* HEADER */
    .page-header {
        margin-bottom: 30px;
    }

    .page-header h1 {
        color: #ABC28B;
        font-size: 3rem;
        font-weight: 800;
        margin: 0;
    }

    .page-header p {
        color: #677C56;
        font-size: 1.1rem;
        margin-top: 0.5rem;
    }

    /* FORM CONTAINER */
    .form-container {
        width: 100%;
        max-width: 750px;
        background: #ffffff;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 25px rgba(171, 194, 139, 0.2);
        text-align: left;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        color: #ABC28B;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-group .required {
        color: #112C01;
    }

    .form-group input,
    .form-group select {
        width: 100%;
        padding: 0.9rem;
        border: 2px solid #e0e7d8;
        border-radius: 10px;
        font-size: 1rem;
        transition: 0.2s;
    }

    .form-group input:focus,
    .form-group select:focus {
        border-color: #ABC28B;
        outline: none;
        box-shadow: 0 0 0 3px rgba(171,194,139,0.2);
    }

    /* BUTTONS */
    .button-group {
        display: flex;
        gap: 1rem;
        margin-top: 2rem;
        justify-content: center;
    }

    .btn-submit {
        padding: 0.85rem 2rem;
        background: linear-gradient(135deg, #ABC28B, #90A854);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-size: 1.05rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 6px 12px rgba(171, 194, 139, 0.3);
        transition: 0.3s;
    }

    .btn-submit:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 18px rgba(171, 194, 139, 0.4);
    }

    .btn-cancel {
        padding: 0.85rem 2rem;
        background-color: #e5e7eb;
        color: #374151;
        text-decoration: none;
        border-radius: 10px;
        font-size: 1.05rem;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-cancel:hover {
        background-color: #d1d5db;
    }

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

<div class="background-design"></div>

<div class="center-wrapper">
    <div class="page-header">
        <h1>Add New Student</h1>
        <p>Fill out the form below to add a new student to the database.</p>
    </div>

    @if($errors->any())
    <div style="width: 100%; max-width: 750px; padding: 1.5rem; background-color: #fee2e2; border-left: 5px solid #ef4444; border-radius: 8px; margin-bottom: 2rem; color: #7f1d1d;">
        <h3 style="margin-top: 0; color: #991b1b;">Please fix the following errors:</h3>
        <ul style="margin: 1rem 0; padding-left: 1.5rem;">
            @foreach($errors->all() as $error)
                <li style="margin: 0.5rem 0; font-weight: 500;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="addStudentForm" class="form-container">
        @csrf
        
        <!-- Success/Error Messages -->
        <div id="formMessage" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;"></div>
        
        <div class="form-group">
            <label for="fname">First Name <span class="required">*</span></label>
            <input type="text" name="fname" id="fname" placeholder="Enter first name" required>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="form-group">
            <label for="mname">Middle Name</label>
            <input type="text" name="mname" id="mname" placeholder="Enter middle name (optional)">
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="form-group">
            <label for="lname">Last Name <span class="required">*</span></label>
            <input type="text" name="lname" id="lname" placeholder="Enter last name" required>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="form-group">
            <label for="username">Username <span class="required">*</span></label>
            <input type="text" name="username" id="username" placeholder="Enter username" required>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="form-group">
            <label for="email">Email <span class="required">*</span></label>
            <input type="email" name="email" id="email" placeholder="Enter email address" required>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="form-group">
            <label for="contact">Contact <span class="required">*</span></label>
            <input type="text" name="contact" id="contact" placeholder="Enter contact number" required>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="form-group">
            <label for="course_id">Degree <span class="required">*</span></label>
            <select name="course_id" id="course_id" required>
                <option value="" disabled selected>Select a degree</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}">{{ $course->name }}</option>
                @endforeach
            </select>
            <small class="error-message" style="color: #ef4444; display: none; margin-top: 0.25rem;"></small>
        </div>

        <div class="button-group">
            <button type="submit" class="btn-submit">Add Student</button>
            <a href="{{ route('students.index') }}" class="btn-cancel">Cancel</a>
        </div>
    </form>
</div>

<!-- All AJAX code is now in app.js -->

@endsection