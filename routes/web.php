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
use App\Http\Controllers\Operational\BiddingController;

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
    Route::middleware(['superadmin'])->group(function () {
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
            Route::patch('/updateemployeeaccessdetail',[EmployeeAccessController::class, 'updateemployeeaccessdetail']);
    
            // Sales Point
            Route::get('/salespoint',[SalesPointController::class, 'salespointView']);
            Route::post('/addsalespoint',[SalesPointController::class, 'addSalesPoint']);
            Route::patch('/updatesalespoint',[SalesPointController::class, 'updateSalesPoint']);
            Route::delete('/deletesalespoint',[SalesPointController::class, 'deleteSalesPoint']);
        
            // Authorization
            Route::get('/authorization',[AuthorizationController::class, 'authorizationView']);
            Route::get('/getauthorizedemployeebysalesPoint/{salespoint_id}',[AuthorizationController::class,'AuthorizedEmployeeBySalesPoint']);
            Route::post('/addauthorization',[AuthorizationController::class, 'addAuthorization']);
            Route::patch('/updateauthorization',[AuthorizationController::class, 'updateAuthorization']);
            Route::delete('/deleteauthorization',[AuthorizationController::class, 'deleteAuthorization']);
        
            // VENDOR
            Route::get('/vendor',[VendorController::class, 'vendorView']);
            Route::post('/addvendor',[VendorController::class, 'addVendor']);
            Route::patch('/updatevendor',[VendorController::class, 'updateVendor']);
            Route::delete('/deletevendor',[VendorController::class, 'deleteVendor']);
        
            // Budget Pricing
            Route::get('/budgetpricing',[BudgetPricingController::class, 'budgetpricingView']);
            Route::post('/addbudget',[BudgetPricingController::class, 'addBudget']);
            Route::patch('/updatebudget',[BudgetPricingController::class, 'updateBudget']);
            Route::delete('/deletebudget',[BudgetPricingController::class, 'deleteBudget']);
    });
    // OPERATIONAL
        // Pengadaan Barang Jasa
        Route::get('/ticketing',[TicketingController::class, 'ticketingView']);
        Route::get('/ticketing/{code}',[TicketingController::class, 'ticketingDetailView']);
        Route::get('/getsalespointauthorization/{salespoint_id}',[SalesPointController::class, 'getSalesAuthorization']);
        Route::get('/addnewticket',[TicketingController::class, 'addNewTicket']);
        Route::post('/addticket',[TicketingController::class, 'addTicket']);
        Route::patch('/startauthorization',[TicketingController::class, 'startAuthorization']);
        Route::delete('/deleteticket',[TicketingController::class, 'deleteTicket']);
        Route::patch('/approveticket',[TicketingController::class, 'approveTicket']);
        Route::patch('/rejectticket',[TicketingController::class, 'rejectTicket']);

        // Bidding
        Route::get('/bidding',[BiddingController::class, 'biddingView']);
        Route::get('/bidding/{ticket_code}',[BiddingController::class, 'biddingDetailView']);
        Route::get('/bidding/{ticket_code}/{item_code}',[BiddingController::class, 'vendorSelectionView']);

        // Purchase Requisition
        Route::get('/pr',[PRController::class, 'prView']);
});
