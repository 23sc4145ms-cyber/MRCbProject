// Degrees CRUD with jQuery AJAX

$(document).ready(function() {
    // Load degrees when page loads
    loadDegrees();
    
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// READ - Load all degrees
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

// VIEW - Show degree details in modal
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

// EDIT - Show edit form in modal
function editDegree(id) {
    $.get("/courses/" + id, function(response) {
        const degree = response.course;
        
        // Populate edit form
        $('#edit_id').val(degree.id);
        $('#edit_name').val(degree.name);
        $('#edit_description').val(degree.description);
        
        // Show edit modal
        $('#editModal').css('display', 'flex');
    });
}

// UPDATE - Submit edit form via AJAX
$('#editDegreeForm').submit(function(e) {
    e.preventDefault();
    
    let id = $('#edit_id').val();
    let formData = {
        name: $('#edit_name').val(),
        description: $('#edit_description').val()
    };
    
    $.ajax({
        url: "/courses/" + id,
        type: "PUT",
        data: formData,
        success: function(response) {
            showAlert('Degree updated successfully!', 'success');
            closeEditModal();
            loadDegrees();
        },
        error: function(xhr) {
            let errors = xhr.responseJSON.errors;
            let errorMsg = 'Error updating degree:\n';
            for (let key in errors) {
                errorMsg += errors[key][0] + '\n';
            }
            showAlert(errorMsg, 'error');
        }
    });
});

// DELETE - Delete degree
let degreeToDelete = null;

function deleteDegree(id) {
    degreeToDelete = id;
    $('#deleteModal').css('display', 'flex');
}

function closeDeleteModal() {
    $('#deleteModal').css('display', 'none');
    degreeToDelete = null;
}

$('#confirmDeleteBtn').click(function() {
    if (degreeToDelete) {
        $.ajax({
            url: "/courses/" + degreeToDelete,
            type: "DELETE",
            success: function(response) {
                showAlert('Degree deleted successfully!', 'success');
                closeDeleteModal();
                loadDegrees();
            },
            error: function(xhr) {
                showAlert('Error deleting degree', 'error');
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
    $('#editDegreeForm')[0].reset();
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
            degreeToDelete = null;
        }
    }
});
