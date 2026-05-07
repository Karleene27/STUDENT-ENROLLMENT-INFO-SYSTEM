<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\Course;
use App\Models\Section;

class EnrollmentSeeder extends Seeder
{
    public function run(): void
    {
        // Only create enrollments for specific test students, not ALL students
        $testStudentIds = [1, 2, 3, 4, 5, 6, 7, 8]; // Only these students get enrollments
        
        $students = Student::whereIn('id', $testStudentIds)->get();
        $courses = Course::all();

        // Create sections for courses first
        foreach ($courses as $course) {
            Section::updateOrCreate(
                ['course_id' => $course->id, 'section_code' => 'A'],
                [
                    'schedule_time' => '8:00 AM - 10:00 AM',
                    'schedule_days' => 'MWF',
                    'room' => 'Room 101',
                    'instructor' => 'Prof. ' . chr(65 + rand(0, 25)),
                    'capacity' => $course->capacity,
                    'enrolled_count' => rand(0, $course->capacity - 5),
                ]
            );
        }

        // Create enrollments ONLY for test students
        foreach ($students as $student) {
            $studentProgram = $student->program;
            $deptId = $this->getDepartmentIdForProgram($studentProgram);
            
            $studentCourses = Course::where('department_id', $deptId)->get();
            
            if ($studentCourses->count() > 0) {
                $randomCourses = $studentCourses->random(min(2, $studentCourses->count()));
                foreach ($randomCourses as $course) {
                    $section = Section::where('course_id', $course->id)->first();
                    if ($section) {
                        Enrollment::create([
                            'student_id' => $student->id,
                            'course_id' => $course->id,
                            'section_id' => $section->id,
                            'enrollment_date' => now()->subDays(rand(1, 30)),
                            'status' => 'Enrolled',
                            'grade' => null,  // NO grades initially
                        ]);
                        $section->increment('enrolled_count');
                    }
                }
            }
        }
    }
    
    private function getDepartmentIdForProgram($program)
    {
        $mapping = [
            'Computer Science' => 1,
            'Mathematics' => 2,
            'Engineering' => 3,
            'Physics' => 4,
        ];
        return $mapping[$program] ?? 1;
    }
}