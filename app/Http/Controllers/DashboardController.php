<?php

namespace App\Http\Controllers;

use App\Models\ClassModel;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $total_stu = Student::count();
        $total_class = ClassModel::count();
        $total_teachers = ClassModel::select('teacher')->distinct()->count();
        $total_sub = Subject::count();
        return view('admin.home', compact('total_stu', 'total_class', 'total_teachers', 'total_sub'));
    }
}
