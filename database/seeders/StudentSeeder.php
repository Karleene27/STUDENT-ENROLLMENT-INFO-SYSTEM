<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class StudentSeeder extends Seeder
{
    public function run(): void
    {
        $students = [
            ['student_id' => '2024-1001', 'first_name' => 'John', 'last_name' => 'Doe', 'program' => 'Computer Science', 'year_level' => 'Junior', 'gpa' => 3.6],
            ['student_id' => '2024-1002', 'first_name' => 'Jane', 'last_name' => 'Smith', 'program' => 'Mathematics', 'year_level' => 'Senior', 'gpa' => 3.9],
            ['student_id' => '2024-1003', 'first_name' => 'Michael', 'last_name' => 'Chen', 'program' => 'Computer Science', 'year_level' => 'Sophomore', 'gpa' => 3.4],
            ['student_id' => '2024-1004', 'first_name' => 'Sarah', 'last_name' => 'Lee', 'program' => 'Engineering', 'year_level' => 'Junior', 'gpa' => 3.2],
            ['student_id' => '2024-1005', 'first_name' => 'David', 'last_name' => 'Kim', 'program' => 'Computer Science', 'year_level' => 'Freshman', 'gpa' => 3.7],
            ['student_id' => '2024-1006', 'first_name' => 'Emma', 'last_name' => 'Wilson', 'program' => 'Physics', 'year_level' => 'Senior', 'gpa' => 3.5],
            ['student_id' => '2024-1007', 'first_name' => 'Robert', 'last_name' => 'Brown', 'program' => 'Mathematics', 'year_level' => 'Junior', 'gpa' => 3.1],
            ['student_id' => '2024-1008', 'first_name' => 'Maria', 'last_name' => 'Garcia', 'program' => 'Computer Science', 'year_level' => 'Sophomore', 'gpa' => 3.8],
        ];

        foreach ($students as $studentData) {
            $user = User::create([
                'name' => $studentData['first_name'] . ' ' . $studentData['last_name'],
                'email' => strtolower($studentData['first_name']) . '.' . strtolower($studentData['last_name']) . '@student.edu',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]);

            Student::create([
                'user_id' => $user->id,
                'student_id' => $studentData['student_id'],
                'first_name' => $studentData['first_name'],
                'last_name' => $studentData['last_name'],
                'date_of_birth' => '2000-01-01',
                'program' => $studentData['program'],
                'year_level' => $studentData['year_level'],
                'status' => 'Active',
                'gpa' => $studentData['gpa'],
                'advisor_name' => 'Dr. Advisor',
                'advisor_email' => 'advisor@university.edu',
            ]);
        }
    }
}