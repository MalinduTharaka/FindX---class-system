<?php

namespace App\Http\Controllers;

use App\Models\AssignToClass;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Support\Carbon;

class PaymentController extends Controller
{
    public function payClassFee(Request $request)
    {

        $attendance = new Attendance();
        $attendance->class_id = $request->class_id;
        $attendance->student_id = $request->student_id;
        $attendance->attendance_date = Carbon::today();
        $attendance->status = 'attended';
        $attendance->save();

        if($request->paid_amount)
        {
            $payment = new Payment();
            $payment->student_id = $request->student_id;
            $payment->class_id = $request->class_id;
            $payment->total = $request->total;
            $payment->paid_amount = $request->paid_amount;
            $payment->month = $request->month;
            $payment->save();
            return response()->json([
                'success' => true,
                'message' => 'Payment and attendence saved successfully!'
            ]);
        }
        
        return response()->json([
            'success' => true,
            'message' => 'Attendence saved successfully!'
        ]);
    }

    public function index()
    {
        $payments = Payment::all();
        $classes = ClassModel::all();
        $students = Student::all();
        $assigns = AssignToClass::all();
        return view('admin.class-payments', compact('payments','classes','students','assigns'));
    }

    public function getPaymentsForStudent($studentId)
{
    // Get the assignments for the selected student
    $assigns = AssignToClass::with('class')
                ->where('student_id', $studentId)
                ->get();

    return response()->json($assigns);
}


public function checkPayments($studentId, $classId)
{
    // Fetch payments for the given student and class
    $payments = Payment::where('student_id', $studentId)
                ->where('class_id', $classId)
                ->get(['month']); // Get only the month

    return response()->json($payments);
}


public function storePayments(Request $request)
{
    $payments = $request->input('payments');

    foreach ($payments as $paymentData) {
        Payment::create([
            'student_id'   => $paymentData['student_id'],
            'class_id'     => $paymentData['class_id'],
            'month'        => $paymentData['month'],
            'total'        => $paymentData['total'],  // Set class_fee dynamically
            'paid_amount'  => $paymentData['total'],  // Assuming full payment
        ]);
    }

    return response()->json(['message' => 'Payments successfully recorded!']);
}

    
}
