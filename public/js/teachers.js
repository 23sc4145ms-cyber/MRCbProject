// Teachers CRUD with jQuery AJAX

$(document).ready(function() {
    // Load teachers when page loads
    loadTeachers();
    
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// READ - Load all teachers
function loadTeachers() {
    $.get("/teachers", function(data) {
        renderTeachersTable(data.teachers);
    });
}

// Render teachers table
function renderTeachersTable(teachers) {
    let html = '';
    
    if (teachers.length === 0) {
        html = '<tr><td colspan="4" style="padding: 2rem; text-align: center; color: #999;">No teachers available.</td></tr>';
    } else {
        teachers.forEach(function(teacher, index) {
            const bgColor = index % 2 === 0 ? '#fff' : '#f0f5eb';
            const fullName = teacher.fname + ' ' + (teacher.mname || '') + ' ' + teacher.lname;
            const email = teacher.user ? teacher.user.email : 'N/A';
            
            html += `
                <tr style="border-bottom: 1px solid #e0e7d8; background-color: ${bgColor};" 
                    onmouseover="this.style.backgroundColor='#f0f5eb';" 
                    onmouseout="this.style.backgroundColor='${bgColor}';">
                    <td style="padding: 1rem; color: #677C56; font-weight: 600;">${index + 1}</td>
                    <td style="padding: 1rem; color: #333;">${fullName}</td>
                    <td style="padding: 1rem; color: #666;">${email}</td>
                    <td style="padding: 1rem; text-align: center;">
                        <button onclick="viewTeacher(${teacher.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #ABC28B, #90A854); color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; font-weight: 600;" title="View">
                            👁️ View
                        </button>
                        <button onclick="editTeacher(${teacher.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #90A854, #7a8f47); color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; font-weight: 600;" title="Edit">
                            ✏️ Edit
                        </button>
                        <button onclick="deleteTeacher(${teacher.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #677C56, #556647); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;" title="Delete">
                            🗑️ Delete
                        </button>
                    </td>
                </tr>
            `;
        });
    }
    
    $('#teachersTableBody').html(html);
}

// VIEW - Show teacher details in modal
function viewTeacher(id) {
    $.get("/teachers/" + id, function(response) {
        const teacher = response.teacher;
        const fullName = teacher.fname + ' ' + (teacher.mname || '') + ' ' + teacher.lname;
        const email = teacher.user ? teacher.user.email : 'N/A';
        const username = teacher.user ? teacher.user.username : 'N/A';
        
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
                    <p style="margin: 0; color: #333;">${teacher.contact}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Teacher ID</label>
                    <p style="margin: 0; color: #333;">${teacher.id}</p>
                </div>
            </div>
        `;
        
        $('#viewModalContent').html(html);
        $('#viewModal').css('display', 'flex');
    });
}

// EDIT - Show edit form in modal
function editTeacher(id) {
    $.get("/teachers/" + id, function(response) {
        const teacher = response.teacher;
        
        // Populate edit form
        $('#edit_id').val(teacher.id);
        $('#edit_fname').val(teacher.fname);
        $('#edit_mname').val(teacher.mname || '');
        $('#edit_lname').val(teacher.lname);
        $('#edit_contact').val(teacher.contact);
        
        // Show edit modal
        $('#editModal').css('display', 'flex');
    });
}

// UPDATE - Submit edit form via AJAX
$('#editTeacherForm').submit(function(e) {
    e.preventDefault();
    
    let id = $('#edit_id').val();
    let formData = {
        fname: $('#edit_fname').val(),
        mname: $('#edit_mname').val(),
        lname: $('#edit_lname').val(),
        contact: $('#edit_contact').val()
    };
    
    $.ajax({
        url: "/teachers/" + id,
        type: "PUT",
        data: formData,
        success: function(response) {
            showAlert('Teacher updated successfully!', 'success');
            closeEditModal();
            loadTeachers();
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMsg = 'Error updating teacher:\n';
            for (let key in errors) {
                errorMsg += errors[key][0] + '\n';
            }
            showAlert(errorMsg, 'error');
        }
    });
});

// DELETE - Delete teacher
let teacherToDelete = null;

function deleteTeacher(id) {
    teacherToDelete = id;
    $('#deleteModal').css('display', 'flex');
}

function closeDeleteModal() {
    $('#deleteModal').css('display', 'none');
    teacherToDelete = null;
}

$('#confirmDeleteBtn').click(function() {
    if (teacherToDelete) {
        $.ajax({
            url: "/teachers/" + teacherToDelete,
            type: "DELETE",
            success: function(response) {
                showAlert('Teacher deleted successfully!', 'success');
                closeDeleteModal();
                loadTeachers();
            },
            error: function(xhr) {
                showAlert('Error deleting teacher', 'error');
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
    $('#editTeacherForm')[0].reset();
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
    
    setTimeout(function() {
        alertDiv.fadeOut();
    }, 3000);
}

// Close modals when clicking outside
$('#viewModal, #editModal, #deleteModal').click(function(e) {
    if (e.target === this) {
        $(this).css('display', 'none');
        if (this.id === 'deleteModal') {
            teacherToDelete = null;
        }
    }
});
