<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

use App\Models\Attendance;
use App\Models\AssignToClass;

use function Laravel\Prompts\error;
use Illuminate\Support\Facades\Log;

class StudentController extends Controller
{
    public function index(){
        $students = Student::all()->where('status', 'active');

        return view('admin.student-register', compact('students'));

    }

    public function store(Request $request)
    {
        // Validation logic

        $student = Student::create([
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'parent_name' => $request->input('parent_name'),
            'parent_contact' => $request->input('parent_contact'),
            'student_contact' => $request->input('student_contact'),
            'whatsapp_num' => $request->input('whatsapp_num'),
            'school_name' => $request->input('school_name'),
            'gender' => $request->input('gender'),
            'dob' => $request->input('dob'),
        ]);

        if ($student) {
            return redirect()->route('student')->with('success', 'Student added successfully!');
        } else {
            return redirect()->route('student')->with('error', 'Failed to add student.');
        }
    }

    public function edit(Request $request, $id)
    {
        $student = Student::find($id);
        
        if ($student) {
            $student->update([
                'name' => $request->input('name'),
                'address' => $request->input('address'),
                'parent_name' => $request->input('parent_name'),
                'parent_contact' => $request->input('parent_contact'),
                'student_contact' => $request->input('student_contact'),
                'whatsapp_num' => $request->input('whatsapp_num'),
                'school_name' => $request->input('school_name'),
                'gender' => $request->input('gender'),
                'dob' => $request->input('dob'),
            ]);
            return redirect()->route('student')->with('success', 'Student updated successfully!');
        }
            return redirect()->route('student')->with('error', 'Failed to update student.');
    }

    public function delete($id){
        $student = Student::find($id);
        if ($student) {
            $student->update([
                'status' => 'inactive',
            ]);
            return redirect()->route('student')->with('success', 'Student deleted successfully!');
        }
        return redirect()->route('student')->with('error', 'Failed to delete student.');
    }


    //for mobile APIs

    public function showForMobile($id)
{
    Log::info('Attempting to retrieve student with ID: ' . $id);

    // Find the student by ID
    $student = Student::find($id);

    if ($student) {
        Log::info('Student found', ['student' => $student]);

        // Fetch the student's registered classes with only 'class_id' and 'name' from the ClassModel
        $registeredClasses = AssignToClass::where('student_id', $id)
            ->with(['class' => function($query) {
                $query->select('id', 'name'); // Select only the class ID and name
            }])
            ->get();

        // Map the result to extract only the necessary class data
        $classes = $registeredClasses->map(function ($assignment) {
            return [
                'class_id' => $assignment->class->id,
                'name' => $assignment->class->name,
            ];
        });

        return response()->json([
            'success' => true,
            'student' => $student,
            'registered_classes' => $classes
        ], 200);
    }

    Log::warning('Student not found with ID: ' . $id);

    return response()->json([
        'success' => false,
        'message' => 'Student not found.'
    ], 404);
}

public function indexForMobile()
{
    $students = Student::all(); // or with filters like ->select('id', 'name')->get();
    return response()->json($students);
}

}
