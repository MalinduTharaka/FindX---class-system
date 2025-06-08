<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
}
