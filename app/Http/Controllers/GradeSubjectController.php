<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;

class GradeSubjectController extends Controller
{
    public function show()
    {
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('admin.grade-subject', compact('grades', 'subjects'));
    }

    public function storeSubject(Request $request)
    {
        $validate = $request->validate([
            'name' => 'string|required',
            'note' => 'string|nullable',
        ]);
        $subject = Subject::create([
            'name' => $request->name,
            'note' => $request->note,
        ]);
        return redirect()->back()->with('success', 'Subject created successfully');
    }

    public function editSubject(Request $request, $id)
    {
        $subject = Subject::find($id);
        if($subject){
            $subject->update([
                'name' => $request->input('name'),
                'note' => $request->input('note'),
            ]);
            return redirect()->route('gradeSubject')->with('success', 'Subject updated successfully!');
        }
    }

    public function deleteSubject(Request $request, $id)
    {
        $subject = Subject::find($id);
        if($subject){
            $subject->delete();
            return redirect()->route('gradeSubject')->with('success', 'Subject deleted successfully!');
        }else{
            return redirect()->route('gradeSubject')->with('error', 'Subject not found!');
        }
    }

    public function storeGrade(Request $request)
    {
        $validate = $request->validate([
            'name' => 'string|required',
        ]);
        $grade = Grade::create([
            'name' => $request->name,
        ]);
        return redirect()->back()->with('success', 'Grade created successfully');
    }

    public function editGrade(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $grade = Grade::find($id);
        if ($grade) {
            $grade->update(['name' => $request->input('name')]);

            return redirect()->route('gradeSubject')->with('success', 'Grade updated successfully!');
        }

        return redirect()->route('gradeSubject')->with('error', 'Grade not found!');
    }

    public function deleteGrade($id)
    {
        $grade = Grade::find($id);
        if($grade){
            $grade->delete();
            return redirect()->route('gradeSubject')->with('success', 'Grade deleted successfully');
        } else {
            return redirect()->route('gradeSubject')->with('error', 'Grade not found');
        }
    }
}
