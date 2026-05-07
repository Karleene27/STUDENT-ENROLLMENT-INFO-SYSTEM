<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $student = Auth::user()->student;
        return view('student.profile', compact('student'));
    }
    
    public function update(Request $request)
    {
        $student = Auth::user()->student;
        $student->update([
            'phone' => $request->phone,
            'address' => $request->address,
        ]);
        return redirect()->route('student.profile')->with('success', 'Profile updated successfully.');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);
        
        $request->user()->update([
            'password' => Hash::make($request->password)
        ]);
        
        return redirect()->route('student.profile')->with('success', 'Password changed successfully!');
    }
}