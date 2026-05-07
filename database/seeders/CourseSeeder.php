<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    public function run(): void
    {
        $courses = [
            // Computer Science Courses (dept_id = 1)
            ['course_code' => 'CS101', 'title' => 'Introduction to Computer Science', 'credits' => 3, 'capacity' => 30, 'department_id' => 1, 'semester' => 'Spring', 'year' => 2025],
            ['course_code' => 'CS202', 'title' => 'Data Structures', 'credits' => 3, 'capacity' => 25, 'department_id' => 1, 'semester' => 'Spring', 'year' => 2025],
            ['course_code' => 'CS303', 'title' => 'Database Management', 'credits' => 3, 'capacity' => 30, 'department_id' => 1, 'semester' => 'Spring', 'year' => 2025],
            
            // Mathematics Courses (dept_id = 2)
            ['course_code' => 'MATH202', 'title' => 'Calculus II', 'credits' => 4, 'capacity' => 35, 'department_id' => 2, 'semester' => 'Spring', 'year' => 2025],
            ['course_code' => 'MATH305', 'title' => 'Linear Algebra', 'credits' => 3, 'capacity' => 25, 'department_id' => 2, 'semester' => 'Spring', 'year' => 2025],
            
            // Engineering Courses (dept_id = 3)
            ['course_code' => 'ENG101', 'title' => 'Engineering Mechanics', 'credits' => 3, 'capacity' => 30, 'department_id' => 3, 'semester' => 'Spring', 'year' => 2025],
            ['course_code' => 'ENG201', 'title' => 'Thermodynamics', 'credits' => 3, 'capacity' => 25, 'department_id' => 3, 'semester' => 'Spring', 'year' => 2025],
            
            // Sciences Courses (dept_id = 4)
            ['course_code' => 'PHYS101', 'title' => 'Physics I', 'credits' => 4, 'capacity' => 30, 'department_id' => 4, 'semester' => 'Spring', 'year' => 2025],
            ['course_code' => 'CHEM101', 'title' => 'General Chemistry', 'credits' => 3, 'capacity' => 30, 'department_id' => 4, 'semester' => 'Spring', 'year' => 2025],
        ];

        foreach ($courses as $course) {
            Course::create($course);
        }
    }
}