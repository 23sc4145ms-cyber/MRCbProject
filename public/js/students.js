// Students CRUD with jQuery AJAX

$(document).ready(function() {
    // Load students when page loads
    loadStudents();
    
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// READ - Load all students
function loadStudents() {
    $.get("/students", function(data) {
        renderStudentsTable(data.students);
    });
}

// Render students table
function renderStudentsTable(students) {
    let html = '';
    
    if (students.length === 0) {
        html = '<tr><td colspan="4" style="padding: 2rem; text-align: center; color: #999;">No students available.</td></tr>';
    } else {
        students.forEach(function(student, index) {
            const bgColor = index % 2 === 0 ? '#fff' : '#f0f5eb';
            const fullName = student.fname + ' ' + (student.mname || '') + ' ' + student.lname;
            const email = student.user ? student.user.email : 'N/A';
            
            html += `
                <tr style="border-bottom: 1px solid #e0e7d8; background-color: ${bgColor};" 
                    onmouseover="this.style.backgroundColor='#f0f5eb';" 
                    onmouseout="this.style.backgroundColor='${bgColor}';">
                    <td style="padding: 1rem; color: #677C56; font-weight: 600;">${index + 1}</td>
                    <td style="padding: 1rem; color: #333;">${fullName}</td>
                    <td style="padding: 1rem; color: #666;">${email}</td>
                    <td style="padding: 1rem; text-align: center;">
                        <button onclick="viewStudent(${student.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #ABC28B, #90A854); color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; font-weight: 600;" title="View">
                            👁️ View
                        </button>
                        <button onclick="editStudent(${student.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #90A854, #7a8f47); color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; font-weight: 600;" title="Edit">
                            ✏️ Edit
                        </button>
                        <button onclick="deleteStudent(${student.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #677C56, #556647); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;" title="Delete">
                            🗑️ Delete
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    $('#studentsTableBody').html(html);
}

// VIEW - Show student details in modal
function viewStudent(id) {
    $.get("/students/" + id, function(response) {
        const student = response.student;
        const fullName = student.fname + ' ' + (student.mname || '') + ' ' + student.lname;
        const email = student.user ? student.user.email : 'N/A';
        const username = student.user ? student.user.username : 'N/A';
        const course = student.course ? student.course.name : 'Not Assigned';
        
        let html = `
            <div style="display: grid; gap: 1.5rem;">
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Full Name</label>
                    <p style="margin: 0; color: #333; font-size: 1.125rem;">${fullName}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Username</label>
                    <p style="margin: 0; color: #333;">${username}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Email</label>
                    <p style="margin: 0; color: #333;">${email}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Contact</label>
                    <p style="margin: 0; color: #333;">${student.contact}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Degree</label>
                    <p style="margin: 0; color: #333;">${course}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Student ID</label>
                    <p style="margin: 0; color: #333;">${student.id}</p>
                </div>
            </div>
        `;
        
        $('#viewModalContent').html(html);
        $('#viewModal').css('display', 'flex');
    });
}

// EDIT - Show edit form in modal
function editStudent(id) {
    $.get("/students/" + id, function(response) {
        const student = response.student;
        
        // Populate edit form
        $('#edit_id').val(student.id);
        $('#edit_fname').val(student.fname);
        $('#edit_mname').val(student.mname || '');
        $('#edit_lname').val(student.lname);
        $('#edit_contact').val(student.contact);
        $('#edit_course_id').val(student.course_id);
        
        // Show edit modal
        $('#editModal').css('display', 'flex');
    });
}

// UPDATE - Submit edit form via AJAX
$('#editStudentForm').submit(function(e) {
    e.preventDefault(); // Prevent default form submission
    
    let id = $('#edit_id').val();
    let formData = {
        fname: $('#edit_fname').val(),
        mname: $('#edit_mname').val(),
        lname: $('#edit_lname').val(),
        contact: $('#edit_contact').val(),
        course_id: $('#edit_course_id').val()
    };
    
    $.ajax({
        url: "/students/" + id,
        type: "PUT",
        data: formData,
        success: function(response) {
            showAlert('Student updated successfully!', 'success');
            closeEditModal();
            loadStudents(); // Reload table
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMsg = 'Error updating student:\n';
            for (let key in errors) {
                errorMsg += errors[key][0] + '\n';
            }
            showAlert(errorMsg, 'error');
        }
    });
});

// DELETE - Delete student
let studentToDelete = null;

function deleteStudent(id) {
    studentToDelete = id;
    $('#deleteModal').css('display', 'flex');
}

function closeDeleteModal() {
    $('#deleteModal').css('display', 'none');
    studentToDelete = null;
}

// Confirm delete button click
$('#confirmDeleteBtn').click(function() {
    if (studentToDelete) {
        $.ajax({
            url: "/students/" + studentToDelete,
            type: "DELETE",
            success: function(response) {
                showAlert('Student deleted successfully!', 'success');
                closeDeleteModal();
                loadStudents(); // Reload table
            },
            error: function(xhr) {
                showAlert('Error deleting student', 'error');
                closeDeleteModal();
            }
        });
    }
});

// Close view modal
function closeViewModal() {
    $('#viewModal').css('display', 'none');
}

// Close edit modal
function closeEditModal() {
    $('#editModal').css('display', 'none');
    $('#editStudentForm')[0].reset();
}

// Show alert message
function showAlert(message, type) {
    const alertDiv = $('#alertMessage');
    const bgColor = type === 'success' ? '#f0f5eb' : '#fee2e2';
    const borderColor = type === 'success' ? '#ABC28B' : '#ef4444';
    const textColor = type === 'success' ? '#677C56' : '#7f1d1d';
    
    alertDiv.css({
        'background-color': bgColor,
        'border-left': `4px solid ${borderColor}`,
        'color': textColor,
        'display': 'block'
    }).text(message);
    
    // Auto hide after 3 seconds
    setTimeout(function() {
        alertDiv.fadeOut();
    }, 3000);
}

// Close modals when clicking outside
$('#viewModal, #editModal, #deleteModal').click(function(e) {
    if (e.target === this) {
        $(this).css('display', 'none');
        if (this.id === 'deleteModal') {
            studentToDelete = null;
        }
    }
});
