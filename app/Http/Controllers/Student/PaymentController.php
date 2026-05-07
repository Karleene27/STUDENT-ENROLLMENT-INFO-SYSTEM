<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Auth::user()->student->payments()->with('enrollment.course')->paginate(10);
        return view('student.payments.index', compact('payments'));
    }
}