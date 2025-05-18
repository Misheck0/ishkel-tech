<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PayrollController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReceiptsController;
use App\Http\Controllers\SysAdminController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\AuditTrailController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/services', [HomeController::class, 'services'])->name('services');

Route::get('/auth/login',[UserController::class,'loginForm'])->name('login');
Route::post('/auth/login',[UserController::class,'login'])->name('auth.login');

//
Route::middleware(['auth'])->group(function () {
 Route::get('/user/dashboard',[UserController::class,'dashboard'])->name('dashboard');
 Route::get('/customer/suggest', [CustomerController::class, 'suggest'])->name('customer.suggest');

 Route::post('/invoice/store',[InvoiceController::class,'store'])->name('invoice.store');
 Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
 Route::get('invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
 Route::delete('/invoices/{invoice}', [InvoiceController::class, 'destroy'])->name('invoices.destroy');
 Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
 Route::get('/invoices/{invoice}/download', [InvoiceController::class, 'download'])->name('invoices.download');
 Route::post('/invoices/{invoice}/mark-paid', [InvoiceController::class, 'markPaid'])->name('invoices.mark-paid');
 Route::get('/admin/invoices/search', [InvoiceController::class, 'search'])->name('invoices.search');
 Route::get('admin/quotations', [InvoiceController::class, 'quotations'])->name('invoices.quotations');
 //search
 Route::get('/reports/export/pdf', [ReportController::class, 'exportPDF'])->name('reports.export.pdf');
 Route::get('/reports/export/excel', [ReportController::class, 'exportExcel'])->name('reports.export.excel');
 
 Route::get('/profile/edit', [UserController::class, 'showProfile'])->name('profile.edit');
 Route::put('/profile', [UserController::class, 'updateProfile'])->name('profile.update');
 //route for change password
 Route::put('/profile/change-password', [UserController::class, 'changePassword'])->name('profile.change-password');
 Route::get('/receipts/download/{id}', [ReceiptsController::class, 'download'])->name('receipts.download');
 Route::get('/receipt/invoices/{id}/pdf', [ReceiptsController::class, 'viewPaidInvoicePdf'])->name('invoices.pdf');
 Route::patch('/admin/user/{id}/toggle-status', [AdminController::class, 'toggleStatus'])->name('admin.toggleStatus');
 Route::patch('/admin/user/{id}/change-role', [AdminController::class, 'changeRole'])->name('admin.changeRole');
 
 //only admin can access this route
 Route::get('/admin/add-user', [AdminController::class, 'showAddUserForm'])->name('admin.addUserForm');
Route::post('/admin/add-user', [AdminController::class, 'addUser'])->name('admin.addUser');
Route::get('/admin/all-customers', [AdminController::class, 'AllCustomers'])->name('admin.allCustomers');
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
//kpi route
Route::get('/reports/kpi', [ReportController::class, 'kpi'])->name('reports.kpi');
Route::get('/admin/all-invoices', [AdminController::class, 'AllInvoices'])->name('admin.allInvoices');
//grant access customer 
Route::post('/customers/grant-access', [CustomerController::class, 'grantAccess'])->name('admin.customers.grant-access');

//Company route to view,edit and update
Route::get('/company-profile', [CompanyController::class, 'Profile'])->name('company.profile');
Route::get('/admin/company/edit/{id}',[CompanyController::class,'edit'])->name('companies.edit');
Route::put('/company/update/{id}',[CompanyController::class,'update'])->name('companies.update');

Route::put('/admin/invoice/{id}', [AdminController::class, 'updateInvoice'])->name('admin.invoice.update');
Route::put('/admin/invoice/{id}/items', [InvoiceController::class, 'updateInvoiceItems'])->name('admin.invoice.items.update');
Route::get('/admin/invoice/{id}/items', [InvoiceController::class, 'editInvoiceItems'])->name('admin.invoice.items.show');
//expensed route
Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');
Route::post('/expenses', [ExpenseController::class, 'store'])->name('expenses.store');
Route::get('/expenses/chart', [ExpenseController::class, 'chartData'])->name('expenses.chart');
Route::post('/invoice-orders/store', [InvoiceController::class, 'storeInvoiceOrders'])->name('invoice.orders.store');
Route::get('/invoice-orders/{id}', [InvoiceController::class, 'showInvoiceOrders'])->name('invoice.orders.show');
Route::get('/invoice-orders/create', [InvoiceController::class, 'createOrderForm'])->name('invoice.orders.create');

//logout route
Route::post('/auth/logout', [UserController::class, 'logout'])->name('auth.logout');

});

Route::prefix('customer')->middleware(['auth'])->group(function() {
    Route::get('/invoices', [CustomerController::class, 'index'])->name('customer.invoices.index');
    Route::get('/invoices/{invoice}', [CustomerController::class, 'show'])->name('customer.invoices.show');
    Route::get('/invoices/{invoice}/download', [CustomerController::class, 'download'])->name('customer.invoices.download');
});

//This are controllers for the IT manager
Route::middleware(['auth'])->group(function () {
    Route::get('/sysadmin',[SysAdminController::class,'dashboard'])->name('sysadmin.index');

    Route::get('audit-trails', [AuditTrailController::class, 'index'])->name('audit-trails.index');
    Route::get('audit-trails/{auditTrail}', [AuditTrailController::class, 'show'])->name('audit-trails.show');
    //company info
    Route::get('/sysadmin/companies', [CompanyController::class, 'index'])->name('companies.index');
Route::get('/sysadmin/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
Route::delete('/sysadmin/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
Route::resource('companies', CompanyController::class);
//add user to company
Route::post('/sysadmin/add/users',[SysAdminController::class,'addUser'])->name('admin.users.store');
Route::get('/users', [SysAdminController::class, 'index'])->name('sysadmin.allUsers');
    Route::post('/users/{user}/change-email', [SysAdminController::class, 'changeEmail'])->name('admin.users.change-email');
    Route::post('/users/{user}/reset-password', [SysAdminController::class, 'resetPassword'])->name('admin.users.reset-password');
    Route::post('/users/{user}/revoke', [SysAdminController::class, 'revoke'])->name('admin.users.revoke');
    Route::post('/users/{user}/activate', [SysAdminController::class, 'activate'])->name('admin.users.activate');
    Route::delete('/users/{user}', [SysAdminController::class, 'destroy'])->name('admin.users.destroy');
});


//payroll and att
// routes/web.php
Route::middleware(['auth'])->group(function () {
    // Payroll routes
    Route::get('/payroll', [PayrollController::class, 'index'])->name('payroll.index');
    Route::get('/payroll/create', [PayrollController::class, 'create'])->name('payroll.create');
    Route::get('/reports/expenses', [ExpenseController::class, 'report'])->name('reports.expenses');
    Route::get('/payroll/{payroll}', [PayrollController::class, 'show'])->name('payroll.show');
    Route::post('/payroll', [PayrollController::class, 'store'])->name('payroll.store');
    Route::post('/payroll/{payroll}/mark-paid', [PayrollController::class, 'markPaid'])->name('payroll.mark-paid');
//report
   Route::get('admin/payroll/report', [PayrollController::class, 'report'])->name('reports.payroll');
    Route::get('/attendance/report', [AttendanceController::class, 'report'])->name('reports.attendance');
    // Attendance routes
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('attendance.index');
    Route::post('/attendance', [AttendanceController::class, 'update'])->name('attendance.update');
});