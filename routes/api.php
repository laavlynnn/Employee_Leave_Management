
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\LeaveTypeController;
use App\Http\Controllers\Api\LeaveRequestController;
use App\Http\Controllers\Api\ApprovalController;

// Public login
Route::post('/login', [AuthController::class, 'login']);

// Public reference data
Route::apiResource('departments', DepartmentController::class)
    ->only(['index', 'show']);

Route::apiResource('leave-types', LeaveTypeController::class)
    ->only(['index', 'show']);

// Authenticated endpoints
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::apiResource('departments', DepartmentController::class)
        ->except(['index', 'show']);

    Route::apiResource('employees', EmployeeController::class);

    Route::apiResource('leave-types', LeaveTypeController::class)
        ->except(['index', 'show']);

    Route::apiResource('leave-requests', LeaveRequestController::class);

    Route::apiResource('approvals', ApprovalController::class);
});
