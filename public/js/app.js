// ========================================
// GLOBAL APP.JS - ALL AJAX/jQuery CODE
// ========================================

$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    console.log('jQuery loaded successfully!');
    
    // ========================================
    // STUDENTS MODULE
    // ========================================
    
    // Auto-reload students table every 5 seconds
    if ($('#studentsTableBody').length) {
        loadStudents();
        setInterval(function() {
            autoReloadStudents();
        }, 5000);
    }
    
    // Auto reload function for students
    function autoReloadStudents() {
        if (!$('#studentsTableBody').length) return;
        var url = $('#studentsTableBody').data('url') || '/students';
        loadHtml($('#studentsTableBody'), url, { failPrefix: 'Failed to load students', includeUrl: true });
    }
    
    // Load HTML helper function
    function loadHtml($element, url, options) {
        $.get(url, function(data) {
            if (data.students) {
                renderStudentsTable(data.students);
            }
        }).fail(function() {
            if (options && options.failPrefix) {
                console.error(options.failPrefix);
            }
        });
    }
    
    // Load all students
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
    
    // ---------- Create Student ----------
    // Used on student create page: #savedStudent
    $(document).on('click', '#savedStudent', function(e) {
        e.preventDefault();
        console.debug('savedStudent clicked');
        
        var url = $(this).data('url') || appUrl('/students');
        
        var fname = $('#firstName').val();
        var mname = $('#middleName').val();
        var lname = $('#lastName').val();
        var email = $('#email').val();
        var degree = $('#degree').val();
        var contactNo = $('#contactNo').val();
        var username = $('#username').val();
        var password = $('#password').val();
        
        $.ajax({
            url: url,
            type: 'POST',
            data: {
                first_name: fname,
                middle_name: mname,
                last_name: lname,
                email: email,
                degree_id: degree,
                contact_no: contactNo,
                username: username,
                password: password
            },
            success: function(response) {
                alert('Student created successfully!');
                window.location.href = appUrl('/manageStudents');
            },
            error: function(xhr) {
                console.debug('AJAX error (student):', xhr && xhr.status, xhr && xhr.responseText);
                alert(validationMessage(xhr) || ('Failed to create student. ' + httpHint(xhr && xhr.status)));
            }
        });
    });
    
    // ---------- Delete Student (populate modal) ----------
    // Used in Student list (Delete button opens #deleteStudentModal and sets form action).
    $(document).on('show.bs.modal', '#deleteStudentModal', function(e) {
        var trigger = e.relatedTarget;
        if (!trigger) return;
        
        var $trigger = $(trigger);
        var action = $trigger.data('student-action');
        var name = $trigger.data('student-name');
        
        if (action) $('#deleteStudentForm').attr('action', action);
        if (name) $('#studentNameInModal').text(name);
    });
    
    // Validation message helper
    function validationMessage(xhr) {
        if (xhr && xhr.status === 422 && xhr.responseJSON && xhr.responseJSON.errors) {
            let errors = xhr.responseJSON.errors;
            let messages = [];
            for (let field in errors) {
                messages.push(errors[field][0]);
            }
            return messages.join('\n');
        }
        return null;
    }
    
    // HTTP hint helper
    function httpHint(status) {
        if (status === 422) return 'Validation failed.';
        if (status === 404) return 'Not found.';
        if (status === 500) return 'Server error.';
        return 'Error code: ' + status;
    }
    
    // App URL helper
    function appUrl(path) {
        return path.startsWith('/') ? path : '/' + path;
    }
    
    // Student form submission (Add) - Original form submit handler
    $('#addStudentForm').submit(function(e) {
        e.preventDefault();
        $('.error-message').hide().text('');
        $('#formMessage').hide();
        
        let formData = {
            fname: $('#fname').val() || $('#firstName').val(),
            mname: $('#mname').val() || $('#middleName').val(),
            lname: $('#lname').val() || $('#lastName').val(),
            username: $('#username').val(),
            email: $('#email').val(),
            contact: $('#contact').val() || $('#contactNo').val(),
            course_id: $('#course_id').val() || $('#degree').val()
        };
        
        $.ajax({
            url: "/students",
            type: "POST",
            data: formData,
            success: function(response) {
                $('#formMessage').css({
                    'background-color': '#f0f5eb',
                    'border-left': '4px solid #ABC28B',
                    'color': '#677C56',
                    'display': 'block'
                }).html('<strong>Success!</strong> Student added successfully. Redirecting...');
                
                $('#addStudentForm')[0].reset();
                
                setTimeout(function() {
                    window.location.href = "/students";
                }, 2000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('#formMessage').css({
                        'background-color': '#fee2e2',
                        'border-left': '4px solid #ef4444',
                        'color': '#7f1d1d',
                        'display': 'block'
                    }).html('<strong>Error!</strong> Please fix the errors below.');
                    
                    for (let field in errors) {
                        let errorMsg = errors[field][0];
                        $('#' + field).closest('.form-group, div').find('.error-message').text(errorMsg).show();
                    }
                } else {
                    $('#formMessage').css({
                        'background-color': '#fee2e2',
                        'border-left': '4px solid #ef4444',
                        'color': '#7f1d1d',
                        'display': 'block'
                    }).html('<strong>Error!</strong> Something went wrong. Please try again.');
                }
            }
        });
    });
    
    // ========================================
    // TEACHERS FORM HANDLERS
    // ========================================
    
    // Teacher form submission (Add)
    $('#addTeacherForm').submit(function(e) {
        e.preventDefault();
        $('.error-message').hide().text('');
        $('#formMessage').hide();
        
        let formData = {
            fname: $('#fname').val(),
            mname: $('#mname').val(),
            lname: $('#lname').val(),
            email: $('#email').val(),
            contact: $('#contact').val(),
            username: $('#username').val()
        };
        
        $.ajax({
            url: "/teachers",
            type: "POST",
            data: formData,
            success: function(response) {
                $('#formMessage').css({
                    'background-color': '#f0f5eb',
                    'border-left': '4px solid #ABC28B',
                    'color': '#677C56',
                    'display': 'block'
                }).html('<strong>Success!</strong> Teacher added successfully. Redirecting...');
                
                $('#addTeacherForm')[0].reset();
                
                setTimeout(function() {
                    window.location.href = "/teachers";
                }, 2000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('#formMessage').css({
                        'background-color': '#fee2e2',
                        'border-left': '4px solid #ef4444',
                        'color': '#7f1d1d',
                        'display': 'block'
                    }).html('<strong>Error!</strong> Please fix the errors below.');
                    
                    for (let field in errors) {
                        let errorMsg = errors[field][0];
                        $('#' + field).closest('div').find('.error-message').text(errorMsg).show();
                    }
                } else {
                    $('#formMessage').css({
                        'background-color': '#fee2e2',
                        'border-left': '4px solid #ef4444',
                        'color': '#7f1d1d',
                        'display': 'block'
                    }).html('<strong>Error!</strong> Something went wrong. Please try again.');
                }
            }
        });
    });
    
    
    // ========================================
    // TEACHERS MODULE
    // ========================================
    
    // Degree form submission (Add)
    $('#addDegreeForm').submit(function(e) {
        e.preventDefault();
        $('.error-message').hide().text('');
        $('#formMessage').hide();
        
        let formData = {
            name: $('#name').val(),
            description: $('#description').val()
        };
        
        $.ajax({
            url: "/courses",
            type: "POST",
            data: formData,
            success: function(response) {
                $('#formMessage').css({
                    'background-color': '#f0f5eb',
                    'border-left': '4px solid #ABC28B',
                    'color': '#677C56',
                    'display': 'block'
                }).html('<strong>Success!</strong> Degree added successfully. Redirecting...');
                
                $('#addDegreeForm')[0].reset();
                
                setTimeout(function() {
                    window.location.href = "/courses";
                }, 2000);
            },
            error: function(xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    $('#formMessage').css({
                        'background-color': '#fee2e2',
                        'border-left': '4px solid #ef4444',
                        'color': '#7f1d1d',
                        'display': 'block'
                    }).html('<strong>Error!</strong> Please fix the errors below.');
                    
                    for (let field in errors) {
                        let errorMsg = errors[field][0];
                        $('#' + field).closest('.form-group, div').find('.error-message').text(errorMsg).show();
                    }
                } else {
                    $('#formMessage').css({
                        'background-color': '#fee2e2',
                        'border-left': '4px solid #ef4444',
                        'color': '#7f1d1d',
                        'display': 'block'
                    }).html('<strong>Error!</strong> Something went wrong. Please try again.');
                }
            }
        });
    });
    
    
    // ========================================
    // TEACHERS MODULE
    // ========================================
    
    // Auto-reload teachers table every 5 seconds
    if ($('#teachersTableBody').length) {
        loadTeachers();
        setInterval(function() {
            autoReloadTeachers();
        }, 5000);
    }
    
    // Auto reload function for teachers
    function autoReloadTeachers() {
        if (!$('#teachersTableBody').length) return;
        var url = $('#teachersTableBody').data('url') || '/teachers';
        $.get(url, function(data) {
            if (data.teachers) {
                renderTeachersTable(data.teachers);
            }
        }).fail(function() {
            console.error('Failed to load teachers');
        });
    }
    
    // Load all teachers
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
    
    
    // ========================================
    // DEGREES MODULE
    // ========================================
    
    // Auto-reload degrees table every 5 seconds
    if ($('#degreesTableBody').length) {
        loadDegrees();
        setInterval(function() {
            autoReloadDegrees();
        }, 5000);
    }
    
    // Auto reload function for degrees
    function autoReloadDegrees() {
        if (!$('#degreesTableBody').length) return;
        var url = $('#degreesTableBody').data('url') || '/courses';
        $.get(url, function(data) {
            if (data.courses) {
                renderDegreesTable(data.courses);
            }
        }).fail(function() {
            console.error('Failed to load degrees');
        });
    }
    
    // Load all degrees
    function loadDegrees() {
        $.get("/courses", function(data) {
            renderDegreesTable(data.courses);
        });
    }
    
    // Render degrees table
    function renderDegreesTable(degrees) {
        let html = '';
        
        if (degrees.length === 0) {
            html = '<tr><td colspan="4" style="padding: 2rem; text-align: center; color: #999;">No degrees available. <a href="/courses/create" style="color: #ABC28B; text-decoration: none; font-weight: 600;">Create one</a></td></tr>';
        } else {
            degrees.forEach(function(degree, index) {
                const bgColor = index % 2 === 0 ? '#fff' : '#f0f5eb';
                const description = degree.description.length > 50 ? degree.description.substring(0, 50) + '...' : degree.description;
                
                html += `
                    <tr style="border-bottom: 1px solid #e0e7d8; background-color: ${bgColor};" 
                        onmouseover="this.style.backgroundColor='#f0f5eb';" 
                        onmouseout="this.style.backgroundColor='${bgColor}';">
                        <td style="padding: 1rem; color: #677C56; font-weight: 600;">${index + 1}</td>
                        <td style="padding: 1rem; color: #333; font-weight: 600;">${degree.name}</td>
                        <td style="padding: 1rem; color: #666;">${description}</td>
                        <td style="padding: 1rem; text-align: center;">
                            <button onclick="viewDegree(${degree.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #ABC28B, #90A854); color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; font-weight: 600;" title="View">
                                👁️ View
                            </button>
                            <button onclick="editDegree(${degree.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #90A854, #7a8f47); color: #fff; border: none; border-radius: 6px; cursor: pointer; margin-right: 0.5rem; font-weight: 600;" title="Edit">
                                ✏️ Edit
                            </button>
                            <button onclick="deleteDegree(${degree.id})" style="padding: 0.5rem 1rem; background: linear-gradient(135deg, #677C56, #556647); color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600;" title="Delete">
                                🗑️ Delete
                            </button>
                        </td>
                    </tr>
                `;
            });
        }
        
        $('#degreesTableBody').html(html);
    }
    
    // ========================================
    // SHARED HELPER FUNCTIONS
    // ========================================
    
    // Show centered modal alert
    window.showCenteredAlert = function(message, type) {
        type = type || 'success';
        const bgColor = type === 'success' ? '#f0f5eb' : '#fee2e2';
        const borderColor = type === 'success' ? '#ABC28B' : '#ef4444';
        const textColor = type === 'success' ? '#677C56' : '#7f1d1d';
        const icon = type === 'success' ? '✓' : '✕';
        
        // Remove existing alert if any
        $('#centeredAlertModal').remove();
        
        // Create modal HTML
        const modalHtml = `
            <div id="centeredAlertModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); display: flex; justify-content: center; align-items: center; z-index: 9999;">
                <div style="background: white; padding: 2rem; border-radius: 12px; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); max-width: 400px; width: 90%; text-align: center;">
                    <div style="width: 60px; height: 60px; margin: 0 auto 1rem; background: ${bgColor}; border: 3px solid ${borderColor}; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; color: ${borderColor}; font-weight: bold;">
                        ${icon}
                    </div>
                    <h3 style="margin: 0 0 0.5rem 0; color: ${textColor}; font-size: 1.5rem; font-weight: 600;">
                        ${type === 'success' ? 'Success!' : 'Error!'}
                    </h3>
                    <p style="margin: 0 0 1.5rem 0; color: #666; font-size: 1rem; line-height: 1.5;">
                        ${message}
                    </p>
                    <button onclick="$('#centeredAlertModal').fadeOut(300, function() { $(this).remove(); });" style="padding: 0.75rem 2rem; background: linear-gradient(135deg, ${borderColor}, ${borderColor}); color: white; border: none; border-radius: 8px; font-size: 1rem; font-weight: 600; cursor: pointer; transition: all 0.2s ease; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 12px rgba(0, 0, 0, 0.15)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(0, 0, 0, 0.1)';">
                        OK
                    </button>
                </div>
            </div>
        `;
        
        $('body').append(modalHtml);
        
        // Auto close after 3 seconds
        setTimeout(function() {
            $('#centeredAlertModal').fadeOut(300, function() {
                $(this).remove();
            });
        }, 3000);
    };
    
    // Show alert message (legacy support)
    window.showAlert = function(message, type) {
        showCenteredAlert(message, type);
    };
    
    // Close modals
    window.closeViewModal = function() {
        $('#viewModal').css('display', 'none');
    };
    
    window.closeEditModal = function() {
        $('#editModal').css('display', 'none');
        $('form').each(function() {
            if (this.id.includes('edit') || this.id.includes('Edit')) {
                this.reset();
            }
        });
    };
    
    window.closeDeleteModal = function() {
        $('#deleteModal').css('display', 'none');
        window.itemToDelete = null;
    };
    
    // Close modals when clicking outside
    $('#viewModal, #editModal, #deleteModal').click(function(e) {
        if (e.target === this) {
            $(this).css('display', 'none');
            if (this.id === 'deleteModal') {
                window.itemToDelete = null;
            }
        }
    });
});

