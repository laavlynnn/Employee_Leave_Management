<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DepartmentController as WebDepartmentController;
use App\Http\Controllers\Web\EmployeeController as WebEmployeeController;
use App\Http\Controllers\Web\LeaveTypeController as WebLeaveTypeController;
use App\Http\Controllers\Web\LeaveRequestController as WebLeaveRequestController;
use App\Http\Controllers\Web\ApprovalController as WebApprovalController;

Route::get('/', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::name('web.')->group(function () {
    Route::resource('departments', WebDepartmentController::class);
    Route::resource('employees', WebEmployeeController::class);
    Route::resource('leave-types', WebLeaveTypeController::class);
    Route::resource('leave-requests', WebLeaveRequestController::class);
    Route::resource('approvals', WebApprovalController::class);
});