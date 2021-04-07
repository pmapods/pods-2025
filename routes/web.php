<?php

use Illuminate\Support\Facades\Route;
// Auth
use App\Http\Controllers\Auth\LoginController;

// Dashboard
use App\Http\Controllers\Dashboard\DashboardController;

// Masterdata
use App\Http\Controllers\Masterdata\EmployeeController;
use App\Http\Controllers\Masterdata\SalesPointController;
use App\Http\Controllers\Masterdata\EmployeeAccessController;

Route::get('/', function () {
    return redirect('/login');
});

//Auth
Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/doLogin',[LoginController::class, 'doLogin']);

Route::get('/dashboard',[DashboardController::class, 'dashboardView']);
// MASTERDATA
// ++++++++++++++
// Employee Postion
Route::get('/employeeposition',[EmployeeController::class, 'employeepostitionView']);

// Employee
Route::get('/employee',[EmployeeController::class, 'employeeView']);

// Employee Access
Route::get('/employeeaccess',[EmployeeAccessController::class, 'employeeaccessView']);
Route::get('/employeeaccess/{employee_code}',[EmployeeAccessController::class, 'employeeaccessdetailView']);
Route::get('/salespoint',[SalesPointController::class, 'salespointView']);