// ========================================
// GLOBAL FUNCTIONS (Outside document.ready)
// ========================================

// STUDENTS
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

function editStudent(id) {
    $.get("/students/" + id, function(response) {
        const student = response.student;
        
        $('#edit_id').val(student.id);
        $('#edit_fname').val(student.fname);
        $('#edit_mname').val(student.mname || '');
        $('#edit_lname').val(student.lname);
        $('#edit_contact').val(student.contact);
        $('#edit_course_id').val(student.course_id);
        
        $('#editModal').css('display', 'flex');
    });
}

// Handle edit student form submission (MODAL VERSION)
$(document).on('submit', '#editStudentForm', function(e) {
    e.preventDefault();
    
    const studentId = $('#edit_id').val();
    const formData = {
        _method: 'PUT',
        first_name: $('#edit_fname').val(),
        middle_name: $('#edit_mname').val(),
        last_name: $('#edit_lname').val(),
        contact_no: $('#edit_contact').val(),
        course_id: $('#edit_course_id').val()
    };
    
    $.ajax({
        url: "/students/" + studentId,
        type: "POST",
        data: formData,
        success: function(response) {
            showCenteredAlert('Student updated successfully!', 'success');
            closeEditModal();
            if (typeof loadStudents === 'function') loadStudents();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = '';
                for (let field in errors) {
                    errorMsg += errors[field][0] + '\n';
                }
                showCenteredAlert(errorMsg, 'error');
            } else {
                showCenteredAlert('Failed to update student. Error code: ' + xhr.status, 'error');
            }
        }
    });
});

