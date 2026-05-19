# 📋 Paano Mag-add ng Student at Teacher

## ✅ FIXED NA! Ready na mag-add!

Ang problema kanina ay nag-create ng user accounts pero nag-fail yung pag-create ng student/teacher records dahil sa foreign key error. Na-fix na natin yun at na-clean na rin yung orphaned accounts.

---

## 🎯 Paano Mag-add ng Student

### Step 1: I-start ang Laravel server
```bash
php artisan serve
```

### Step 2: Pumunta sa Add Student page
```
http://127.0.0.1:8000/students/create
```

### Step 3: Fill-up ang form
- **First Name**: (halimbawa: Juan)
- **Middle Name**: (halimbawa: Dela)
- **Last Name**: (halimbawa: Cruz)
- **Contact**: (11 digits, halimbawa: 09123456789)
- **Course**: (Piliin: BSIT o BSHM)
- **Email**: (halimbawa: juan@gmail.com)

### Step 4: Click "Add Student"

### ✅ Automatic na gagawin:
1. Mag-create ng user account sa `user_accounts` table
2. Mag-create ng student record sa `students` table
3. Mag-create ng first login token
4. Default password: **student1234**

---

## 🎯 Paano Mag-add ng Teacher

### Step 1: Pumunta sa Add Teacher page
```
http://127.0.0.1:8000/teachers/create
```

### Step 2: Fill-up ang form
- **First Name**: (halimbawa: Maria)
- **Middle Name**: (halimbawa: Santos)
- **Last Name**: (halimbawa: Reyes)
- **Email**: (halimbawa: maria@gmail.com)
- **Contact**: (11 digits, halimbawa: 09987654321)

### Step 3: Click "Add Teacher"

### ✅ Automatic na gagawin:
1. Mag-create ng user account sa `user_accounts` table
2. Mag-create ng teacher record sa `teachers` table
3. Mag-create ng first login token
4. Default password: **teacher1234**

---

## 📊 Paano Makita ang Students at Teachers

### Sa Students List
```
http://127.0.0.1:8000/students
```
Makikita mo dito lahat ng students na na-add mo.

### Sa Teachers List
```
http://127.0.0.1:8000/teachers
```
Makikita mo dito lahat ng teachers na na-add mo.

### Sa Dashboard
```
http://127.0.0.1:8000/dashboard
```
Makikita mo dito ang:
- **Total Students** - bilang ng lahat ng students
- **Total Teachers** - bilang ng lahat ng teachers
- **Total Courses** - bilang ng lahat ng courses (BSIT, BSHM)

---

## 🔍 Paano I-check sa Database

### Check Students
```sql
SELECT s.id, s.fname, s.lname, c.name as course, u.email 
FROM students s 
LEFT JOIN courses c ON s.course_id = c.id 
LEFT JOIN user_accounts u ON s.user_id = u.id;
```

### Check Teachers
```sql
SELECT t.id, t.fname, t.lname, u.email 
FROM teachers t 
LEFT JOIN user_accounts u ON t.user_id = u.id;
```

### Check Dashboard Counts
```sql
SELECT 
    (SELECT COUNT(*) FROM students) as total_students,
    (SELECT COUNT(*) FROM teachers) as total_teachers,
    (SELECT COUNT(*) FROM courses) as total_courses;
```

---

## ⚠️ Importante!

### Default Passwords
- **Students**: `student1234`
- **Teachers**: `teacher1234`

### First Login
Pag nag-login ang student o teacher for the first time, **kailangan nila i-change ang password**.

### Courses Available
1. **BSIT** - Bachelor of Science in Information Technology
2. **BSHM** - Bachelor of Science in Hospitality Management

---

## 🎉 Ready na!

Ngayon pwede ka na mag-add ng:
- ✅ Students (with course assignment)
- ✅ Teachers
- ✅ Makikita sa list pages
- ✅ Makikita sa dashboard yung total counts
- ✅ May AJAX delete functionality
- ✅ May first-time password change

**Subukan mo na mag-add ng student at teacher!** 🚀

---

## 📞 Kung may problema pa

1. Check kung naka-start ang Laravel server: `php artisan serve`
2. Check kung naka-start ang MySQL sa XAMPP
3. Check kung tama ang database name: `mrclaravelDb`
4. Run ang test script: `php test_student_creation.php`

**Lahat ng foreign keys ay tama na at working!** ✅
