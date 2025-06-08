<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ClassesController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']); //alredy done
Route::post('/login', [AuthController::class, 'login']);//already done
Route::middleware('auth:sanctum')->post('/logout', [AuthController::class, 'logout']);//already done

//these routes are not working yet
Route::post('/password/send-otp', [AuthController::class, 'sendResetOtp']);
Route::post('/otp/verify', [AuthController::class, 'verify']);
Route::post('/password/reset', [AuthController::class, 'resetPassword']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Protected routes go here
    Route::get('/students/{id}', [StudentController::class, 'showForMobile']);//done
Route::post('/students/recentAttendance', [AttendanceController::class, 'showRecentAttendance']);//done
Route::post('/students/recentPayments', [PaymentController::class, 'showRecentPayments']);//done
Route::get('/classes/allClasses',[ClassesController::class,'indexApi']);//done
    Route::get('/student', [StudentController::class, 'indexForMobile']);//done
    Route::post('/storePaymentsMobile', [PaymentController::class, 'storePaymentsMobile']);//done
    Route::get('/payment/{studentId}', [PaymentController::class, 'getPaymentsForStudentInMobile']);//done
    Route::post('/students/markAttendanceMobile', [AttendanceController::class, 'markAttendanceMobile']);//done
});
