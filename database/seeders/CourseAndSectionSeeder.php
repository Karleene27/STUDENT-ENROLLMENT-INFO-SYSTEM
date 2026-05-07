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
        // Ensure departments exist
        $cs = Department::firstOrCreate(['dept_code' => 'CS'], ['dept_name' => 'Computer Science']);
        $math = Department::firstOrCreate(['dept_code' => 'MATH'], ['dept_name' => 'Mathematics']);

        $courses = [
            ['CS101', 'Introduction to Programming', 3, 30, $cs->id],
            ['CS202', 'Data Structures', 3, 30, $cs->id],
            ['MATH101', 'College Algebra', 3, 35, $math->id],
        ];

        foreach ($courses as $c) {
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

            // Add two sections per course
            for ($i = 0; $i < 2; $i++) {
                Section::firstOrCreate(
                    ['course_id' => $course->id, 'section_code' => chr(65 + $i)],
                    [
                        'schedule_time' => $i == 0 ? '8:00 AM - 10:00 AM' : '10:00 AM - 12:00 PM',
                        'schedule_days' => 'MWF',
                        'room' => 'Room ' . (101 + $i),
                        'instructor' => 'Prof. ' . ($i == 0 ? 'Santos' : 'Cruz'),
                        'capacity' => $course->capacity,
                        'enrolled_count' => 0,
                        'status' => 'Open',
                    ]
                );
            }

            $this->command->info("Created course {$c[0]} with sections.");
        }
    }
}