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

class LargeDataSeeder extends Seeder
{
    public function run()
    {
        // 1. Departments
        $depts = [
            ['CS', 'Computer Science', 'Dr. Alan Turing'],
            ['MATH', 'Mathematics', 'Dr. Ada Lovelace'],
            ['ENG', 'Engineering', 'Dr. William Shakespeare'],
            ['SCI', 'Sciences', 'Dr. Marie Curie'],
            ['BUS', 'Business', 'Dr. Peter Drucker'],
            ['ART', 'Arts', 'Dr. Leonardo da Vinci'],
        ];
        foreach ($depts as $d) {
            Department::firstOrCreate(['dept_code' => $d[0]], [
                'dept_name' => $d[1],
                'chairperson' => $d[2],
            ]);
        }

        // 2. Create 50+ courses (each with 2-3 sections)
        $departments = Department::all();
        $subjects = [
            'CS' => ['Programming', 'Data Structures', 'Algorithms', 'Databases', 'Web Dev', 'Networks', 'OS', 'AI', 'ML', 'Cybersecurity', 'Cloud Computing', 'DevOps', 'Mobile Dev', 'Game Dev', 'Compilers'],
            'MATH' => ['Algebra', 'Calculus', 'Geometry', 'Stats', 'Discrete Math', 'Linear Algebra', 'Diff Equations', 'Number Theory', 'Topology', 'Real Analysis'],
            'ENG' => ['Mechanics', 'Thermodynamics', 'Fluids', 'Electronics', 'Robotics', 'Materials', 'Dynamics', 'Control Systems', 'CAD', 'Structural Analysis'],
            'SCI' => ['Physics', 'Chemistry', 'Biology', 'Astronomy', 'Geology', 'Env Science', 'Genetics', 'Neuroscience', 'Ecology', 'Biochemistry'],
            'BUS' => ['Marketing', 'Finance', 'Accounting', 'Management', 'Economics', 'Business Law', 'Entrepreneurship', 'Supply Chain', 'HRM', 'Business Analytics'],
            'ART' => ['Drawing', 'Painting', 'Sculpture', 'Digital Art', 'Photography', 'Art History', 'Graphic Design', 'Animation', 'Film', 'Music Theory'],
        ];

        $times = ['8:00 AM - 10:00 AM', '10:00 AM - 12:00 PM', '1:00 PM - 3:00 PM', '3:00 PM - 5:00 PM', '5:30 PM - 7:30 PM'];
        $days = ['MWF', 'TTh', 'MW', 'TThS', 'Sat'];
        $rooms = ['Room 101', 'Lab 202', 'Hall 301', 'Auditorium A', 'Studio 5', 'Room 402', 'Lecture Hall B'];
        $instructors = ['Prof. Santos', 'Prof. Cruz', 'Prof. Lee', 'Prof. Dela Cruz', 'Prof. Gomez', 'Prof. Ramos', 'Prof. Reyes', 'Prof. Villanueva'];

        $courseCount = 0;
        foreach ($subjects as $deptCode => $titles) {
            $department = Department::where('dept_code', $deptCode)->first();
            if (!$department) continue;

            $counter = 101;
            foreach ($titles as $title) {
                $courseCode = $deptCode . $counter;
                $course = Course::create([
                    'course_code' => $courseCode,
                    'title' => $title,
                    'credits' => rand(3, 4),
                    'capacity' => rand(25, 45),
                    'department_id' => $department->id,
                    'status' => 'Open',
                    'semester' => '1st Sem',
                    'year' => 2025,
                ]);
                $courseCount++;

                // Add 2-3 sections per course
                $numSections = rand(2, 3);
                for ($i = 0; $i < $numSections; $i++) {
                    Section::create([
                        'course_id' => $course->id,
                        'section_code' => chr(65 + $i),
                        'schedule_time' => $times[array_rand($times)],
                        'schedule_days' => $days[array_rand($days)],
                        'room' => $rooms[array_rand($rooms)],
                        'instructor' => $instructors[array_rand($instructors)],
                        'capacity' => $course->capacity,
                        'enrolled_count' => 0,
                        'status' => 'Open',
                    ]);
                }
                $counter++;
            }
        }
        $this->command->info("Created {$courseCount} courses with sections.");

        // 3. Create 100 students
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
        $years = ['Freshman', 'Sophomore', 'Junior', 'Senior'];

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
                'year_level' => $years[array_rand($years)],
                'status' => 'Active',
                'gpa' => round(rand(250, 390) / 100, 2),
                'advisor_name' => 'Dr. ' . $lastNames[array_rand($lastNames)],
                'advisor_email' => 'advisor@university.edu',
            ]);
        }
        $this->command->info('Created 100 students. All passwords: password');

        // 4. Create enrollments and payments for each student
        $students = Student::all();
        $sections = Section::all();

        foreach ($students as $student) {
            // Each student enrolls in 3-7 random courses
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
                        'status' => (rand(1, 100) <= 30) ? 'paid' : 'pending', // 30% paid, 70% pending
                        'reference_number' => 'INV-' . strtoupper(uniqid()),
                        'payment_method' => null,
                    ]);
                }
            }
        }
        $this->command->info('Enrollments and payments created.');
    }
}