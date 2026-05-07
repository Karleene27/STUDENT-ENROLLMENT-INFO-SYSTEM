<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $departments = [
            ['dept_code' => 'CS', 'dept_name' => 'Computer Science', 'chairperson' => 'Dr. Alan Turing'],
            ['dept_code' => 'MATH', 'dept_name' => 'Mathematics', 'chairperson' => 'Dr. Ada Lovelace'],
            ['dept_code' => 'ENG', 'dept_name' => 'Engineering', 'chairperson' => 'Dr. William Shakespeare'],
            ['dept_code' => 'SCI', 'dept_name' => 'Sciences', 'chairperson' => 'Dr. Marie Curie'],
            ['dept_code' => 'BUS', 'dept_name' => 'Business', 'chairperson' => 'Dr. Peter Drucker'],
            ['dept_code' => 'ART', 'dept_name' => 'Arts', 'chairperson' => 'Dr. Leonardo da Vinci'],
        ];

        foreach ($departments as $dept) {
            Department::firstOrCreate(
                ['dept_code' => $dept['dept_code']],
                $dept
            );
        }
    }
}