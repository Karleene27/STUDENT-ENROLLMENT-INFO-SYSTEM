<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\Section;
use Illuminate\Support\Facades\Hash;

class StudentEnrollmentSeeder extends Seeder
{
    public function run()
    {
        $sections = Section::all();
        if ($sections->isEmpty()) {
            $this->command->warn('No sections found. Skipping enrollments.');
            return;
        }

        $firstNames = [
            'John', 'Jane', 'Michael', 'Sarah', 'David', 'Emma', 'James', 'Maria', 'Robert', 'Lisa',
            'William', 'Patricia', 'Richard', 'Jennifer', 'Thomas', 'Linda', 'Charles', 'Barbara',
            'Christopher', 'Jessica', 'Daniel', 'Karen', 'Matthew', 'Nancy', 'Anthony', 'Betty',
            'Donald', 'Helen', 'Mark', 'Sandra', 'Paul', 'Donna', 'Steven', 'Carol', 'Andrew', 'Ruth',
            'Kenneth', 'Sharon', 'Joshua', 'Michelle', 'Kevin', 'Laura', 'Brian', 'Sarah', 'George', 'Kimberly',
            'Edward', 'Deborah', 'Ronald', 'Rebecca', 'Timothy', 'Emily', 'Jason', 'Stephanie', 'Jeffrey', 'Amanda'
        ];
        $lastNames = [
            'Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez',
            'Wilson', 'Anderson', 'Taylor', 'Thomas', 'Moore', 'Jackson', 'Martin', 'Lee', 'White', 'Harris',
            'Clark', 'Lewis', 'Robinson', 'Walker', 'Perez', 'Hall', 'Young', 'Allen', 'Sanchez', 'Wright',
            'King', 'Scott', 'Green', 'Baker', 'Adams', 'Nelson', 'Hill', 'Ramirez', 'Campbell', 'Mitchell',
            'Roberts', 'Carter', 'Phillips', 'Evans', 'Turner', 'Torres', 'Parker', 'Collins', 'Edwards', 'Stewart'
        ];
        $programs = ['Computer Science', 'Mathematics', 'Engineering', 'Physics', 'Information Technology', 'Business Administration', 'Fine Arts'];
        $yearLevels = ['Freshman', 'Sophomore', 'Junior', 'Senior'];

        // Create 100 students
        for ($i = 0; $i < 100; $i++) {
            $fn = $firstNames[$i % count($firstNames)];
            $ln = $lastNames[$i % count($lastNames)];
            $email = strtolower($fn . '.' . $ln . $i . '@student.edu');
            $studentId = '2024-' . str_pad(1000 + $i, 4, '0', STR_PAD_LEFT);

            $user = User::create([
                'name' => $fn . ' ' . $ln,
                'email' => $email,
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id' => $studentId,
                'first_name' => $fn,
                'last_name' => $ln,
                'date_of_birth' => '200' . rand(0,5) . '-' . rand(1,12) . '-' . rand(1,28),
                'program' => $programs[array_rand($programs)],
                'year_level' => $yearLevels[array_rand($yearLevels)],
                'status' => 'Active',
                'gpa' => round(rand(250, 390) / 100, 2),
                'advisor_name' => 'Dr. ' . $lastNames[array_rand($lastNames)],
                'advisor_email' => 'advisor@university.edu',
            ]);
        }

        $students = Student::all();

        foreach ($students as $student) {
            $randomSections = $sections->random(rand(3, 7));
            foreach ($randomSections as $section) {
                if (Enrollment::where('student_id', $student->id)->where('section_id', $section->id)->exists()) {
                    continue;
                }
                if ($section->enrolled_count < $section->capacity) {
                    $enrollment = Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $section->course_id,
                        'section_id' => $section->id,
                        'enrollment_date' => now()->subDays(rand(1, 60)),
                        'status' => 'Enrolled',
                    ]);
                    $section->increment('enrolled_count');

                    $amount = $section->course->credits * 500;
                    Payment::create([
                        'student_id' => $student->id,
                        'enrollment_id' => $enrollment->id,
                        'amount' => $amount,
                        'payment_date' => now(),
                        'status' => rand(1, 10) <= 3 ? 'paid' : 'pending',
                        'reference_number' => 'INV-' . strtoupper(uniqid()),
                        'payment_method' => null,
                    ]);
                }
            }
        }
        $this->command->info('100 students created with enrollments and payments.');
    }
}