function deleteStudent(id) {
    window.studentToDelete = id;
    $('#deleteModal').css('display', 'flex');
}

$('#confirmDeleteBtn').click(function() {
    if (window.studentToDelete) {
        $.ajax({
            url: "/students/" + window.studentToDelete,
            type: "DELETE",
            success: function(response) {
                showAlert('Student deleted successfully!', 'success');
                closeDeleteModal();
                if (typeof loadStudents === 'function') loadStudents();
            },
            error: function(xhr) {
                showAlert('Error deleting student', 'error');
                closeDeleteModal();
            }
        });
    }
});

// TEACHERS
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

function editTeacher(id) {
    $.get("/teachers/" + id, function(response) {
        const teacher = response.teacher;
        
        $('#edit_id').val(teacher.id);
        $('#edit_fname').val(teacher.fname);
        $('#edit_mname').val(teacher.mname || '');
        $('#edit_lname').val(teacher.lname);
        $('#edit_email').val(teacher.email);
        $('#edit_contact').val(teacher.contact);
        
        $('#editModal').css('display', 'flex');
    });
}

// Handle edit teacher form submission (MODAL VERSION)
$(document).on('submit', '#editTeacherForm', function(e) {
    e.preventDefault();
    
    const teacherId = $('#edit_id').val();
    const formData = {
        _method: 'PUT',
        fname: $('#edit_fname').val(),
        mname: $('#edit_mname').val(),
        lname: $('#edit_lname').val(),
        email: $('#edit_email').val(),
        contact: $('#edit_contact').val()
    };
    
    $.ajax({
        url: "/teachers/" + teacherId,
        type: "POST",
        data: formData,
        success: function(response) {
            showCenteredAlert('Teacher updated successfully!', 'success');
            closeEditModal();
            if (typeof loadTeachers === 'function') loadTeachers();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = '';
                for (let field in errors) {
                    errorMsg += errors[field][0] + '\n';
                }
                showCenteredAlert(errorMsg, 'error');
            } else {
                showCenteredAlert('Failed to update teacher. Error code: ' + xhr.status, 'error');
            }
        }
    });
});

