<?php

use App\Http\Controllers\AssignStudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\ClassesController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\GradeSubjectController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\StudentController;

Route::get('/', function () {
    if(Auth::check()){
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    //Student Routes
    Route::get('/student', [StudentController::class, 'index'])->name('student');
    Route::post('/student/create', [StudentController::class, 'store'])->name('student.store');
    Route::put('/student/update/{id}', [StudentController::class, 'edit'])->name('student.update');
    Route::put('/student/delete/{id}', [StudentController::class, 'delete'])->name('student.delete');

    //Grade Subject Rotes
    Route::get('/grade-subject', [GradeSubjectController::class, 'show'])->name('gradeSubject');
    Route::post('/grade-subject/createSubject', [GradeSubjectController::class, 'storeSubject']);
    Route::put('/grade-subject/updateSubject/{id}', [GradeSubjectController::class, 'editSubject']);
    Route::delete('/grade-subject/deleteSubject/{id}', [GradeSubjectController::class, 'deleteSubject']);
    Route::post('/grade-subject/createGrade', [GradeSubjectController::class, 'storeGrade']);
    Route::put('/grade-subject/updateGrade/{id}', [GradeSubjectController::class, 'editGrade']);
    Route::delete('/grade-subject/deleteGrade/{id}', [GradeSubjectController::class, 'deleteGrade']);

    //Class Routes
    Route::get('/classes', [ClassesController::class, 'index'])->name('classes');
    Route::post('/classes/store', [ClassesController::class, 'store'])->name('classes.store');
    Route::put('/classes/update/{id}', [ClassesController::class, 'update'])->name('classes.update');
    Route::put('/classes/delete/{id}', [ClassesController::class, 'delete'])->name('classes.delete');
    Route::post('/update-class-fee/{classId}', [ClassesController::class, 'updateClassFee']);

    

    //Assign Student Routes
    Route::get('/assign-student/{id}', [AssignStudentController::class, 'index'])->name('assign-student');
    Route::post('/assign-student/store', [AssignStudentController::class, 'store'])->name('assign-student.store');
    Route::put('/assign-student/update/{id}', [AssignStudentController::class, 'update'])->name('assign-student.update');
    Route::put('/assign/deactivate/{id}', [AssignStudentController::class, 'deactivate'])->name('assign.deactivate');
    Route::post('/assign-student/upgrade/{id}', [AssignStudentController::class, 'upgrade'])->name('assign-student.upgrade');
    Route::post('/assign/create', [AssignStudentController::class, 'createAndAssign'])->name('assign.create');
    Route::get('/get-student-data/{student_id}', [AssignStudentController::class, 'getStudentData']);


    // Attendances Routes
    Route::get('/attendances', [AttendanceController::class, 'index']);
    Route::post('/attendances/store', [AttendanceController::class, 'storeAttendance']);

    //Payment Routes
    Route::post('/pay-class-fee', [PaymentController::class, 'payClassFee'])->name('pay-class-fee');
    Route::get('/class/payments', [PaymentController::class,'index'])->name('class-payments');
    Route::get('/api/payments/{studentId}', [PaymentController::class, 'getPaymentsForStudent']);
    Route::get('/api/check-payments/{studentId}/{classId}', [PaymentController::class, 'checkPayments']);
    Route::post('/api/store-payments', [PaymentController::class, 'storePayments']);



});
