<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentManagementController extends Controller
{
    public function index()
    {
        $students = Student::with('user')->paginate(10);
        return view('admin.students.index', compact('students'));
    }
    
    public function pending()
    {
        $pendingStudents = Student::where('status', 'Pending')->with('user')->get();
        return view('admin.students.pending', compact('pendingStudents'));
    }
    
    public function approve(Student $student)
    {
        $password = Str::random(8);
        $user = $student->user;
        $user->password = Hash::make($password);
        $user->save();
        $student->status = 'Active';
        $student->save();
        return redirect()->route('admin.students.pending')->with('success', 'Student approved! Email: ' . $user->email . ' | Temporary Password: ' . $password);
    }
    
    public function reject(Student $student)
    {
        $user = $student->user;
        $student->delete();
        $user->delete();
        return redirect()->route('admin.students.pending')->with('success', 'Student application rejected.');
    }

    public function create()
    {
        return view('admin.students.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'student_id' => 'required|unique:students',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->first_name . ' ' . $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'student',
        ]);

        Student::create([
            'user_id' => $user->id,
            'student_id' => $request->student_id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'program' => $request->program,
            'year_level' => $request->year_level,
            'status' => 'Active',
            'gpa' => 0.00,
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Student created successfully.');
    }

    public function show(Student $student)
    {
        return view('admin.students.show', compact('student'));
    }

    public function edit(Student $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, Student $student)
    {
        $student->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'program' => $request->program,
            'year_level' => $request->year_level,
            'status' => $request->status,
        ]);

        $student->user->update(['email' => $request->email]);

        return redirect()->route('admin.students.index')->with('success', 'Student updated successfully.');
    }

    public function destroy(Student $student)
    {
        $user = $student->user;
        $student->delete();
        $user->delete();
        return redirect()->route('admin.students.index')->with('success', 'Student deleted successfully.');
    }
}