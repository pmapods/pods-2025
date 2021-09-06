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
use App\Http\Controllers\Masterdata\ArmadaController;

// Budget
use App\Http\Controllers\Budget\BudgetUploadController;
use App\Http\Controllers\Budget\ArmadaBudgetUploadController;
use App\Http\Controllers\Budget\AssumptionBudgetUploadController;

// Operational
use App\Http\Controllers\Operational\TicketingController;
use App\Http\Controllers\Operational\ArmadaTicketingController;
use App\Http\Controllers\Operational\SecurityTicketingController;
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
        Route::post('/addarmadavendor',[VendorController::class, 'addArmadaVendor']);
        Route::post('/deletearmadavendor',[VendorController::class, 'deleteArmadaVendor']);
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

    // Armada
    // Route::middleware(['menu_access:masterdata:256'])->group(function () {
        Route::get('/armada',[ArmadaController::class, 'armadaView']);
        Route::post('/addarmada',[ArmadaController::class, 'addArmada']);
        Route::post('/addarmadatype',[ArmadaController::class, 'addArmadaType']);
        Route::post('/deletearmadatype',[ArmadaController::class, 'deleteArmadaType']);
        Route::patch('/updatearmada',[ArmadaController::class, 'updateArmada']);
        Route::delete('/deletearmada',[ArmadaController::class, 'deleteArmada']);
    // });

    // OPERATIONAL
    // Pengadaan
    Route::middleware(['menu_access:operational:1'])->group(function () {
        // Barang Jasa
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

        // Armada
        Route::post('/createarmadaticket',[ArmadaTicketingController::class, 'createArmadaticket']);
        Route::get('/armadaticketing/{code}',[ArmadaTicketingController::class, 'armadaTicketDetail']);
        Route::post('/terminatearmadaticketing',[ArmadaTicketingController::class, 'terminateArmadaTicketing']);
        Route::post('/startarmadaauthorization',[ArmadaTicketingController::class, 'startArmadaAuthorization']);
        Route::post('/approvearmadaauthorization',[ArmadaTicketingController::class, 'approveArmadaAuthorization']);
        Route::post('/addfacilityform',[ArmadaTicketingController::class, 'addFacilityForm']);
        Route::post('/addperpanjanganform',[ArmadaTicketingController::class, 'addPerpanjanganForm']);
        Route::post('/addmutasiform',[ArmadaTicketingController::class, 'addMutasiForm']);
        Route::post('/completearmadabookedby',[ArmadaTicketingController::class, 'completeArmadaBookedBy']);
        Route::post('/approveperpanjanganform',[ArmadaTicketingController::class, 'approvePerpanjanganForm']);
        Route::post('/rejectperpanjanganform',[ArmadaTicketingController::class, 'rejectPerpanjanganForm']);
        Route::post('/approvefacilityform',[ArmadaTicketingController::class, 'approveFacilityForm']);
        Route::post('/rejectfacilityform',[ArmadaTicketingController::class, 'rejectFacilityForm']);
        Route::post('/approvemutasiform',[ArmadaTicketingController::class, 'approveMutasiForm']);
        Route::post('/rejectmutasiform',[ArmadaTicketingController::class, 'rejectMutasiForm']);
        Route::post('/uploadbastk',[ArmadaTicketingController::class, 'uploadBASTK']);
        Route::post('/uploadbastkgt',[ArmadaTicketingController::class, 'uploadBASTKGT']);
        Route::post('/verifyPO',[ArmadaTicketingController::class, 'verifyPO']);
        Route::get('/getActivePO',[POController::class, 'getActivePO']);
        Route::get('/getarmadatypebyniaga/{isNiaga}',[ArmadaController::class, 'getArmadaTypebyNiaga']);
        Route::get('/getArmadaAuthorizationbySalespoint/{salespoint_id}',[ArmadaController::class, 'getArmadaAuthorizationbySalespoint']);
        Route::get('/getSecurityAuthorizationbySalespoint/{salespoint_id}',[ArmadaController::class, 'getSecurityAuthorizationbySalespoint']);
        Route::get('/getarmada',[ArmadaController::class, 'getArmada']);
        Route::post('/terminateArmadaTicket',[ArmadaTicketingController::class, 'terminateArmadaTicket']);

        // Security
        Route::post('/createsecurityticket',[SecurityTicketingController::class, 'createSecurityTicket']);
        Route::get('/securityticketing/{code}',[SecurityTicketingController::class, 'securityTicketDetail']);
        Route::get('/getActivePO/security',[SecurityTicketingController::class, 'getActivePO']);
        Route::post('/terminatesecurityticketing',[SecurityTicketingController::class, 'terminateSecurityTicketing']);
        Route::post('/startsecurityauthorization',[SecurityTicketingController::class, 'startSecurityAuthorization']);
        Route::post('/addevaluasiform',[SecurityTicketingController::class, 'addEvaluasiForm']);
        Route::post('/approveevaluasiform',[SecurityTicketingController::class, 'approveEvaluasiForm']);
        Route::post('/rejectevaluasiform',[SecurityTicketingController::class, 'rejectEvaluasiForm']);
        Route::post('/approvesecurityauthorization',[SecurityTicketingController::class, 'approveSecurityAuthorization']);
        Route::post('/uploadsecuritylpb',[SecurityTicketingController::class, 'uploadSecurityLPB']);
        Route::post('/uploadsecurityendkontrak',[SecurityTicketingController::class, 'uploadSecurityEndKontrak']);
    });
    
    // BUDGET UPLOAD
    // inventory budget upload
    Route::get('/inventorybudget',[BudgetUploadController::class, 'inventoryBudgetView']);
    Route::get('/inventorybudget/create',[BudgetUploadController::class, 'addInventoryBudgetView']);
    Route::get('/inventorybudget/{budget_upload_code}',[BudgetUploadController::class, 'inventoryBudgetDetailView']);
    Route::post('/inventorybudget/approvebudgetauthorization',[BudgetUploadController::class, 'approveBudgetAuthorization']);
    Route::post('/inventorybudget/rejectbudgetauthorization',[BudgetUploadController::class, 'rejectBudgetAuthorization']);
    Route::post('/inventorybudget/reviseBudget',[BudgetUploadController::class, 'reviseBudget']);
    Route::post('/inventorybudget/terminateBudget',[BudgetUploadController::class, 'terminateBudget']);
    Route::get('/getActiveSalespointBudget',[BudgetUploadController::class, 'getActiveSalespointBudget']);
    Route::get('/getBudgetAuthorizationbySalespoint/{salespoint_id}',[BudgetUploadController::class, 'getBudgetAuthorizationbySalespoint']);
    Route::post('/createBudgetRequest',[BudgetUploadController::class, 'createBudgetRequest']);

    // armada budget upload
    Route::get('/armadabudget',[ArmadaBudgetUploadController::class, 'armadaBudgetView']);
    Route::get('/armadabudget/create',[ArmadaBudgetUploadController::class, 'addArmadaBudgetView']);
    Route::get('/armadabudget/{budget_upload_code}',[ArmadaBudgetUploadController::class, 'armadaBudgetDetailView']);
    Route::post('/armadabudget/approvebudgetauthorization',[ArmadaBudgetUploadController::class, 'approveBudgetAuthorization']);
    Route::post('/armadabudget/rejectbudgetauthorization',[ArmadaBudgetUploadController::class, 'rejectBudgetAuthorization']);
    Route::post('/armadabudget/reviseBudget',[ArmadaBudgetUploadController::class, 'reviseBudget']);
    Route::post('/armadabudget/terminateBudget',[ArmadaBudgetUploadController::class, 'terminateBudget']);
    // Route::get('/getActiveSalespointBudget',[ArmadaBudgetUploadController::class, 'getActiveSalespointBudget']);
    // Route::get('/getBudgetAuthorizationbySalespoint/{salespoint_id}',[ArmadaBudgetUploadController::class, 'getBudgetAuthorizationbySalespoint']);
    Route::post('/createBudgetRequest',[ArmadaBudgetUploadController::class, 'createBudgetRequest']);

    // assumption budget upload
    Route::get('/assumptionbudget',[AssumptionBudgetUploadController::class, 'assumptionBudgetView']);
    Route::get('/assumptionbudget/create',[AssumptionBudgetUploadController::class, 'addAssumptionBudgetView']);
    Route::get('/assumptionbudget/{budget_upload_code}',[AssumptionBudgetUploadController::class, 'assumptionBudgetDetailView']);
    Route::post('/assumptionbudget/approvebudgetauthorization',[AssumptionBudgetUploadController::class, 'approveBudgetAuthorization']);
    Route::post('/assumptionbudget/rejectbudgetauthorization',[AssumptionBudgetUploadController::class, 'rejectBudgetAuthorization']);
    Route::post('/assumptionbudget/reviseBudget',[AssumptionBudgetUploadController::class, 'reviseBudget']);
    Route::post('/assumptionbudget/terminateBudget',[AssumptionBudgetUploadController::class, 'terminateBudget']);
    // Route::get('/getActiveSalespointBudget',[AssumptionBudgetUploadController::class, 'getActiveSalespointBudget']);
    // Route::get('/getBudgetAuthorizationbySalespoint/{salespoint_id}',[AssumptionBudgetUploadController::class, 'getBudgetAuthorizationbySalespoint']);
    Route::post('/createBudgetRequest',[AssumptionBudgetUploadController::class, 'createBudgetRequest']);

    // Bidding
    Route::middleware(['menu_access:operational:2'])->group(function () {
        Route::get('/bidding',[BiddingController::class, 'biddingView']);
        Route::get('/bidding/printview/{encrypted_bidding_id}',[BiddingController::class, 'biddingPrintView']);
        Route::get('/bidding/{ticket_code}',[BiddingController::class, 'biddingDetailView']);
        Route::get('/bidding/{ticket_code}/{ticket_item_id}',[BiddingController::class, 'vendorSelectionView']);
        Route::patch('/confirmticketfilerequirement',[BiddingController::class, 'confirmFileRequirement']);
        Route::patch('/rejectticketfilerequirement',[BiddingController::class, 'rejectFileRequirement']);
        Route::delete('/removeticketitem',[BiddingController::class, 'removeTicketItem']);
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
        Route::get('/requestassetnumber/{ticket_id}/{pr_id}',[PRController::class, 'sendRequestAssetNumber']);
        Route::get('/printPR/{ticket_code}',[PRController::class, 'printPR']);
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
    Route::get('/ticketmonitoringlogs/{ticket_id}',[MonitoringController::class, 'ticketMonitoringLogs']);
    Route::get('/armadamonitoring',[MonitoringController::class, 'armadaMonitoringView']);
    Route::get('/armadamonitoringlogs/{po_number}',[MonitoringController::class, 'armadaMonitoringLogs']);
});
    // Purchase Order
    Route::get('/signpo/{po_upload_request_id}',[POController::class,'poUploadRequestView']);
    Route::post('/uploadsigneddocument',[POController::class,'poUploadRequest']);
