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
use App\Http\Controllers\Masterdata\FileCompletementController;

// Operational
use App\Http\Controllers\Operational\TicketingController;
use App\Http\Controllers\Operational\BiddingController;
use App\Http\Controllers\Operational\PRController;
use App\Http\Controllers\Operational\POController;

// Monitoring
use App\Http\Controllers\Monitoring\MonitoringController;

Route::get('/', function () {
    return redirect('login');
});

//Auth
Route::get('/login', [LoginController::class, 'loginView'])->name('login');
Route::post('/doLogin',[LoginController::class, 'doLogin']);

Route::middleware(['auth'])->group(function () {
    // Auth
    Route::get('/changepassword',function(){
        return view('Auth.changepassword');
    });
    Route::patch('/updatepassword',[LoginController::class, 'updatePassword']);
    Route::get('/logout', function (){
        Auth::logout();
        return back();
    });
    
    Route::get('/dashboard',[DashboardController::class, 'dashboardView']);
    // MASTERDATA
    // Employee Postion
    Route::middleware(['menu_access:masterdata:1'])->group(function () {
        Route::get('/employeeposition',[EmployeeController::class, 'employeepostitionView']);
        Route::post('/addPosition',[EmployeeController::class, 'addEmployeePosition']);
        Route::patch('/updatePosition',[EmployeeController::class, 'updateEmployeePosition']);
        Route::delete('/deletePosition',[EmployeeController::class, 'deleteEmployeePosition']);
    });

    // Employee
    Route::middleware(['menu_access:masterdata:2'])->group(function () {
        Route::get('/employee',[EmployeeController::class, 'employeeView']);
        Route::post('/addEmployee',[EmployeeController::class, 'addEmployee']);
        Route::patch('/updateEmployee',[EmployeeController::class, 'updateEmployee']);
        Route::delete('/deleteemployee',[EmployeeController::class, 'deleteEmployee']);
        Route::patch('/nonactiveemployee',[EmployeeController::class, 'nonactiveEmployee']);
        Route::patch('/activeemployee',[EmployeeController::class, 'activeEmployee']);
    });
    
    // Sales Point
    Route::middleware(['menu_access:masterdata:4'])->group(function () {
        Route::get('/salespoint',[SalesPointController::class, 'salespointView']);
        Route::post('/addsalespoint',[SalesPointController::class, 'addSalesPoint']);
        Route::patch('/updatesalespoint',[SalesPointController::class, 'updateSalesPoint']);
        Route::delete('/deletesalespoint',[SalesPointController::class, 'deleteSalesPoint']);
    });

    // Employee Access
    Route::middleware(['menu_access:masterdata:8'])->group(function () {
        Route::get('/employeeaccess',[EmployeeAccessController::class, 'employeeaccessView']);
        Route::get('/employeeaccess/{employee_code}',[EmployeeAccessController::class, 'employeeaccessdetailView']);
        Route::patch('/updateemployeeaccessdetail',[EmployeeAccessController::class, 'updateemployeeaccessdetail']);
    });

    // Authorization
    Route::middleware(['menu_access:masterdata:16'])->group(function () {
        Route::get('/authorization',[AuthorizationController::class, 'authorizationView']);
        Route::get('/getauthorizedemployeebysalesPoint/{salespoint_id}',[AuthorizationController::class,'AuthorizedEmployeeBySalesPoint']);
        Route::post('/addauthorization',[AuthorizationController::class, 'addAuthorization']);
        Route::patch('/updateauthorization',[AuthorizationController::class, 'updateAuthorization']);
        Route::delete('/deleteauthorization',[AuthorizationController::class, 'deleteAuthorization']);
    });

    // VENDOR
    Route::middleware(['menu_access:masterdata:32'])->group(function () {
        Route::get('/vendor',[VendorController::class, 'vendorView']);
        Route::post('/addvendor',[VendorController::class, 'addVendor']);
        Route::patch('/updatevendor',[VendorController::class, 'updateVendor']);
        Route::delete('/deletevendor',[VendorController::class, 'deleteVendor']);
    });

    // Budget Pricing
    Route::middleware(['menu_access:masterdata:64'])->group(function () {
        Route::get('/budgetpricing',[BudgetPricingController::class, 'budgetpricingView']);
        Route::post('/addbudget',[BudgetPricingController::class, 'addBudget']);
        Route::patch('/updatebudget',[BudgetPricingController::class, 'updateBudget']);
        Route::delete('/deletebudget',[BudgetPricingController::class, 'deleteBudget']);
    });

    // Kelengkapan berkas
    Route::middleware(['menu_access:masterdata:128'])->group(function () {
        Route::get('/filecompletement',[FileCompletementController::class, 'fileCompletementView']);
    });

    // OPERATIONAL
    // Pengadaan Barang Jasa
    Route::middleware(['menu_access:operational:1'])->group(function () {
        Route::get('/ticketing',[TicketingController::class, 'ticketingView']);
        Route::get('/ticketing/{code}',[TicketingController::class, 'ticketingDetailView']);
        Route::get('/getsalespointauthorization/{salespoint_id}',[SalesPointController::class, 'getSalesAuthorization']);
        Route::get('/addnewticket',[TicketingController::class, 'addNewTicket']);
        Route::post('/addticket',[TicketingController::class, 'addTicket']);
        Route::patch('/startauthorization',[TicketingController::class, 'startAuthorization']);
        Route::delete('/deleteticket',[TicketingController::class, 'deleteTicket']);
        Route::patch('/approveticket',[TicketingController::class, 'approveTicket']);
        Route::patch('/rejectticket',[TicketingController::class, 'rejectTicket']);
        Route::patch('/uploadticketfilerevision',[TicketingController::class, 'uploadFileRevision']);
        Route::post('/uploadconfirmationfile',[TicketingController::class, 'uploadConfirmationFile']);
    });

    // Bidding
    Route::middleware(['menu_access:operational:2'])->group(function () {
        Route::get('/bidding',[BiddingController::class, 'biddingView']);
        Route::get('/bidding/{ticket_code}',[BiddingController::class, 'biddingDetailView']);
        Route::patch('/confirmticketfilerequirement',[BiddingController::class, 'confirmFileRequirement']);
        Route::patch('/rejectticketfilerequirement',[BiddingController::class, 'rejectFileRequirement']);
        Route::delete('/removeticketitem',[BiddingController::class, 'removeTicketItem']);
        Route::get('/bidding/{ticket_code}/{ticket_item_id}',[BiddingController::class, 'vendorSelectionView']);
        Route::post('/addbiddingform',[BiddingController::class, 'addBiddingForm']);
        Route::patch('/approvebidding',[BiddingController::class, 'approveBidding']);
        Route::patch('/rejectbidding',[BiddingController::class, 'rejectBidding']);
        Route::patch('/uploadsignedfile',[BiddingController::class, 'uploadSignedFile']);
        Route::patch('/terminateticket',[BiddingController::class, 'terminateTicket']);
    });

    // Purchase Requisition
    Route::middleware(['menu_access:operational:4'])->group(function () {
        Route::get('/pr',[PRController::class, 'prView']);
        Route::get('/pr/{ticket_code}',[PRController::class, 'prDetailView']);
        Route::post('/addnewpr',[PRController::class, 'addNewPR']);
        Route::patch('/approvepr',[PRController::class, 'approvePR']);
        Route::patch('/rejectpr',[PRController::class, 'rejectPR']);
        Route::post('/submitassetnumber',[PRController::class, 'submitAssetNumber']);
    });

    // Purchase Order
    Route::middleware(['menu_access:operational:8'])->group(function () {
        Route::get('/po',[POController::class, 'poView']);
        Route::get('/po/{ticket_code}',[POController::class, 'poDetailView']);
        Route::post('/setupPO',[POController::class, 'setupPO']);
        Route::post('/submitPO',[POController::class, 'submitPO']);
        Route::get('/printPO',[POController::class, 'printPO']);
        Route::patch('/uploadinternalsignedfile',[POController::class, 'uploadInternalSignedFile']);
        Route::patch('/rejectposigned',[POController::class, 'rejectPosigned']);
        Route::patch('/confirmposigned',[POController::class, 'confirmPosigned']);
        Route::post('/sendemail',[POController::class, 'sendEmail']);
    });

    // MONITORING
    Route::get('/ticketmonitoring',[MonitoringController::class, 'ticketMonitoringView']);
});
    // Purchase Order
    Route::get('/signpo/{po_upload_request_id}',[POController::class,'poUploadRequestView']);
    Route::post('/uploadsigneddocument',[POController::class,'poUploadRequest']);