function deleteTeacher(id) {
    window.teacherToDelete = id;
    $('#deleteModal').css('display', 'flex');
}

$('#confirmDeleteBtn').click(function() {
    if (window.teacherToDelete) {
        $.ajax({
            url: "/teachers/" + window.teacherToDelete,
            type: "DELETE",
            success: function(response) {
                showAlert('Teacher deleted successfully!', 'success');
                closeDeleteModal();
                if (typeof loadTeachers === 'function') loadTeachers();
            },
            error: function(xhr) {
                showAlert('Error deleting teacher', 'error');
                closeDeleteModal();
            }
        });
    }
});

// DEGREES
function viewDegree(id) {
    $.get("/courses/" + id, function(response) {
        const degree = response.course;
        const createdDate = degree.created_at ? new Date(degree.created_at).toLocaleDateString('en-US', { year: 'numeric', month: 'long', day: 'numeric' }) : 'N/A';
        
        let html = `
            <div style="display: grid; gap: 1.5rem;">
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Degree Name</label>
                    <p style="margin: 0; color: #333; font-size: 1.125rem; font-weight: 600;">${degree.name}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Description</label>
                    <p style="margin: 0; color: #333; line-height: 1.6;">${degree.description}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Created Date</label>
                    <p style="margin: 0; color: #333;">${createdDate}</p>
                </div>
                <div>
                    <label style="display: block; color: #90A854; font-weight: 600; margin-bottom: 0.5rem;">Degree ID</label>
                    <p style="margin: 0; color: #333;">${degree.id}</p>
                </div>
            </div>
        `;
        
        $('#viewModalContent').html(html);
        $('#viewModal').css('display', 'flex');
    });
}

