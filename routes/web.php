<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ReimbursementController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\FinancialReportController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\AuditController;


/** Set sidebar active dynamic */
function set_active($route) {
    if(is_array($route)) {
        return in_array(Request::path(), $route) ? 'active' : '';
    }
    return Request::path() == $route ? 'active': '';
}

///////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//
//
//
///////////////////////////////////////////////////////////////////////////////////////////////////
// WITHOUT MICROSOFT AUTHENTICATION LOGIN
// ===============================================================================================
// THIS PART IS WITHOUT MICROSOFT LOGIN
// KEEP THE BELOW CODE UNCOMMENTED TO DISABLE MICROSOFT AUTHENTICATION
// COMMENT THIS PART OUT IF ENABLING MICROSOFT AUTHENTICATION
/////////////////////////////////////////////////////////////////////////////////////////////////

Route::get('/', function () {
    return redirect('/home');
});

Route::get('/offline', function () {
    return view('modules/laravelpwa/offline');
});

// Route for the reimbursement
Route::get('/reimbursements', [ReimbursementController::class, 'showReimbursement'])->name('reimbursement.index');
Route::post('/reimbursement', [ReimbursementController::class, 'store'])->name('reimbursement.add');
Route::get('/reimbursements/list', [ReimbursementController::class, 'list'])->name('reimbursement.list');

Route::post('/process-ocr', [ReimbursementController::class, 'processOCR'])->name('reimbursement.ocr');

// Route for testing the home controller
// Route::get('/testhome', [HomeController::class, 'index']);

// Routes for inventory management
Route::get('/inventory', [InventoryController::class, 'showInventory'])->name('inventory.index');
Route::get('/inventory/newitem', [InventoryController::class, 'loadNewInventoryItemForm'])->name('inventory.newitem'); 
Route::post('/inventory/newitem', [InventoryController::class, 'addInventoryItem'])->name('inventory.create');
Route::get('/inventory/{inventory_item}/edititem', [InventoryController::class, 'loadEditInventoryItemForm'])->name('inventory.edititem');
Route::put('/inventory/{inventory_item}', [InventoryController::class, 'updateInventoryItem'])->name('inventory.update');
Route::patch('inventory/{inventory_item}/increaseqty', [InventoryController::class, 'increaseItemQuantity'])->name('inventory.increaseitemqty');
Route::patch('inventory/{inventory_item}/decreaseqty', [InventoryController::class, 'decreaseItemQuantity'])->name('inventory.decreaseitemqty');
Route::delete('/inventory/{inventory_item}', [InventoryController::class, 'deleteInventoryItem'])->name('inventory.delete');

// Routes for vendors
Route::get('/vendor', [VendorController::class, 'showVendor'])->name('vendor.index');
Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.add');
Route::put('/vendor', [VendorController::class, 'update'])->name('vendor.update');

// Routes for customers
Route::get('/customer', [CustomerController::class, 'showCust'])->name('customer.index');
Route::post('/customer', [CustomerController::class, 'addCust'])->name('customer.add');
Route::put('/customer', [CustomerController::class, 'updateCust'])->name('customer.update');
Route::get('/customer/invoice', [CustomerController::class, 'custInvoice'])->name('customer.invoice');
Route::post('/customer/invoice', [CustomerController::class, 'addCustInvoice'])->name('customerinvoice.add');
Route::delete('/customer/{customer}', [CustomerController::class, 'deleteCust'])->name('customer.delete');

// Routes for billing
Route::get('/billing', [BillController::class, 'showList'])->name('billing.index');
Route::get('/billing/new', [BillController::class, 'loadNewBillForm'])->name('billing.new');
Route::post('/billing/new', [BillController::class, 'createNewBill'])->name('billing.create');
Route::get('/billing/download-pdf/{id}', [BillController::class, 'downloadPdf'])->name('billing.downloadPdf');

// Routes for financial report
Route::get('/financial-report', [FinancialReportController::class, 'showFinancialReport'])->name('financialreport.index');
Route::get('/financial-report/download-pdf', [FinancialReportController::class, 'downloadPdf'])->name('financialreport.downloadpdf');
Route::get('/financial-report/sales', [FinancialReportController::class, 'showSalesReport'])->name('financialreport.salesreport');
Route::get('/financial-report/vendor', [FinancialReportController::class, 'showVendorReport'])->name('financialreport.vendorreport');
Route::get('/financial-report/inventory', [FinancialReportController::class, 'showInventoryReport'])->name('financialreport.inventoryreport');

// Home controller routes
Route::controller(HomeController::class)->group(function () {
    Route::get('/home', 'index')->name('home');
    Route::get('/profile', 'profile')->name('profile');
});

Route::get('/audit', [AuditController::class, 'index'])->name('audit.index');
Route::post('/upload-csv', [AuditController::class, 'uploadCSV'])->name('upload.csv'); // Handle CSV upload

// Emailing route to send invoice email
Route::post('/send-invoice-email', [CustomerController::class, 'sendInvoiceEmail'])->name('send.invoice.email');
// -----------------------------login----------------------------------------//
// Route::controller(LoginController::class)->group(function () {
//     Route::get('/login', 'login')->name('login');
//     Route::post('/login', 'authenticate');
//     Route::get('/logout', 'logout')->name('logout');
// });

// Payment route to send vendor billing
Route::controller(BillController::class)->group(function(){
    Route::get('stripe/{id}', 'stripe');
    Route::post('stripe/{id}', 'stripePost')->name('stripe.post');

});





