<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

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

}
