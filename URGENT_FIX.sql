-- URGENT FIX FOR STUDENTS TABLE
-- Copy and paste this ENTIRE script into your MySQL command line or phpMyAdmin

USE mrclaravelDb;

-- Disable foreign key checks temporarily
SET FOREIGN_KEY_CHECKS=0;

-- Drop the problematic foreign key
ALTER TABLE `students` DROP FOREIGN KEY `students_user_id_foreign`;

-- Add the correct foreign key pointing to user_accounts
ALTER TABLE `students` 
ADD CONSTRAINT `students_user_id_foreign` 
FOREIGN KEY (`user_id`) 
REFERENCES `user_accounts` (`id`) 
ON DELETE CASCADE;

-- Re-enable foreign key checks
SET FOREIGN_KEY_CHECKS=1;

-- Verify the fix
SELECT 
    CONSTRAINT_NAME,
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE
WHERE 
    TABLE_NAME = 'students' 
    AND CONSTRAINT_NAME = 'students_user_id_foreign';
