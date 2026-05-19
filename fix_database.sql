-- Fix Database Script for Students Table
-- Run this in your MySQL database (mrclaravelDb)

USE mrclaravelDb;

-- Step 1: Drop existing foreign key constraints on students table
ALTER TABLE `students` DROP FOREIGN KEY `students_user_id_foreign`;
ALTER TABLE `students` DROP FOREIGN KEY `students_degree_id_foreign`;

-- Step 2: Check if course_id column exists, if not add it
-- If degree_id exists, rename it to course_id
ALTER TABLE `students` CHANGE COLUMN `degree_id` `course_id` BIGINT UNSIGNED NULL;

-- Step 3: Add new foreign key constraints
ALTER TABLE `students` 
    ADD CONSTRAINT `students_user_id_foreign` 
    FOREIGN KEY (`user_id`) 
    REFERENCES `user_accounts` (`id`) 
    ON DELETE CASCADE;

ALTER TABLE `students` 
    ADD CONSTRAINT `students_course_id_foreign` 
    FOREIGN KEY (`course_id`) 
    REFERENCES `courses` (`id`) 
    ON DELETE CASCADE;

-- Verify the changes
SHOW CREATE TABLE `students`;
