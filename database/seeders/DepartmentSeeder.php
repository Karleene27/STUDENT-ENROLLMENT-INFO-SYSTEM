<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        Department::create(['dept_code' => 'CS', 'dept_name' => 'Computer Science', 'chairperson' => 'Dr. Alan Turing']);
        Department::create(['dept_code' => 'MATH', 'dept_name' => 'Mathematics', 'chairperson' => 'Dr. Ada Lovelace']);
        Department::create(['dept_code' => 'ENG', 'dept_name' => 'Engineering', 'chairperson' => 'Dr. William Shakespeare']);
        Department::create(['dept_code' => 'SCI', 'dept_name' => 'Sciences', 'chairperson' => 'Dr. Marie Curie']);
    }
}