<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'program' => ['required', 'string'],
        ]);

        // Auto-generate Student ID
        $latestStudent = Student::orderBy('id', 'desc')->first();
        if ($latestStudent) {
            $lastId = (int) substr($latestStudent->student_id, 5);
            $newId = $lastId + 1;
            $studentId = '2024-' . str_pad($newId, 4, '0', STR_PAD_LEFT);
        } else {
            $studentId = '2024-0001';
        }

        // Auto-generate a temporary password
        $temporaryPassword = Str::random(10);
        
        // Create user account
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($temporaryPassword),
            'role' => 'student',
        ]);

        // Create student profile with NO grades, NO enrollments
        Student::create([
            'user_id' => $user->id,
            'student_id' => $studentId,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'date_of_birth' => $request->date_of_birth,
            'program' => $request->program,
            'year_level' => $request->year_level ?? 'Freshman',
            'status' => 'Pending',  // Pending approval
            'gpa' => 0.00,  // No GPA
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        return redirect()->route('login')->with('success', 'Enrollment application submitted! Student ID: ' . $studentId . '. Your account is pending approval.');
    }
}