///////////////////////////////////////////////////////////////////////////////////////////////////
//
//
//
//
//
///////////////////////////////////////////////////////////////////////////////////////////////////
// WITH MICROSOFT AUTHENTICATION LOGIN
// ===============================================================================================
// THIS PART IS WITH MICROSOFT LOGIN
// KEEP THE BELOW CODE UNCOMMENTED TO ENABLE MICROSOFT AUTHENTICATION
// PLEASE ENSURE THAT MICROSOFT ENTRA IS CONFIGURED PROPERLY
// COMMENT THIS PART OUT IF DISABLING MICROSOFT AUTHENTICATION
///////////////////////////////////////////////////////////////////////////////////////////////////


// Redirect root to login
// Route::redirect('/', 'home');

// // Guest routes (for users who are not logged in)
// Route::group(['middleware' => ['guest']], function () {
//     Route::get('login', [AuthController::class, 'login'])->name('login');
//     Route::get('connect', [AuthController::class, 'connect'])->name('connect');
// });

// // Protected routes (only accessible by authenticated users)
// Route::group(['middleware' => ['auth']], function () {
    
//     // Home
//     Route::get('/home', [HomeController::class, 'index'])->name('home');
//     Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
//     Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

//     // Reimbursements
//     Route::get('/reimbursements', [ReimbursementController::class, 'showReimbursement'])->name('reimbursement.index');
//     Route::post('/reimbursement', [ReimbursementController::class, 'store'])->name('reimbursement.add');
//     Route::get('/reimbursements/list', [ReimbursementController::class, 'list'])->name('reimbursement.list');
//     Route::post('/process-ocr', [ReimbursementController::class, 'processOCR'])->name('reimbursement.ocr');

//     // Inventory
//     Route::get('/inventory', [InventoryController::class, 'showInventory'])->name('inventory.index');
//     Route::get('/inventory/newitem', [InventoryController::class, 'loadNewInventoryItemForm'])->name('inventory.newitem'); 
//     Route::post('/inventory/newitem', [InventoryController::class, 'addInventoryItem'])->name('inventory.create');
//     Route::get('/inventory/{inventory_item}/edititem', [InventoryController::class, 'loadEditInventoryItemForm'])->name('inventory.edititem');
//     Route::put('/inventory/{inventory_item}', [InventoryController::class, 'updateInventoryItem'])->name('inventory.update');
//     Route::patch('/inventory/{inventory_item}/increaseqty', [InventoryController::class, 'increaseItemQuantity'])->name('inventory.increaseitemqty');
//     Route::patch('/inventory/{inventory_item}/decreaseqty', [InventoryController::class, 'decreaseItemQuantity'])->name('inventory.decreaseitemqty');
//     Route::delete('/inventory/{inventory_item}', [InventoryController::class, 'deleteInventoryItem'])->name('inventory.delete');

//     // Vendors
//     Route::get('/vendor', [VendorController::class, 'showVendor'])->name('vendor.index');
//     Route::post('/vendor', [VendorController::class, 'store'])->name('vendor.add');
//     Route::put('/vendor', [VendorController::class, 'update'])->name('vendor.update');

//     // Customers
//     Route::get('/customer', [CustomerController::class, 'showCust'])->name('customer.index');
//     Route::post('/customer', [CustomerController::class, 'addCust'])->name('customer.add');
//     Route::put('/customer', [CustomerController::class, 'updateCust'])->name('customer.update');
//     Route::get('/customer/invoice', [CustomerController::class, 'custInvoice'])->name('customer.invoice');
//     Route::post('/customer/invoice', [CustomerController::class, 'addCustInvoice'])->name('customerinvoice.add');
//     Route::delete('/customer/{customer}', [CustomerController::class, 'deleteCust'])->name('customer.delete');

//     // Billing
//     Route::get('/billing', [BillController::class, 'showList'])->name('billing.index');
//     Route::get('/billing/new', [BillController::class, 'loadNewBillForm'])->name('billing.new');
//     Route::post('/billing/new', [BillController::class, 'createNewBill'])->name('billing.create');
//     Route::get('/billing/download-pdf/{id}', [BillController::class, 'downloadPdf'])->name('billing.downloadPdf');

//     // Financial Reports
//     Route::get('/financial-report', [FinancialReportController::class, 'showFinancialReport'])->name('financialreport.index');
//     Route::get('/financial-report/download-pdf', [FinancialReportController::class, 'downloadPdf'])->name('financialreport.downloadpdf');
//     Route::get('/financial-report/sales', [FinancialReportController::class, 'showSalesReport'])->name('financialreport.salesreport');
//     Route::get('/financial-report/vendor', [FinancialReportController::class, 'showVendorReport'])->name('financialreport.vendorreport');
//     Route::get('/financial-report/inventory', [FinancialReportController::class, 'showInventoryReport'])->name('financialreport.inventoryreport');

//     // Emailing
//     Route::post('/send-invoice-email', [CustomerController::class, 'sendInvoiceEmail'])->name('send.invoice.email');

//     // Stripe Payments
//     Route::get('stripe/{id}', [BillController::class, 'stripe']);
//     Route::post('stripe/{id}', [BillController::class, 'stripePost'])->name('stripe.post');

// });

// // Offline Page
// Route::get('/offline', function () {
//     return view('modules/laravelpwa/offline');
// });
