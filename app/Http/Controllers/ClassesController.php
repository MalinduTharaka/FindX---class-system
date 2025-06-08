<?php

namespace App\Http\Controllers;

use App\Models\ClassFeeHistory;
use App\Models\ClassModel;
use App\Models\Grade;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ClassesController extends Controller
{
    public function index(){
        $classes = ClassModel::all()->where('status', 'active');
        $grades = Grade::all();
        $subjects = Subject::all();
        return view('admin.classes', compact('classes', 'grades', 'subjects'));
    }

    public function store(Request $request)
    {
        $class = new ClassModel();
        $validated = $request->validate([
            'name' => 'required',
            'grade_id' => 'required',
            'subject_id' => 'required',
            'teacher' => 'nullable',
            'new_old_status' => 'nullable',
            'class_fee' => 'nullable'
        ]);
        $class->name = $validated['name'];
        $class->grade_id = $validated['grade_id'];
        $class->subject_id = $validated['subject_id'];
        $class->teacher = $validated['teacher'];
        $class->new_old_status = $validated['new_old_status'] ?? 'old';
        $class->class_fee = $validated['class_fee'];
        $class->save();
        return redirect()->back()->with('success', 'Class created successfully');
        
    }

    public function update(Request $request, $id)
    {
        $class = ClassModel::find($id);
        
        $class->name = $request['name'];
        $class->grade_id = $request['grade_id'];
        $class->subject_id = $request['subject_id'];
        $class->teacher = $request['teacher'];
        $class->new_old_status = $request['new_old_status'];
        $class->update();
        return redirect()->back()->with('success', 'Class updated successfully');
    }

    public function delete($id){
        $class = ClassModel::find($id);
        if($class){
            $class->status = 'inactive';
            $class->update();
            return redirect()->back()->with('success', 'Class deleted successfully');
        }
        return redirect()->back()->with('error', 'Class not found');
    }


    public function updateClassFee(Request $request, $classId)
    {
        $request->validate([
            'old_fee' => 'required|numeric',
            'new_fee' => 'required|numeric',
        ]);

        DB::beginTransaction();

        try {
            // Update the class fee
            $class = ClassModel::findOrFail($classId);
            $oldFee = $request->old_fee;
            $newFee = $request->new_fee;

            $class->class_fee = $newFee;
            $class->save();

            // Create a record in class_fee_history
            ClassFeeHistory::create([
                'class_id' => $classId,
                'old_fee' => $oldFee,
                'new_fee' => $newFee,
            ]);

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
