<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserAccount;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Course_Student;
use App\Models\Post;
use App\Models\Profile;

class CompleteDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Populate users table (sync with user_accounts)
        $userAccounts = UserAccount::all();
        foreach ($userAccounts as $userAccount) {
            User::updateOrCreate(
                ['email' => $userAccount->email],
                [
                    'name' => $userAccount->username,
                    'password' => $userAccount->password,
                ]
            );
        }

        echo "✅ Users table populated with " . User::count() . " records\n";

        // Populate course_students table (enroll students in courses)
        $students = Student::all();
        $courses = Course::all();

        if ($students->count() > 0 && $courses->count() > 0) {
            foreach ($students as $student) {
                // Enroll each student in their primary course
                if ($student->course_id) {
                    Course_Student::updateOrCreate([
                        'student_id' => $student->id,
                        'course_id' => $student->course_id,
                    ]);
                }
            }
        }

        echo "✅ Course_students table populated with " . Course_Student::count() . " records\n";

        // Create sample posts if none exist
        if (Post::count() === 0) {
            $adminUser = UserAccount::where('role', 'admin')->first();
            
            if ($adminUser) {
                Post::create([
                    'title' => 'Welcome to PSU Student Portal',
                    'content' => 'Welcome to the Pangasinan State University Student Management Portal. Stay updated with the latest announcements and news.',
                    'user_id' => $adminUser->id,
                ]);

                Post::create([
                    'title' => 'Enrollment Period Announcement',
                    'content' => 'The enrollment period for the upcoming semester will begin next month. Please prepare your requirements.',
                    'user_id' => $adminUser->id,
                ]);

                Post::create([
                    'title' => 'Academic Calendar Released',
                    'content' => 'The academic calendar for this year has been released. Check the important dates and deadlines.',
                    'user_id' => $adminUser->id,
                ]);

                echo "✅ Posts table populated with " . Post::count() . " records\n";
            }
        }

        // Create sample profiles if none exist
        if (Profile::count() === 0) {
            $adminUser = UserAccount::where('role', 'admin')->first();
            
            if ($adminUser) {
                Profile::create([
                    'title' => 'About PSU',
                    'description' => 'Pangasinan State University is a premier institution of higher learning in the Philippines.',
                    'user_id' => $adminUser->id,
                ]);

                Profile::create([
                    'title' => 'Mission and Vision',
                    'description' => 'Our mission is to provide quality education and produce globally competitive graduates.',
                    'user_id' => $adminUser->id,
                ]);

                Profile::create([
                    'title' => 'Campus Facilities',
                    'description' => 'PSU offers modern facilities including libraries, laboratories, and sports complexes.',
                    'user_id' => $adminUser->id,
                ]);

                echo "✅ Profiles table populated with " . Profile::count() . " records\n";
            }
        }

        echo "\n🎉 All tables populated successfully!\n";
    }
}
