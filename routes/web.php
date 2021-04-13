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
use App\Http\Controllers\Masterdata\AuthorizationController;
use App\Http\Controllers\Masterdata\VendorController;
use App\Http\Controllers\Masterdata\BudgetPricingController;

// Operational
use App\Http\Controllers\Operational\PRController;
use App\Http\Controllers\Operational\TicketingController;

Route::get('/', function () {
    return redirect('login');
});

//Auth
Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/doLogin',[LoginController::class, 'doLogin']);

Route::middleware(['auth'])->group(function () {
    // Auth
    Route::get('/logout', function (){
        Auth::logout();
        return back();
    });
    
    Route::get('/dashboard',[DashboardController::class, 'dashboardView']);
    // MASTERDATA
        // Employee Postion
        Route::get('/employeeposition',[EmployeeController::class, 'employeepostitionView']);
        Route::post('/addPosition',[EmployeeController::class, 'addEmployeePosition']);
        Route::patch('/updatePosition',[EmployeeController::class, 'updateEmployeePosition']);
        Route::delete('/deletePosition',[EmployeeController::class, 'deleteEmployeePosition']);
    
        // Employee
        Route::get('/employee',[EmployeeController::class, 'employeeView']);
        Route::post('/addEmployee',[EmployeeController::class, 'addEmployee']);
        Route::patch('/updateEmployee',[EmployeeController::class, 'updateEmployee']);
        Route::delete('/deleteEmployee',[EmployeeController::class, 'deleteEmployee']);
        Route::patch('/nonactiveemployee',[EmployeeController::class, 'nonactiveEmployee']);
        Route::patch('/activeemployee',[EmployeeController::class, 'activeEmployee']);
    
        // Employee Access
        Route::get('/employeeaccess',[EmployeeAccessController::class, 'employeeaccessView']);
        Route::get('/employeeaccess/{employee_code}',[EmployeeAccessController::class, 'employeeaccessdetailView']);

        // Sales Point
        Route::get('/salespoint',[SalesPointController::class, 'salespointView']);
        Route::post('/addsalespoint',[SalesPointController::class, 'addSalesPoint']);
        Route::patch('/updatesalespoint',[SalesPointController::class, 'updateSalesPoint']);
        Route::delete('/deletesalespoint',[SalesPointController::class, 'deleteSalesPoint']);
    
        // Authorization
        Route::get('/authorization',[AuthorizationController::class, 'authorizationView']);
    
        // VENDOR
        Route::get('/vendor',[VendorController::class, 'vendorView']);
    
        // Budget Pricing
        Route::get('/budgetpricing',[BudgetPricingController::class, 'budgetpricingView']);
    
    // OPERATIONAL
        // Pengadaan Barang Jasa
        Route::get('/ticketing',[TicketingController::class, 'ticketingView']);

        // Purchase Requisition
        Route::get('/pr',[PRController::class, 'prView']);
});
