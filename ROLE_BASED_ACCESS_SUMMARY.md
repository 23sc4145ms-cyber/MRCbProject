# Role-Based Access Control Implementation

## Overview
The system now has three distinct user roles with different access levels:
1. **Admin** - Full system control
2. **Teacher** - Limited access (posts and profiles only)
3. **Student** - View-only access to their dashboard

## User Accounts Created

### Admin Account
- **Email**: admin@psu.edu.ph
- **Password**: admin1234
- **Access**: Full system control

### Teacher Account
- **Email**: teacher@psu.edu.ph
- **Password**: teacher1234
- **Access**: Posts and Profiles management only

## Access Control Summary

### Admin Can:
✅ Add/Edit/Delete Users (students, teachers, other admins)
✅ Manage Students
✅ Manage Courses
✅ Manage Course Students
✅ Manage Degrees
✅ Manage Posts
✅ Manage Profiles
✅ Access all system features

**Dashboard**: `/dashboard/admin`

### Teacher Can:
✅ View Posts (Create/Edit/Delete)
✅ View Profiles (Create/Edit/Delete)
✅ Access Home and About pages
❌ Cannot manage Users
❌ Cannot manage Students
❌ Cannot manage Courses
❌ Cannot manage Degrees

**Dashboard**: `/dashboard/teacher`

### Student Can:
✅ View their own dashboard
✅ Change their password
❌ Cannot access any management features
❌ Cannot view other students' information
❌ Cannot manage courses or posts

**Dashboard**: `/dashboard/student`

## Middleware Implementation

### 1. SessionCheck Middleware
- Ensures user is logged in
- Redirects to login if not authenticated

### 2. ForcePasswordChange Middleware
- Forces first-time users to change default password
- Restricts students to their dashboard only
- Allows teachers and admins full access after password change

### 3. AdminOnly Middleware
- Protects admin-only routes
- Returns 403 error if non-admin tries to access

## Protected Routes

### Admin-Only Routes (require admin.only middleware):
- `/users` - User management
- `/students` - Student management
- `/degrees` - Degree management
- `/courses` - Course management
- `/course_students` - Course-Student relationships

### Shared Routes (Admin & Teacher):
- `/home` - Home page
- `/about` - About page
- `/posts` - Posts management
- `/profiles` - Profile management
- `/greetings`, `/clientProfile`, `/clientDashboard`, `/clientAboutUs`

### Student-Only Routes:
- `/dashboard/student` - Student dashboard
- `/user-page` - Password change page

## Login Flow

1. User logs in at `/login`
2. System checks if first-time login (needs password change)
   - If yes → Redirect to `/user-page` with welcome message
   - If no → Redirect to role-specific dashboard
3. After password change:
   - **Admin** → `/dashboard/admin`
   - **Teacher** → `/dashboard/teacher`
   - **Student** → `/dashboard/student`

## First-Time Login

All new users created by admin get:
- Default password: `user12345`
- Must change password on first login
- Welcome message: "Welcome [username]!"

## Database Structure

### user_accounts table
- id
- username
- email
- password
- role (admin, teacher, student)
- is_active
- created_at
- updated_at

### first_login_tokens table
- id
- user_id
- used (boolean)
- created_at
- updated_at

## Testing the System

1. **Test Admin Access**:
   - Login: admin@psu.edu.ph / admin1234
   - Should see admin dashboard with all management options
   - Try accessing `/users`, `/students`, `/courses` - should work

2. **Test Teacher Access**:
   - Login: teacher@psu.edu.ph / teacher1234
   - Should see teacher dashboard
   - Try accessing `/posts`, `/profiles` - should work
   - Try accessing `/users`, `/students`, `/courses` - should get 403 error

3. **Test Student Access**:
   - Create a student via admin panel
   - Login with student credentials (default: user12345)
   - Should be forced to change password
   - After password change, should only see student dashboard
   - Try accessing any other route - should redirect back to student dashboard

## Files Modified

1. `app/Http/Controllers/UserController.php` - Updated role validation
2. `app/Http/Middleware/ForcePasswordChange.php` - Added student dashboard access
3. `app/Http/Middleware/AdminOnly.php` - Created new middleware
4. `app/Http/Controllers/AuthController.php` - Role-based redirect after login
5. `routes/web.php` - Added dashboard routes and admin-only protection
6. `database/seeders/UserSeeder.php` - Added admin account
7. `resources/views/dashboards/admin.blade.php` - Created admin dashboard
8. `resources/views/dashboards/teacher.blade.php` - Created teacher dashboard
9. `resources/views/dashboards/student.blade.php` - Created student dashboard
10. `resources/views/user/create.blade.php` - Updated role dropdown
11. `resources/views/user/edit.blade.php` - Updated role dropdown
12. `resources/views/user/index.blade.php` - Fixed posts count error

## Security Features

✅ Session-based authentication
✅ Password hashing with bcrypt
✅ Role-based access control
✅ Middleware protection on routes
✅ First-time password change enforcement
✅ 403 errors for unauthorized access
✅ Logout functionality clears all session data