function editDegree(id) {
    $.get("/courses/" + id, function(response) {
        const degree = response.course;
        
        $('#edit_id').val(degree.id);
        $('#edit_name').val(degree.name);
        $('#edit_description').val(degree.description);
        
        $('#editModal').css('display', 'flex');
    });
}

// Handle edit degree form submission (MODAL VERSION)
$(document).on('submit', '#editDegreeForm', function(e) {
    e.preventDefault();
    
    const degreeId = $('#edit_id').val();
    const formData = {
        _method: 'PUT',
        name: $('#edit_name').val(),
        description: $('#edit_description').val()
    };
    
    $.ajax({
        url: "/courses/" + degreeId,
        type: "POST",
        data: formData,
        success: function(response) {
            showCenteredAlert('Degree updated successfully!', 'success');
            closeEditModal();
            if (typeof loadDegrees === 'function') loadDegrees();
        },
        error: function(xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorMsg = '';
                for (let field in errors) {
                    errorMsg += errors[field][0] + '\n';
                }
                showCenteredAlert(errorMsg, 'error');
            } else {
                showCenteredAlert('Failed to update degree. Error code: ' + xhr.status, 'error');
            }
        }
    });
});

function deleteDegree(id) {
    window.degreeToDelete = id;
    $('#deleteModal').css('display', 'flex');
}

$('#confirmDeleteBtn').click(function() {
    if (window.degreeToDelete) {
        $.ajax({
            url: "/courses/" + window.degreeToDelete,
            type: "DELETE",
            success: function(response) {
                showAlert('Degree deleted successfully!', 'success');
                closeDeleteModal();
                if (typeof loadDegrees === 'function') loadDegrees();
            },
            error: function(xhr) {
                showAlert('Error deleting degree', 'error');
                closeDeleteModal();
            }
        });
    }
});
