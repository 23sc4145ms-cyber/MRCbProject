# Testing Guide - Teacher Dashboard

## Quick Test Steps

### 1. Start the Application
```bash
php artisan serve
```
Visit: `http://127.0.0.1:8000`

---

## Test Scenarios

### Scenario 1: Login as Teacher
1. Go to login page
2. Use teacher credentials:
   - Username: `andy` or `divine`
   - Password: `teacher1234` (default)
3. Expected: Redirect to dashboard

### Scenario 2: View Teacher Dashboard
1. After login, should see teacher dashboard
2. Expected elements:
   - Welcome message with username
   - 4 navigation tabs
   - "Teacher Info" tab active by default

### Scenario 3: Test Teacher Info Tab
1. Click "📋 Teacher Info" tab
2. Expected to see:
   - First Name
   - Middle Name
   - Last Name
   - Email Address
   - Contact Number
   - Teacher ID (formatted as #000001)
   - Role: "👨‍🏫 Teacher"
   - Status: "✓ Active"
   - Yellow note: "If you need to update your information, please contact the administrator."

### Scenario 4: Test Posts Tab
1. Click "📝 Posts" tab
2. Expected:
   - If posts exist: List of posts with title, content, date
   - If no posts: "No posts available at the moment."

### Scenario 5: Test Profile Tab
1. Click "👤 Profile" tab
2. Expected:
   - If profiles exist: List of profiles with title, description, date
   - If no profiles: "No profiles available at the moment."

### Scenario 6: Test Change Password Tab
1. Click "🔒 Change Password" tab
2. Fill in form:
   - Current Password: `teacher1234`
   - New Password: `newpass123`
   - Confirm New Password: `newpass123`
3. Click "Update Password"
4. Expected: Success message "Password changed successfully!"

### Scenario 7: Test Password Validation
1. Go to Change Password tab
2. Test wrong current password:
   - Current Password: `wrongpass`
   - New Password: `newpass123`
   - Confirm New Password: `newpass123`
   - Expected: Error "The current password is incorrect."

3. Test password mismatch:
   - Current Password: `teacher1234`
   - New Password: `newpass123`
   - Confirm New Password: `different123`
   - Expected: Error "New passwords do not match."

4. Test short password:
   - Current Password: `teacher1234`
   - New Password: `short`
   - Confirm New Password: `short`
   - Expected: Error "New password must be at least 8 characters."

5. Test same password:
   - Current Password: `teacher1234`
   - New Password: `teacher1234`
   - Confirm New Password: `teacher1234`
   - Expected: Error "New password must be different from the current password."

### Scenario 8: Test Navigation Menu (Teacher View)
1. Check top navigation menu
2. Expected to see:
   - DASHBOARD
   - STUDENTS
   - TEACHERS
   - COURSES
   - PROFILES
   - POSTS
   - LOGOUT

### Scenario 9: Test Responsive Design
1. Resize browser window to mobile size
2. Expected:
   - Tabs stack properly
   - Info grid becomes single column
   - All content remains readable

### Scenario 10: Test Logout
1. Click "LOGOUT" in navigation
2. Expected: Redirect to login page

---

## Database Verification

### Check Teacher Records
```sql
SELECT * FROM teachers;
```
Expected: 2 teachers (andy, divine)

### Check User Accounts
```sql
SELECT * FROM user_accounts WHERE role = 'teacher';
```
Expected: 2 teacher accounts

### Check Password Hashing
```sql
SELECT id, username, password FROM user_accounts WHERE role = 'teacher';
```
Expected: Passwords start with `$argon2id$`

---

## Common Issues & Solutions

### Issue 1: Teacher info not showing
**Symptom**: "No teacher information found" message
**Solution**: 
```sql
-- Check if teacher has user_id
SELECT * FROM teachers WHERE user_id IS NULL;

-- Fix if needed
UPDATE teachers SET user_id = (SELECT id FROM user_accounts WHERE email = teachers.email) WHERE user_id IS NULL;
```

### Issue 2: Password change fails
**Symptom**: "This password does not use the Argon2id algorithm"
**Solution**: Reset passwords to Argon2id
```bash
php reset_passwords_to_argon2id.php
```

### Issue 3: Route not found
**Symptom**: 404 error on password update
**Solution**:
```bash
php artisan route:clear
php artisan route:cache
```

### Issue 4: Session issues
**Symptom**: Logged out unexpectedly
**Solution**: Check session configuration in `config/session.php`

---

## Success Criteria

✅ Teacher can login successfully
✅ Dashboard displays with 4 tabs
✅ Teacher info shows correctly (read-only)
✅ Posts tab displays posts
✅ Profile tab displays profiles
✅ Password change works correctly
✅ Form validation works
✅ Error messages display properly
✅ Success messages display properly
✅ Navigation menu shows correct items
✅ Responsive design works on mobile
✅ Logout works correctly

---

## Performance Checks

1. **Page Load Time**: Should load in < 2 seconds
2. **Tab Switching**: Should be instant (JavaScript)
3. **Form Submission**: Should respond in < 1 second
4. **Database Queries**: Check for N+1 queries

---

## Security Checks

1. **Password Hashing**: Verify Argon2id is used
2. **Session Security**: Check session timeout
3. **CSRF Protection**: Verify CSRF tokens on forms
4. **SQL Injection**: Test with special characters
5. **XSS Protection**: Test with script tags in inputs

---

## Browser Compatibility

Test on:
- ✅ Chrome/Edge (latest)
- ✅ Firefox (latest)
- ✅ Safari (latest)
- ✅ Mobile browsers

---

## Final Checklist

Before marking as complete:
- [ ] All 10 test scenarios pass
- [ ] Database records are correct
- [ ] No console errors
- [ ] No PHP errors
- [ ] Responsive design works
- [ ] All validation works
- [ ] Security checks pass
- [ ] Documentation is complete

---

**Testing Date**: May 11, 2026
**Tester**: [Your Name]
**Status**: Ready for Testing
