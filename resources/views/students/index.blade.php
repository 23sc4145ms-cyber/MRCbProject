@extends('format.layout')

@section('title', 'Students')

@section('content')

<div style="margin-bottom: 40px; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="color: #ABC28B; font-size: 2.5rem; font-weight: 700; margin: 0;">Students</h1>
        <p style="color: #677C56; font-size: 1rem; margin-top: 0.5rem;">Manage all students </p>
    </div>
    <a href="{{ route('students.create') }}" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B, #90A854); color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600;">
        + Add Student
    </a>
</div>

<!-- Success/Error Messages -->
<div id="alertMessage" style="display: none; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;"></div>

<!-- Students Table -->
<div style="background: #fff; padding: 2rem; border-radius: 12px; box-shadow: 0 4px 6px rgba(171, 194, 139, 0.15); overflow-x: auto;">
    <table id="studentsTable" style="width: 100%; border-collapse: collapse;">
        <thead>
            <tr style="background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); color: #112C01;">
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">#</th>
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">Name</th>
                <th style="padding: 1.25rem 1rem; text-align: left; font-weight: 600;">Email</th>
                <th style="padding: 1.25rem 1rem; text-align: center; font-weight: 600;">Actions</th>
            </tr>
        </thead>
        <tbody id="studentsTableBody">
            <tr>
                <td colspan="4" style="padding: 2rem; text-align: center; color: #999;">
                    Loading students...
                </td>
            </tr>
        </tbody>
    </table>
</div>

<!-- View Student Modal -->
<div id="viewModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 16px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); padding: 2rem; color: #fff;">
            <h2 style="margin: 0; font-size: 1.75rem;"> Student Details</h2>
        </div>
        <div id="viewModalContent" style="padding: 2rem;">
            <!-- Content will be loaded via AJAX -->
        </div>
        <div style="padding: 1rem 2rem; border-top: 1px solid #e0e7d8; display: flex; justify-content: flex-end;">
            <button onclick="closeViewModal()" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Close</button>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 16px; max-width: 450px; width: 90%; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #677C56 0%, #556647 100%); padding: 2rem; color: #fff; border-radius: 16px 16px 0 0;">
            <h2 style="margin: 0; font-size: 1.5rem;"> Confirm Delete</h2>
        </div>
        <div style="padding: 2rem;">
            <p style="margin: 0; color: #333; font-size: 1.1rem; line-height: 1.6;">Are you sure you want to delete this student? This action cannot be undone.</p>
        </div>
        <div style="padding: 1rem 2rem 2rem; display: flex; gap: 1rem; justify-content: flex-end;">
            <button onclick="closeDeleteModal()" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
            <button id="confirmDeleteBtn" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #677C56, #556647); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Delete</button>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div id="editModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: #fff; border-radius: 16px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto; box-shadow: 0 10px 25px rgba(0,0,0,0.3);">
        <div style="background: linear-gradient(135deg, #ABC28B 0%, #90A854 100%); padding: 2rem; color: #fff;">
            <h2 style="margin: 0; font-size: 1.75rem;"> Edit Student</h2>
        </div>
        <form id="editStudentForm" style="padding: 2rem;">
            <input type="hidden" id="edit_id">
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">First Name *</label>
                <input type="text" id="edit_fname" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Middle Name</label>
                <input type="text" id="edit_mname" style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Last Name *</label>
                <input type="text" id="edit_lname" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Contact *</label>
                <input type="text" id="edit_contact" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
            </div>
            
            <div style="margin-bottom: 1.5rem;">
                <label style="display: block; color: #ABC28B; font-weight: 600; margin-bottom: 0.5rem;">Degree *</label>
                <select id="edit_course_id" required style="width: 100%; padding: 0.75rem; border: 2px solid #e0e7d8; border-radius: 8px;">
                    <option value="">Select a degree</option>
                    @foreach(\App\Models\Course::all() as $course)
                        <option value="{{ $course->id }}">{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <button type="button" onclick="closeEditModal()" style="padding: 0.75rem 1.5rem; background: #e5e7eb; color: #374151; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Cancel</button>
                <button type="submit" style="padding: 0.75rem 1.5rem; background: linear-gradient(135deg, #ABC28B, #90A854); color: #fff; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Update Student</button>
            </div>
        </form>
    </div>
</div>



@endsection
