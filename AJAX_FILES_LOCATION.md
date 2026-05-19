# AJAX/jQuery Files Location Guide

## 📂 COMPLETE FILE STRUCTURE

```
MRCbProject/
│
├── app/Http/Controllers/
│   ├── StudentController.php      ← AJAX: Lines 17-27, 95-97, 110-125, 165-172, 195-200
│   ├── TeacherController.php      ← AJAX: Lines 13-24, 88-98, 139-146, 162-169
│   └── CourseController.php       ← AJAX: Lines 14-24, 55-65, 89-96, 110-117
│
├── resources/views/
│   ├── students/
│   │   └── index.blade.php        ← Students table + modals + loads students.js
│   ├── teacher/
│   │   └── index.blade.php        ← Teachers table + modals + loads teachers.js
│   └── course/
│       └── index.blade.php        ← Degrees table + modals + loads degrees.js
│
└── public/js/
    ├── app.js                     ← Global CSRF setup for AJAX
    ├── students.js                ← Students CRUD operations
    ├── teachers.js                ← Teachers CRUD operations
    └── degrees.js                 ← Degrees CRUD operations
```

---

## 1️⃣ VIEWS (Blade Files)

### **Students View**
**File:** `resources/views/students/index.blade.php`

**Contains:**
- Students table (4 columns: #, Name, Email, Actions)
- View Modal (shows all student details)
- Edit Modal (form to edit student)
- Delete Modal (confirmation dialog)
- Script tag loading: `<script src="{{ asset('js/students.js') }}"></script>`

**Key Lines:**
- Line ~1-10: Header and title
- Line ~20-35: Students table structure
- Line ~40-60: View Modal
- Line ~65-85: Delete Modal
- Line ~90-120: Edit Modal
- Line ~125: Script tag for students.js

---

### **Teachers View**
**File:** `resources/views/teacher/index.blade.php`

**Contains:**
- Teachers table (4 columns: #, Name, Email, Actions)
- View Modal (shows all teacher details)
- Edit Modal (form to edit teacher)
- Delete Modal (confirmation dialog)
- Script tag loading: `<script src="{{ asset('js/teachers.js') }}"></script>`

**Key Lines:**
- Line ~1-10: Header and title
- Line ~20-35: Teachers table structure
- Line ~40-60: View Modal
- Line ~65-85: Delete Modal
- Line ~90-130: Edit Modal
- Line ~135: Script tag for teachers.js

---

### **Degrees View**
**File:** `resources/views/course/index.blade.php`

**Contains:**
- Degrees table (4 columns: #, Degree Name, Description, Actions)
- View Modal (shows all degree details)
- Edit Modal (form to edit degree)
- Delete Modal (confirmation dialog)
- Script tag loading: `<script src="{{ asset('js/degrees.js') }}"></script>`

**Key Lines:**
- Line ~1-10: Header and title
- Line ~20-35: Degrees table structure
- Line ~40-60: View Modal
- Line ~65-85: Delete Modal
- Line ~90-120: Edit Modal
- Line ~125: Script tag for degrees.js

---

## 2️⃣ JAVASCRIPT FILES

### **App.js (Global Setup)**
**File:** `public/js/app.js`

**Contains:**
```javascript
$(document).ready(function() {
    // Setup CSRF token for all AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    console.log('jQuery loaded successfully!');
});
```

**Purpose:** 
- Sets up CSRF token for ALL AJAX requests globally
- Loaded in layout.blade.php (line ~280)

---

### **Students.js**
**File:** `public/js/students.js`

**Functions:**
1. **loadStudents()** - Line ~15-20
   - Fetches all students via AJAX GET
   - Calls renderStudentsTable()

2. **renderStudentsTable(students)** - Line ~23-60
   - Renders table rows dynamically
   - Shows: #, Name, Email, Actions buttons

3. **viewStudent(id)** - Line ~63-95
   - Fetches single student via AJAX GET
   - Shows View Modal with all details

4. **editStudent(id)** - Line ~98-115
   - Fetches student data via AJAX GET
   - Populates Edit Modal form

5. **updateStudent()** - Line ~118-140
   - Submits edit form via AJAX PUT
   - Shows success/error message

6. **deleteStudent(id)** - Line ~143-165
   - Shows Delete Modal
   - Confirms deletion via AJAX DELETE

7. **Helper Functions:**
   - closeViewModal() - Line ~168
   - closeEditModal() - Line ~172
   - closeDeleteModal() - Line ~176
   - showAlert() - Line ~180-195

**Total Lines:** ~230 lines

---

### **Teachers.js**
**File:** `public/js/teachers.js`

**Functions:**
1. **loadTeachers()** - Line ~15-20
2. **renderTeachersTable(teachers)** - Line ~23-60
3. **viewTeacher(id)** - Line ~63-95
4. **editTeacher(id)** - Line ~98-115
5. **updateTeacher()** - Line ~118-140
6. **deleteTeacher(id)** - Line ~143-165
7. **Helper Functions** - Line ~168-195

**Total Lines:** ~230 lines

---

### **Degrees.js**
**File:** `public/js/degrees.js`

**Functions:**
1. **loadDegrees()** - Line ~15-20
2. **renderDegreesTable(degrees)** - Line ~23-60
3. **viewDegree(id)** - Line ~63-95
4. **editDegree(id)** - Line ~98-115
5. **updateDegree()** - Line ~118-140
6. **deleteDegree(id)** - Line ~143-165
7. **Helper Functions** - Line ~168-195

**Total Lines:** ~220 lines

---

## 3️⃣ CONTROLLERS (Backend)

### **StudentController.php**
**File:** `app/Http/Controllers/StudentController.php`

**AJAX Implementation Lines:**

#### **index() - Lines 17-27**
```php
// Check if request wants JSON (AJAX request)
if (request()->wantsJson() || request()->ajax()) {
    return response()->json([
        'students' => $students
    ]);
}
```
**Purpose:** Returns all students as JSON for table

---

#### **show($id) - Lines 110-125**
```php
// Check if request wants JSON (AJAX request)
if (request()->wantsJson() || request()->ajax()) {
    return response()->json([
        'student' => $student
    ]);
}
```
**Purpose:** Returns single student as JSON for View Modal

---

#### **store($id) - Lines 95-97**
```php
// Check if AJAX request
if ($request->ajax()) {
    return response()->json([
        'success' => true,
        'message' => 'Student added successfully.',
        'student' => $student
    ]);
}
```
**Purpose:** Returns success JSON after creating student

---

#### **update($id) - Lines 165-172**
```php
// Check if AJAX request
if ($request->ajax()) {
    return response()->json([
        'success' => true,
        'message' => 'Student updated successfully.',
        'student' => $student->load(['course', 'user'])
    ]);
}
```
**Purpose:** Returns success JSON after updating student

---

#### **destroy($id) - Lines 195-200**
```php
// Check if AJAX request
if (request()->ajax()) {
    return response()->json([
        'success' => true,
        'message' => 'Student deleted successfully.'
    ]);
}
```
**Purpose:** Returns success JSON after deleting student

---

### **TeacherController.php**
**File:** `app/Http/Controllers/TeacherController.php`

**AJAX Implementation Lines:**
- **index()** - Lines 13-24 (returns all teachers)
- **show($id)** - Lines 88-98 (returns single teacher)
- **update($id)** - Lines 139-146 (returns success after update)
- **destroy($id)** - Lines 162-169 (returns success after delete)

---

### **CourseController.php**
**File:** `app/Http/Controllers/CourseController.php`

**AJAX Implementation Lines:**
- **index()** - Lines 14-24 (returns all degrees)
- **show($id)** - Lines 55-65 (returns single degree)
- **update($id)** - Lines 89-96 (returns success after update)
- **destroy($id)** - Lines 110-117 (returns success after delete)

---

## 4️⃣ LAYOUT FILE

### **Layout.blade.php**
**File:** `resources/views/format/layout.blade.php`

**Key Lines:**
- **Line ~5-10:** jQuery CDN script
- **Line ~15:** CSRF meta tag
- **Line ~244-258:** Logout Modal
- **Line ~268-285:** Logout JavaScript functions
- **Line ~290:** Loads app.js

**jQuery CDN:**
```html
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
```

**CSRF Meta Tag:**
```html
<meta name="csrf-token" content="{{ csrf_token() }}">
```

**App.js Load:**
```html
<script src="{{ asset('js/app.js') }}"></script>
```

---

## 📊 AJAX FLOW DIAGRAM

```
USER ACTION (Click View/Edit/Delete)
    ↓
JAVASCRIPT FUNCTION (students.js/teachers.js/degrees.js)
    ↓
AJAX REQUEST ($.get() or $.ajax())
    ↓
CONTROLLER METHOD (StudentController/TeacherController/CourseController)
    ↓
CHECK IF AJAX (request()->ajax())
    ↓
RETURN JSON RESPONSE
    ↓
JAVASCRIPT SUCCESS CALLBACK
    ↓
UPDATE UI (Show modal, reload table, show alert)
```

---

## 🔑 KEY CONCEPTS

### **1. CSRF Token Setup**
**Location:** `public/js/app.js` (Lines 2-8)
```javascript
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
```

### **2. AJAX Request Check**
**Location:** All Controllers
```php
if (request()->ajax() || request()->wantsJson()) {
    return response()->json([...]);
}
```

### **3. jQuery AJAX Calls**
**Location:** All JS files
```javascript
// GET request
$.get("/students", function(data) { ... });

// PUT request
$.ajax({
    url: "/students/" + id,
    type: "PUT",
    data: formData,
    success: function(response) { ... }
});

// DELETE request
$.ajax({
    url: "/students/" + id,
    type: "DELETE",
    success: function(response) { ... }
});
```

---

## 📝 SUMMARY

### **Total Files Affected: 10**

**Views (3):**
1. resources/views/students/index.blade.php
2. resources/views/teacher/index.blade.php
3. resources/views/course/index.blade.php

**JavaScript (4):**
1. public/js/app.js (CSRF setup)
2. public/js/students.js (Students CRUD)
3. public/js/teachers.js (Teachers CRUD)
4. public/js/degrees.js (Degrees CRUD)

**Controllers (3):**
1. app/Http/Controllers/StudentController.php
2. app/Http/Controllers/TeacherController.php
3. app/Http/Controllers/CourseController.php

**Layout (1):**
1. resources/views/format/layout.blade.php (jQuery CDN + app.js)

---

## ✅ FEATURES IMPLEMENTED

- ✅ No page reload on CRUD operations
- ✅ Centered modals for View/Edit/Delete
- ✅ Green theme throughout (#ABC28B, #90A854, #677C56)
- ✅ Success/error alerts with auto-hide
- ✅ CSRF protection on all AJAX requests
- ✅ Consistent code structure across all modules
- ✅ Hidden columns (Contact, Degree, Created Date)
- ✅ Logout confirmation modal
