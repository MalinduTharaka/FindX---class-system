<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Student;
use App\Models\AssignToClass;

class AttendanceController extends Controller
{
    public function storeAttendance(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:classes,id',
            'student_id' => 'required|exists:students,id',
        ]);

        $attendance = new Attendance();
        $attendance->class_id = $request->class_id;
        $attendance->student_id = $request->student_id;
        $attendance->attendance_date = Carbon::today();
        $attendance->status = 'attended';
        $attendance->save();

        return redirect()->route('assign-student', $request->class_id)->with('success', 'Student attendance recorded successfully!');
    }

    //for mobile app

    
    public function showRecentAttendance(Request $request)
{
    $studentId = $request->input('studentId');
    $classId = $request->input('classId');

    Log::info('Attempting to retrieve student with ID: ' . $studentId . ' and class ID: ' . $classId);

    // Find the student by ID
    $student = Student::find($studentId);

    // Check if the student exists
    if ($student) {
        Log::info('Student found', ['student' => $student]);

        // Fetch the 3 most recent attendance records for the student and class
        $attendances = Attendance::where('student_id', $studentId)
            ->where('class_id', $classId) // Filter by class_id
            ->orderBy('attendance_date', 'desc') // Sort by the latest attendance date
            ->take(3) // Get the latest 3 records
            ->get(['attendance_date', 'status']); // Retrieve only the necessary fields

        // If there are attendance records, return them
        if ($attendances->isNotEmpty()) {
            return response()->json([
                'success' => true,
                'attendances' => $attendances
            ], 200);
        }

        Log::warning('No attendance records found for student ID: ' . $studentId . ' in class ID: ' . $classId);

        return response()->json([
            'success' => false,
            'message' => 'No attendance records found for this student in the specified class.'
        ], 404);
    }

    Log::warning('Student not found with ID: ' . $studentId);

    return response()->json([
        'success' => false,
        'message' => 'Student not found.'
    ], 404);
}

public function markAttendanceMobile(Request $request)
    {
        try {
            // Validate the request
            $request->validate([
                'class_id' => 'required|exists:classes,id',
                'student_id' => 'required|exists:students,id',
            ]);
            
            $registeredstudent = AssignToClass::where('class_id', $request->class_id)
    ->where('student_id', $request->student_id)
    ->where('status', 'active')
    ->first();

if (!$registeredstudent) {
    return response()->json([
        'success' => false,
        'message' => 'The student is not registered in this course.',
    ], 410); // 410 Gone (more appropriate than Conflict)
}

             // Check if attendance is already marked for today
        $existingAttendance = Attendance::where('class_id', $request->class_id)
        ->where('student_id', $request->student_id)
        ->whereDate('attendance_date', Carbon::today())
        ->first();

    if ($existingAttendance) {
        return response()->json([
            'success' => false,
            'message' => 'Attendance has already been marked for this student today.',
        ], 409); // 409 Conflict
    }
    
            // Create new attendance record
            $attendance = new Attendance();
            $attendance->class_id = $request->class_id;
            $attendance->student_id = $request->student_id;
            $attendance->attendance_date = Carbon::today();
            $attendance->status = 'attended';
            $attendance->save();
    
            // Return success response
            return response()->json([
                'success' => true,
                'message' => 'Attendance marked successfully.'
            ], 200);
    
        } catch (ValidationException $e) {
            // Handle validation exception
            return response()->json([
                'success' => false,
                'message' => 'Validation error: ' . $e->getMessage(),
            ], 422);
            
        } catch (ModelNotFoundException $e) {
            // Handle model not found exception (for class_id or student_id not found)
            return response()->json([
                'success' => false,
                'message' => 'The specified class or student was not found.',
            ], 404);
    
        } catch (Exception $e) {
            // Catch any other exceptions
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }


}
