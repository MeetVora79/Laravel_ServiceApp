<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EnduserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EngineerController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\FieldinfoController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/register', [AuthController::class, 'loadRegister']);
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/', [AuthController::class, 'loadLogin']);
Route::get('/login', [AuthController::class, 'loadLogin']);
Route::post('/user/login', [AuthController::class, 'login'])->name('login');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::group(['prefix' => 'admin', 'middleware' => ['web', 'isAdmin']], function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::group(['prefix' => 'employee', 'middleware' => ['web', 'isEmployee']], function () {
    Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('employee.dashboard');
});

Route::group(['prefix' => 'engineer', 'middleware' => ['web', 'isEngineer']], function () {
    Route::get('/dashboard', [EngineerController::class, 'dashboard'])->name('engineer.dashboard');
});

Route::group(['prefix' => 'enduser', 'middleware' => ['web', 'isEnduser']], function () {
    Route::get('/dashboard', [EnduserController::class, 'dashboard'])->name('enduser.dashboard');
});


// Routes for Reset-Password
Route::get('/forgot-password', [App\Http\Controllers\AuthController::class, 'forgotPassword'])->name('forgotpassword');
Route::post('/set-password', [App\Http\Controllers\AuthController::class, 'setPassword'])->name('setpwd');


// Routes for Profile
Route::get('/profile', [App\Http\Controllers\HomeController::class, 'profile'])->name('profile');
Route::put('/update-profile', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');


// Routes for User
Route::group(['prefix' => 'staff'], function () {
    Route::get('/', [App\Http\Controllers\StaffController::class, 'index'])->name('users.index');
    Route::get('/create/new', [App\Http\Controllers\StaffController::class, 'create'])->name('users.create');
    Route::post('/store', [App\Http\Controllers\StaffController::class, 'store'])->name('users.store');
    Route::get('/info/{StaffId}', [App\Http\Controllers\StaffController::class, 'show'])->name('users.show');
    Route::get('/edit/{StaffId}', [App\Http\Controllers\StaffController::class, 'edit'])->name('users.edit');
    Route::put('/update/{StaffId}', [App\Http\Controllers\StaffController::class, 'update'])->name('users.update');
    Route::delete('/destroy/{StaffId}', [App\Http\Controllers\StaffController::class, 'destroy'])->name('users.destroy');
});


// Routes for Departments
Route::group(['prefix' => 'departments'], function () {
    Route::get('/', [App\Http\Controllers\DepartmentController::class, 'index'])->name('departments.index');
    Route::get('/create/new', [App\Http\Controllers\DepartmentController::class, 'create'])->name('departments.create');
    Route::post('/store', [App\Http\Controllers\DepartmentController::class, 'store'])->name('departments.store');
    Route::get('/info/{DepartmentId}', [App\Http\Controllers\DepartmentController::class, 'show'])->name('departments.show');
    Route::get('/edit/{DepartmentId}', [App\Http\Controllers\DepartmentController::class, 'edit'])->name('departments.edit');
    Route::put('/update/{DepartmentId}', [App\Http\Controllers\DepartmentController::class, 'update'])->name('departments.update');
    Route::delete('/destroy/{DepartmentId}', [App\Http\Controllers\DepartmentController::class, 'destroy'])->name('departments.destroy');
});


// Routes for Organization
Route::group(['prefix' => 'organization'], function () {
    Route::get('/', [App\Http\Controllers\OrganizationController::class, 'index'])->name('organizations.index');
    Route::get('/create/new', [App\Http\Controllers\OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('/store', [App\Http\Controllers\OrganizationController::class, 'store'])->name('organizations.store');
    Route::get('/info/{OrganizationId}', [App\Http\Controllers\OrganizationController::class, 'show'])->name('organizations.show');
    Route::get('/edit/{OrganizationId}', [App\Http\Controllers\OrganizationController::class, 'edit'])->name('organizations.edit');
    Route::put('/update/{OrganizationId}', [App\Http\Controllers\OrganizationController::class, 'update'])->name('organizations.update');
    Route::delete('/destroy/{OrganizationId}', [App\Http\Controllers\OrganizationController::class, 'destroy'])->name('organizations.destroy');
});


// Routes for Customer
Route::group(['prefix' => 'customers'], function () {
    Route::get('/', [App\Http\Controllers\CustomerController::class, 'index'])->name('customers.index');
    Route::get('/create/new', [App\Http\Controllers\CustomerController::class, 'create'])->name('customers.create');
    Route::post('/store', [App\Http\Controllers\CustomerController::class, 'store'])->name('customers.store');
    Route::get('/info/{CustomerId}', [App\Http\Controllers\CustomerController::class, 'show'])->name('customers.show');
    Route::get('/edit/{CustomerId}', [App\Http\Controllers\CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/update/{CustomerId}', [App\Http\Controllers\CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/destroy/{CustomerId}', [App\Http\Controllers\CustomerController::class, 'destroy'])->name('customers.destroy');
});


// Routes For Tickets
Route::group([], function () {
    Route::get('/tickets/create', [App\Http\Controllers\TicketController::class, 'create'])->name('tickets.create');
    Route::get('/tickets/myticket/create', [App\Http\Controllers\TicketController::class, 'mycreate'])->name('tickets.mycreate');
    Route::get('/tickets/edit/{TicketId}', [App\Http\Controllers\TicketController::class, 'myedit'])->name('tickets.myedit');
    Route::get('/tickets/{TicketId}', [App\Http\Controllers\TicketController::class, 'show'])->name('tickets.view');
    Route::get('/mytickets/{TicketId}', [App\Http\Controllers\TicketController::class, 'myshow'])->name('myshow');
    Route::post('/new/myticket/store', [App\Http\Controllers\TicketController::class, 'mystore'])->name('mystore');
    Route::put('/new/myticket/update/{TicketId}', [App\Http\Controllers\TicketController::class, 'myupdate'])->name('myupdate');
    Route::get('/mytickets', [App\Http\Controllers\TicketController::class, 'myTickets'])->name('mytickets');
    Route::delete('/mytickets/delete/{TicketId}', [App\Http\Controllers\TicketController::class, 'deleteTickets'])->name('myticketsdestroy');
    Route::get('/tickets/assign/{TicketId}', [App\Http\Controllers\TicketController::class, 'assign'])->name('tickets.assign');
    Route::get('/tickets/editAllocation/{AllocationId}', [App\Http\Controllers\TicketController::class, 'editassign'])->name('tickets.editassign');
    Route::post('/tickets/assignee', [App\Http\Controllers\TicketController::class, 'assigneestore'])->name('tickets.assignee');
    Route::put('/allocation/update/{AllocationId}', [App\Http\Controllers\TicketController::class, 'assigneeupdate'])->name('tickets.assignupdate');
    Route::get('/tickets/assigned/list', [App\Http\Controllers\TicketController::class, 'allocation'])->name('tickets.allocation');
    Route::get('/tickets/myallocation/list', [App\Http\Controllers\TicketController::class, 'myAllocation'])->name('myallocation');
    Route::get('/tickets/onfield/{AllocationId}', [App\Http\Controllers\FieldinfoController::class, 'showAllocation'])->name('tickets.onfield');
    Route::delete('/Allocation/delete', [App\Http\Controllers\TicketController::class, 'delete'])->name('tickets.allocationDelete');
    Route::get('/update/{ticket}/status/{status}', [App\Http\Controllers\TicketController::class, 'updateStatus'])->name('update.status');
    Route::get('/change/{ticket}/{status}', [App\Http\Controllers\FieldinfoController::class, 'statusUpdate'])->name('changeStatus');
    Route::get('/change/{ticket}/mystatus/{status}', [App\Http\Controllers\FieldinfoController::class, 'myStatusUpdate'])->name('myStatusChange');
});


// Routes for Assets
Route::group(['prefix' => 'assets'], function () {
    Route::get('/', [App\Http\Controllers\AssetController::class, 'index'])->name('assets.index');
    Route::get('/myassets/list', [App\Http\Controllers\AssetController::class, 'myAssets'])->name('assets.myassets');
    Route::get('/create/new', [App\Http\Controllers\AssetController::class, 'create'])->name('assets.create');
    Route::post('/store', [App\Http\Controllers\AssetController::class, 'store'])->name('assets.store');
    Route::get('/info/{AssetId}', [App\Http\Controllers\AssetController::class, 'show'])->name('assets.show');
    Route::get('/edit/{AssetId}', [App\Http\Controllers\AssetController::class, 'edit'])->name('assets.edit');
    Route::put('/update/{AssetId}', [App\Http\Controllers\AssetController::class, 'update'])->name('assets.update');
    Route::delete('/destroy/{AssetId}', [App\Http\Controllers\AssetController::class, 'destroy'])->name('assets.destroy');
});

    // Routes for AssetType
    Route::get('/new/type', [App\Http\Controllers\AssettypeController::class, 'create'])->name('assettype.create');
    Route::post('/type/store', [App\Http\Controllers\AssettypeController::class, 'store'])->name('storeAssetType');
    Route::get('/type/edit/{AssetTypeId}', [App\Http\Controllers\AssettypeController::class, 'edit'])->name('editAssetType');
    Route::put('/type/update/{AssetTypeId}', [App\Http\Controllers\AssettypeController::class, 'update'])->name('updateAssetType');
    Route::delete('/type/delete/{AssetTypeId}', [App\Http\Controllers\AssettypeController::class, 'destroy'])->name('deleteAssetType');


// Routes for Maintenance
Route::group(['prefix' => 'maintenance'], function () {
    Route::get('/', [App\Http\Controllers\MaintenanceController::class, 'index'])->name('maintenance.index');
    Route::get('/mymaintenance/list', [App\Http\Controllers\MaintenanceController::class, 'myMaintenance'])->name('mymaintenance');
    Route::get('/scheduled/list', [App\Http\Controllers\MaintenanceController::class, 'scheduled'])->name('maintenance.scheduled');
    Route::get('/myscheduled/list', [App\Http\Controllers\MaintenanceController::class, 'mySchedule'])->name('myschedule');
    Route::get('/create/{AssetId}', [App\Http\Controllers\MaintenanceController::class, 'create'])->name('maintenance.create');
    Route::post('/store', [App\Http\Controllers\MaintenanceController::class, 'store'])->name('maintenance.store');
    Route::get('/info/{ScheduleId}', [App\Http\Controllers\MaintenanceController::class, 'show'])->name('maintenance.show');
    Route::get('/edit/{ScheduleId}', [App\Http\Controllers\MaintenanceController::class, 'edit'])->name('maintenance.edit');
    Route::put('/update/{ScheduleId}', [App\Http\Controllers\MaintenanceController::class, 'update'])->name('maintenance.update');
    Route::delete('/destroy/{ScheduleId}', [App\Http\Controllers\MaintenanceController::class, 'destroy'])->name('maintenance.destroy');
    Route::get('/{schedule}/{status}', [App\Http\Controllers\MaintenanceController::class, 'updateStatus'])->name('maintenanceStatus');
    Route::get('/{schedule}/status/{status}', [App\Http\Controllers\MaintenanceController::class, 'statusUpdate'])->name('StatusUpdate');
});


// Routes for Role List
Route::group(['prefix' => 'roles'], function () {
    Route::get('/', [App\Http\Controllers\RoleController::class, 'index'])->name('roles.index');
    Route::get('/create/new', [App\Http\Controllers\RoleController::class, 'create'])->name('roles.create');
    Route::post('/store', [App\Http\Controllers\RoleController::class, 'store'])->name('roles.store');
    Route::get('/info/{id}', [App\Http\Controllers\RoleController::class, 'show'])->name('roles.show');
    Route::get('/edit/{id}', [App\Http\Controllers\RoleController::class, 'edit'])->name('roles.edit');
    Route::put('/update/{id}', [App\Http\Controllers\RoleController::class, 'update'])->name('roles.update');
    Route::delete('/destroy/{id}', [App\Http\Controllers\RoleController::class, 'destroy'])->name('roles.destroy');
});


// Routes for Permission List
Route::group(['prefix' => 'permissions'], function () {
    Route::get('/', [App\Http\Controllers\PermissionController::class, 'index'])->name('permissions.index');
    Route::get('/create/new', [App\Http\Controllers\PermissionController::class, 'create'])->name('permissions.create');
    Route::post('/store', [App\Http\Controllers\PermissionController::class, 'store'])->name('permissions.store');
    Route::get('/info/{id}', [App\Http\Controllers\PermissionController::class, 'show'])->name('permissions.show');
    Route::get('/edit/{id}', [App\Http\Controllers\PermissionController::class, 'edit'])->name('permissions.edit');
    Route::put('/update/{id}', [App\Http\Controllers\PermissionController::class, 'update'])->name('permissions.update');
    Route::delete('/destroy/{id}', [App\Http\Controllers\PermissionController::class, 'destroy'])->name('permissions.destroy');
});


// Routes for Report
Route::group(['prefix' => 'reports'], function () {
    Route::get('/', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');
    Route::post('/statistics/generate/file', [App\Http\Controllers\ReportController::class, 'generateReport'])->name('reports.generate');
});


// Resources for Ticket
Route::resources([
    'tickets' => TicketController::class,
    'fieldinfos' => FieldinfoController::class,
]);
