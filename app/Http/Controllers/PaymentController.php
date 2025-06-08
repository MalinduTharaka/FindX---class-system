<?php

namespace App\Http\Controllers;

use App\Models\AssignToClass;
use App\Models\ClassModel;
use App\Models\Student;
use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Attendance;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

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

//for mobile app

public function showRecentPayments(Request $request)
    {
        $studentId = $request->input('studentId');
        $classId = $request->input('classId');

        Log::info('Attempting to retrieve student with ID: ' . $studentId . ' and class ID: ' . $classId);

        // Find the student by ID
        $student = Student::find($studentId);

        // Check if the student exists
        if ($student) {
            Log::info('Student found', ['student' => $student]);

            // Fetch the latest payment record for the student and class
            $payment = Payment::where('student_id', $studentId)
                ->where('class_id', $classId) // Filter by class_id
                ->orderBy('created_at', 'desc') // Sort by the latest payment date
                ->take(3) // Get the latest 3 records
                ->get(['created_at', 'paid_amount', 'month']); // Retrieve only the necessary fields

            // If there's payment data, return it
            if ($payment) {
                return response()->json([
                    'success' => true,
                    'payment' => $payment
                ], 200);
            }

            Log::warning('No payment records found for student ID: ' . $studentId . ' in class ID: ' . $classId);

            return response()->json([
                'success' => false,
                'message' => 'No payment records found for this student in the specified class.'
            ], 404);
        }

        Log::warning('Student not found with ID: ' . $studentId);

        return response()->json([
            'success' => false,
            'message' => 'Student not found.'
        ], 404);
    }

    public function getPaymentsForStudentInMobile($studentId)
    {
        // Get the assignments for the selected student with related class
        $assigns = AssignToClass::with('class')
                    ->where('student_id', $studentId)
                    ->get();

        // Fetch all paid months for the student grouped by class_id
        $payments = Payment::where('student_id', $studentId)
                    ->get()
                    ->groupBy('class_id');

        // Add paid_months to each record in assigns
        $assigns->transform(function ($item) use ($payments) {
            // Get the paid months for the current class_id
            $paidMonths = $payments->has($item->class_id) 
                ? $payments[$item->class_id]->pluck('month')->map(function ($month) {
                    return (int) $month; // Cast each month to an integer
                })->toArray() 
                : [];

            $item->paid_months = $paidMonths;

            return $item;
        });

        return response()->json($assigns);
    }



    public function storePaymentsMobile(Request $request)
    {
        // Log the incoming request data
        Log::info('storePayments called with data:', ['request' => $request->all()]);

        $payments = $request->input('payments');
        Log::info('Payments:', ['payments' => $payments]);

        foreach ($payments as $index => $paymentData) {
            try {
                // Log each payment data being processed
                Log::info("Processing payment #{$index}:", ['paymentData' => $paymentData]);

                Payment::create([
                    'student_id'   => $paymentData['student_id'],
                    'class_id'     => $paymentData['class_id'],
                    'month'        => $paymentData['month'],
                    'total'        => $paymentData['total'],  // Set class_fee dynamically
                    'paid_amount'  => $paymentData['total'],  // Assuming full payment
                ]);

                // Log success for the current payment
                Log::info("Payment #{$index} successfully recorded.");
            } catch (\Exception $e) {
                // Log the error if something goes wrong
                Log::error("Error processing payment #{$index}:", [
                    'paymentData' => $paymentData,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Log the completion of the function
        Log::info('storePayments completed.');

        return response()->json(['message' => 'Payments successfully recorded!']);
    }


    
}
