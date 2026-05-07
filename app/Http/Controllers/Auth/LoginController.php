<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->remember)) {
            $request->session()->regenerate();
            
            $user = Auth::user();
            
            // Check if user is admin
            if ($user->role === 'admin') {
                return redirect()->intended('/admin/dashboard');
            }
            
            // For students, check if approved
            if ($user->role === 'student') {
                $student = $user->student;
                
                if (!$student || $student->status !== 'Active') {
                    Auth::logout();
                    return back()->withErrors([
                        'email' => 'Your account is pending approval. Please wait for administrator approval.',
                    ]);
                }
            }
            
            return redirect()->intended('/student/dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}