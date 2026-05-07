<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;
use App\Models\Section;

class ManyCoursesSeeder extends Seeder
{
    public function run()
    {
        // Departments (ensure they exist)
        $cs = Department::firstOrCreate(['dept_code' => 'CS'], ['dept_name' => 'Computer Science']);
        $math = Department::firstOrCreate(['dept_code' => 'MATH'], ['dept_name' => 'Mathematics']);
        $eng = Department::firstOrCreate(['dept_code' => 'ENG'], ['dept_name' => 'Engineering']);
        $sci = Department::firstOrCreate(['dept_code' => 'SCI'], ['dept_name' => 'Sciences']);

        $subjects = [
            'CS' => ['Programming', 'Data Structures', 'Algorithms', 'Databases', 'Web Dev', 'Networks', 'OS', 'AI', 'Machine Learning', 'Cybersecurity'],
            'MATH' => ['Algebra', 'Calculus', 'Geometry', 'Statistics', 'Discrete Math', 'Linear Algebra', 'Differential Equations', 'Number Theory'],
            'ENG' => ['Mechanics', 'Thermodynamics', 'Fluids', 'Electronics', 'Robotics', 'Materials', 'Dynamics', 'Control Systems'],
            'SCI' => ['Physics', 'Chemistry', 'Biology', 'Astronomy', 'Geology', 'Environmental Science', 'Genetics', 'Neuroscience'],
        ];

        $times = ['8:00 AM - 10:00 AM', '10:00 AM - 12:00 PM', '1:00 PM - 3:00 PM', '3:00 PM - 5:00 PM'];
        $days = ['MWF', 'TTh', 'MW', 'TThS'];
        $rooms = ['Room 101', 'Lab 202', 'Hall 301', 'Auditorium A', 'Studio 5'];
        $instructors = ['Prof. Santos', 'Prof. Cruz', 'Prof. Lee', 'Prof. Dela Cruz', 'Prof. Gomez', 'Prof. Ramos'];

        foreach ($subjects as $deptCode => $titles) {
            $department = Department::where('dept_code', $deptCode)->first();
            if (!$department) continue;

            $num = 101;
            foreach ($titles as $title) {
                $courseCode = $deptCode . $num;
                // Use firstOrCreate to avoid duplicates
                $course = Course::firstOrCreate(
                    ['course_code' => $courseCode],
                    [
                        'title' => $title,
                        'credits' => rand(3, 4),
                        'capacity' => rand(25, 40),
                        'department_id' => $department->id,
                        'status' => 'Open',
                        'semester' => 'Spring',
                        'year' => 2025,
                    ]
                );

                // Add 2-3 sections per course (only if no sections exist)
                if ($course->sections()->count() == 0) {
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
                }
                $num++;
            }
        }

        $this->command->info('Courses created: ' . Course::count());
        $this->command->info('Sections created: ' . Section::count());
    }
}