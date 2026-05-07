<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\Department;
use App\Models\Course;
use App\Models\Section;
use App\Models\Enrollment;
use App\Models\Payment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1. Create departments
        $depts = [
            ['CS', 'Computer Science', 'Dr. Alan Turing'],
            ['MATH', 'Mathematics', 'Dr. Ada Lovelace'],
            ['ENG', 'Engineering', 'Dr. William Shakespeare'],
            ['SCI', 'Sciences', 'Dr. Marie Curie'],
        ];
        foreach ($depts as $d) {
            Department::firstOrCreate(
                ['dept_code' => $d[0]],
                ['dept_name' => $d[1], 'chairperson' => $d[2]]
            );
        }

        // 2. Create courses with sections
        $coursesData = [
            // Computer Science (dept_id = 1)
            ['CS101', 'Introduction to Programming', 3, 30, 1],
            ['CS202', 'Data Structures', 3, 30, 1],
            ['CS303', 'Database Systems', 3, 30, 1],
            // Mathematics (dept_id = 2)
            ['MATH101', 'College Algebra', 3, 35, 2],
            ['MATH202', 'Calculus II', 4, 30, 2],
            // Engineering (dept_id = 3)
            ['ENGR101', 'Engineering Mechanics', 3, 30, 3],
            ['ENGR202', 'Thermodynamics', 3, 25, 3],
            // Sciences (dept_id = 4)
            ['PHYS101', 'General Physics I', 4, 30, 4],
            ['CHEM101', 'General Chemistry', 3, 30, 4],
        ];

        $times = ['8:00 AM - 10:00 AM', '10:00 AM - 12:00 PM', '1:00 PM - 3:00 PM'];
        $days = ['MWF', 'TTh', 'MW'];
        $rooms = ['Room 101', 'Lab 202', 'Hall 301'];
        $instructors = ['Prof. Santos', 'Prof. Cruz', 'Prof. Lee', 'Prof. Dela Cruz'];

        foreach ($coursesData as $c) {
            $course = Course::firstOrCreate(
                ['course_code' => $c[0]],
                [
                    'title' => $c[1],
                    'credits' => $c[2],
                    'capacity' => $c[3],
                    'department_id' => $c[4],
                    'status' => 'Open',
                    'semester' => 'Spring',
                    'year' => 2025,
                ]
            );
            // Add 2-3 sections per course
            $numSections = rand(2, 3);
            for ($i = 0; $i < $numSections; $i++) {
                Section::firstOrCreate(
                    ['course_id' => $course->id, 'section_code' => chr(65 + $i)],
                    [
                        'schedule_time' => $times[array_rand($times)],
                        'schedule_days' => $days[array_rand($days)],
                        'room' => $rooms[array_rand($rooms)],
                        'instructor' => $instructors[array_rand($instructors)],
                        'capacity' => $course->capacity,
                        'enrolled_count' => 0,
                        'status' => 'Open',
                    ]
                );
            }
        }

        // 3. Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@seis.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );
        $this->command->info('Admin: admin@seis.com / password');

        // 4. Create 20 sample students
        $firstNames = ['John', 'Jane', 'Michael', 'Sarah', 'David', 'Emma', 'James', 'Maria', 'Robert', 'Lisa', 'William', 'Patricia', 'Richard', 'Jennifer', 'Thomas', 'Linda', 'Charles', 'Barbara', 'Christopher', 'Jessica'];
        $lastNames = ['Smith', 'Johnson', 'Williams', 'Brown', 'Jones', 'Garcia', 'Miller', 'Davis', 'Rodriguez', 'Martinez', 'Wilson', 'Anderson', 'Taylor', 'Thomas', 'Moore', 'Jackson', 'Martin', 'Lee', 'White', 'Harris'];
        $programs = ['Computer Science', 'Mathematics', 'Engineering', 'Physics', 'Information Technology'];
        $years = ['Freshman', 'Sophomore', 'Junior', 'Senior'];

        for ($i = 0; $i < 20; $i++) {
            $fn = $firstNames[$i];
            $ln = $lastNames[$i];
            $email = strtolower($fn . '.' . $ln . '@student.edu');
            $studentId = '2024-' . str_pad(1000 + $i, 4, '0', STR_PAD_LEFT);

            $user = User::firstOrCreate(
                ['email' => $email],
                [
                    'name' => $fn . ' ' . $ln,
                    'password' => Hash::make('password'),
                    'role' => 'student',
                ]
            );

            Student::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'student_id' => $studentId,
                    'first_name' => $fn,
                    'last_name' => $ln,
                    'date_of_birth' => '200' . rand(0,5) . '-' . rand(1,12) . '-' . rand(1,28),
                    'program' => $programs[array_rand($programs)],
                    'year_level' => $years[array_rand($years)],
                    'status' => 'Active',
                    'gpa' => round(rand(250, 390) / 100, 2),
                    'advisor_name' => 'Dr. ' . $lastNames[array_rand($lastNames)],
                    'advisor_email' => 'advisor@university.edu',
                ]
            );
        }
        $this->command->info('20 sample students created. All passwords: password');

        // 5. Create enrollments and payments
        $students = Student::all();
        $sections = Section::all();

        foreach ($students as $student) {
            // Each student enrolls in 2-5 random courses
            $randomSections = $sections->random(rand(2, 5));
            foreach ($randomSections as $section) {
                // Avoid duplicate enrollment
                if (Enrollment::where('student_id', $student->id)->where('section_id', $section->id)->exists()) {
                    continue;
                }
                if ($section->enrolled_count < $section->capacity) {
                    $enrollment = Enrollment::create([
                        'student_id' => $student->id,
                        'course_id' => $section->course_id,
                        'section_id' => $section->id,
                        'enrollment_date' => now()->subDays(rand(1, 30)),
                        'status' => 'Enrolled',
                    ]);
                    $section->increment('enrolled_count');

                    // Create payment (pending)
                    $amount = $section->course->credits * 500;
                    Payment::create([
                        'student_id' => $student->id,
                        'enrollment_id' => $enrollment->id,
                        'amount' => $amount,
                        'payment_date' => now(),
                        'status' => 'pending',
                        'reference_number' => 'INV-' . strtoupper(uniqid()),
                        'payment_method' => null,
                    ]);
                }
            }
        }
        $this->command->info('Enrollments and pending payments created.');
    }
}