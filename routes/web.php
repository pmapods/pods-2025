<?php

use Illuminate\Support\Facades\Route;
// Auth
use App\Http\Controllers\Auth\LoginController;

// Dashboard
use App\Http\Controllers\Dashboard\DashboardController;

// Masterdata
use App\Http\Controllers\Masterdata\EmployeeController;

// SalesPoint
use App\Http\Controllers\Masterdata\SalesPointController;

Route::get('/', function () {
    return redirect('/login');
});

//Auth
Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/doLogin',[LoginController::class, 'doLogin']);

Route::get('/dashboard',[DashboardController::class, 'dashboardView']);
// MASTERDATA
// ++++++++++++++
// Employee
Route::get('/employee',[EmployeeController::class, 'employeeView']);

// Salespoint
Route::get('/salespoint',[SalesPointController::class, 'salespointView']);
