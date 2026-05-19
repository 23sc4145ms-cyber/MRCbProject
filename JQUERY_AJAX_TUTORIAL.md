# jQuery AJAX Complete Tutorial - Students CRUD

## ✅ What is jQuery?

jQuery is a fast and simple JavaScript library that helps you:
- Select HTML elements
- Handle events  
- Create animations/effects
- Perform AJAX requests easily

Instead of writing long JavaScript code, jQuery simplifies it.

### General Syntax
```javascript
$(selector).action();
```

**Meaning:**
- `$` - jQuery function
- `selector` - HTML element to target
- `action()` - what you want to do

**Example:**
```javascript
$("#title").hide();  // Hides element with id="title"
```

## 📦 Setup

### 1. Include jQuery in Layout
Already included in `resources/views/format/layout.blade.php`:
```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

### 2. Add CSRF Token Meta Tag
Already in layout:
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

### 3. Create External JS File
Created: `public/js/students.js`

### 4. Include in Blade
```html
<script src="{{ asset('js/students.js') }}"></script>
```

## 🎯 Complete CRUD Implementation

### File Structure
```
app/Http/Controllers/StudentController.php  (Backend)
resources/views/students/index.blade.php    (Frontend HTML)
public/js/students.js                       (Frontend jQuery/AJAX)
```

## 📖 READ - Load Students

### Backend (Controller)
```php
public function index()
{
    $students = Student::with(['course', 'user'])->get();
    
    // Return JSON for AJAX requests
    if (request()->wantsJson() || request()->ajax()) {
        return response()->json(['students' => $students]);
    }
    
    // Return view for normal requests
    return view('students.index', compact('students'));
}
```

### Frontend (jQuery)
```javascript
// Load students when page loads
$(document).ready(function() {
    loadStudents();
    
    // Setup CSRF token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
});

// AJAX GET request
function loadStudents() {
    $.get("/students", function(data) {
        renderStudentsTable(data.students);
    });
}

// Render table
function renderStudentsTable(students) {
    let html = '';
    students.forEach(function(student, index) {
        html += `<tr>
            <td>${index + 1}</td>
            <td>${student.fname} ${student.lname}</td>
            <td>${student.user.email}</td>
            <td>
                <button onclick="viewStudent(${student.id})">View</button>
                <button onclick="editStudent(${student.id})">Edit</button>
                <button onclick="deleteStudent(${student.id})">Delete</button>
            </td>
        </tr>`;
    });
    $('#studentsTableBody').html(html);
}
```

## 👁️ VIEW - Show Student Details

### Backend (Controller)
```php
public function show($id)
{
    $student = Student::with(['course', 'user'])->find($id);
    
    if (request()->ajax()) {
        return response()->json(['student' => $student]);
    }
    
    return view('studentlayout.show', compact('student'));
}
```

### Frontend (jQuery)
```javascript
function viewStudent(id) {
    $.get("/students/" + id, function(response) {
        const student = response.student;
        
        // Build HTML
        let html = `
            <div>
                <label>Full Name</label>
                <p>${student.fname} ${student.lname}</p>
            </div>
            <div>
                <label>Email</label>
                <p>${student.user.email}</p>
            </div>
        `;
        
        // Show in modal
        $('#viewModalContent').html(html);
        $('#viewModal').css('display', 'flex');
    });
}

function closeViewModal() {
    $('#viewModal').css('display', 'none');
}
```

## ✏️ UPDATE - Edit Student

### Backend (Controller)
```php
public function update(Request $request, $id)
{
    $request->validate([
        'fname' => 'required|string|min:2',
        'lname' => 'required|string|min:2',
        'contact' => 'required|digits:11',
        'course_id' => 'required|exists:courses,id',
    ]);

    $student = Student::find($id);
    $student->update([
        'fname' => $request->fname,
        'mname' => $request->mname,
        'lname' => $request->lname,
        'contact' => $request->contact,
        'course_id' => $request->course_id,
    ]);

    // Return JSON for AJAX
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Student updated successfully.',
            'student' => $student->load(['course', 'user'])
        ]);
    }

    return redirect()->route('students.show', $student->id);
}
```

### Frontend (jQuery)
```javascript
// Show edit form
function editStudent(id) {
    $.get("/students/" + id, function(response) {
        const student = response.student;
        
        // Populate form
        $('#edit_id').val(student.id);
        $('#edit_fname').val(student.fname);
        $('#edit_mname').val(student.mname);
        $('#edit_lname').val(student.lname);
        $('#edit_contact').val(student.contact);
        $('#edit_course_id').val(student.course_id);
        
        // Show modal
        $('#editModal').css('display', 'flex');
    });
}

// Submit edit form
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
```

## 🗑️ DELETE - Remove Student

### Backend (Controller)
```php
public function destroy($id)
{
    $student = Student::find($id);
    
    if ($student) {
        // Delete associated records
        if ($student->user_id) {
            \App\Models\FirstLoginToken::where('user_id', $student->user_id)->delete();
            \App\Models\UserAccount::where('id', $student->user_id)->delete();
        }
        
        $student->delete();
        
        // Return JSON for AJAX
        if (request()->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Student deleted successfully.'
            ]);
        }
    }
    
    return redirect()->route('students.index');
}
```

### Frontend (jQuery)
```javascript
function deleteStudent(id) {
    if (!confirm('Are you sure you want to delete this student?')) {
        return;
    }
    
    $.ajax({
        url: "/students/" + id,
        type: "DELETE",
        success: function(response) {
            showAlert('Student deleted successfully!', 'success');
            loadStudents(); // Reload table
        },
        error: function(xhr) {
            showAlert('Error deleting student', 'error');
        }
    });
}
```

## 🎨 Helper Functions

### Show Alert Messages
```javascript
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
```

## 🔑 Key Points

### 1. CSRF Token Setup
```javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

### 2. Prevent Default Form Submission
```javascript
$('#myForm').submit(function(e) {
    e.preventDefault(); // Important!
    // Your AJAX code here
});
```

### 3. Check for AJAX in Controller
```php
if (request()->ajax() || request()->wantsJson()) {
    return response()->json(['data' => $data]);
}
```

### 4. Return JSON, Not Redirect
```php
// ❌ Wrong for AJAX
return redirect('/students');

// ✅ Correct for AJAX
return response()->json(['success' => true]);
```

### 5. Handle Errors
```javascript
$.ajax({
    // ...
    error: function(xhr) {
        console.log(xhr.responseJSON);
        // Show error message
    }
});
```

## 📊 Benefits of AJAX

✅ **No Page Reload** - Faster, smoother experience
✅ **Better UX** - Modal popups instead of navigation
✅ **Real-time Updates** - Table refreshes automatically
✅ **Less Server Load** - Only data is transferred
✅ **Modern Feel** - Like a single-page application

## 🚀 Testing

1. Go to `/students` page
2. Click "👁️ View" - Modal opens with details
3. Click "✏️ Edit" - Edit form opens in modal
4. Update and submit - Table refreshes automatically
5. Click "🗑️ Delete" - Confirms and deletes without reload

## 📝 Summary

**Files Created/Modified:**
- ✅ `public/js/students.js` - jQuery/AJAX logic
- ✅ `resources/views/students/index.blade.php` - HTML with modals
- ✅ `app/Http/Controllers/StudentController.php` - JSON responses

**Features:**
- ✅ Load students via AJAX
- ✅ View student in modal
- ✅ Edit student in modal
- ✅ Delete student with confirmation
- ✅ Auto-refresh table
- ✅ Success/error alerts

Tapos na! 🎉 Full CRUD with jQuery/AJAX, no page reload!
