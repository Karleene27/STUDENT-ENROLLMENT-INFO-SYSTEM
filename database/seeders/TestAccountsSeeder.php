<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use Illuminate\Support\Facades\Hash;

class TestAccountsSeeder extends Seeder
{
    public function run()
    {
        // Admin account
        $admin = User::updateOrCreate(
            ['email' => 'admin@seis.com'],
            [
                'name' => 'System Administrator',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Test student account (active, ready to login)
        $studentUser = User::updateOrCreate(
            ['email' => 'student@seis.com'],
            [
                'name' => 'Test Student',
                'password' => Hash::make('password'),
                'role' => 'student',
            ]
        );

        Student::updateOrCreate(
            ['user_id' => $studentUser->id],
            [
                'student_id' => '2024-TEST01',
                'first_name' => 'Test',
                'last_name' => 'Student',
                'date_of_birth' => '2000-01-01',
                'program' => 'Computer Science',
                'year_level' => 'Freshman',
                'status' => 'Active',      // <-- Already approved
                'gpa' => 0.00,
                'advisor_name' => 'Dr. Advisor',
                'advisor_email' => 'advisor@university.edu',
            ]
        );

        $this->command->info('✅ Test accounts created:');
        $this->command->info('Admin: admin@seis.com / password');
        $this->command->info('Student: student@seis.com / password (approved)');
    }
}