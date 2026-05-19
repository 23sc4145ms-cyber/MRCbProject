-- Cleanup orphaned user accounts and prepare for fresh start
USE mrclaravelDb;

-- Show current orphaned accounts
SELECT 'ORPHANED USER ACCOUNTS (will be deleted):' as Info;
SELECT id, username, email, role 
FROM user_accounts 
WHERE role IN ('student', 'teacher') 
AND id NOT IN (SELECT user_id FROM students WHERE user_id IS NOT NULL)
AND id NOT IN (SELECT user_id FROM teachers WHERE user_id IS NOT NULL);

-- Delete orphaned first_login_tokens
DELETE FROM first_login_tokens 
WHERE user_id IN (
    SELECT id FROM user_accounts 
    WHERE role IN ('student', 'teacher') 
    AND id NOT IN (SELECT user_id FROM students WHERE user_id IS NOT NULL)
    AND id NOT IN (SELECT user_id FROM teachers WHERE user_id IS NOT NULL)
);

-- Delete orphaned user_accounts
DELETE FROM user_accounts 
WHERE role IN ('student', 'teacher') 
AND id NOT IN (SELECT user_id FROM students WHERE user_id IS NOT NULL)
AND id NOT IN (SELECT user_id FROM teachers WHERE user_id IS NOT NULL);

SELECT 'CLEANUP COMPLETED!' as Status;
SELECT 'Now you can add students and teachers again through the web interface.' as Message;
