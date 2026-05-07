<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;
use App\Models\Course;
use App\Models\Section;

class CourseAndSectionSeeder extends Seeder
{
    public function run()
    {
        $departments = Department::all();

        $subjects = [
            'CS' => ['Programming', 'Data Structures', 'Algorithms', 'Databases', 'Web Dev', 'Networks', 'OS', 'AI', 'ML', 'Cybersecurity'],
            'MATH' => ['Algebra', 'Calculus', 'Geometry', 'Stats', 'Discrete Math', 'Linear Algebra', 'Diff Equations'],
            'ENG' => ['Mechanics', 'Thermodynamics', 'Fluids', 'Electronics', 'Robotics', 'Materials'],
            'SCI' => ['Physics', 'Chemistry', 'Biology', 'Astronomy', 'Geology', 'Env Science'],
            'BUS' => ['Marketing', 'Finance', 'Accounting', 'Management', 'Economics'],
            'ART' => ['Drawing', 'Painting', 'Sculpture', 'Digital Art', 'Photography'],
        ];

        $semesters = ['1st Sem', '2nd Sem'];
        $years = [2024, 2025, 2026, 2027];

        $times = ['8:00 AM - 10:00 AM', '10:00 AM - 12:00 PM', '1:00 PM - 3:00 PM', '3:00 PM - 5:00 PM'];
        $days = ['MWF', 'TTh', 'MW', 'TThS'];
        $rooms = ['Room 101', 'Lab 202', 'Hall 301', 'Auditorium A'];
        $instructors = ['Prof. Santos', 'Prof. Cruz', 'Prof. Lee', 'Prof. Dela Cruz', 'Prof. Gomez'];

        foreach ($subjects as $deptCode => $titles) {
            $department = Department::where('dept_code', $deptCode)->first();
            if (!$department) continue;

            $counter = 101;
            foreach ($titles as $title) {
                $courseCode = $deptCode . $counter;
                foreach ($years as $year) {
                    foreach ($semesters as $semester) {
                        $course = Course::firstOrCreate(
                            [
                                'course_code' => $courseCode,
                                'semester' => $semester,
                                'year' => $year,
                            ],
                            [
                                'title' => $title,
                                'credits' => rand(3, 4),
                                'capacity' => rand(25, 45),
                                'department_id' => $department->id,
                                'status' => 'Open',
                            ]
                        );

                        // Only create sections if none exist for this course (optional)
                        if ($course->sections()->count() == 0) {
                            for ($i = 0; $i < 2; $i++) {
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
                    }
                }
                $counter++;
            }
        }
        $this->command->info('Courses and sections created for years 2024-2027.');
    }
}