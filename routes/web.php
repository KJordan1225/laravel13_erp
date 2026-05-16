<?php

use App\Http\Controllers\Api\CustomerSearchController;
use App\Http\Controllers\Api\DashboardStatsController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\ProductSearchController;
use App\Http\Controllers\Api\SalesOrderApiController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SalesOrderController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\InventoryMovementController;
use App\Http\Controllers\Api\InventoryMovementApiController;
use App\Http\Controllers\Api\WarehouseSearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;


Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::middleware(['auth'])->prefix('api')->group(function () {
    Route::get('/dashboard/stats', DashboardStatsController::class)
        ->name('api.dashboard.stats');

    Route::get('/customers/search', CustomerSearchController::class)
        ->name('api.customers.search');

    Route::get('/products/search', ProductSearchController::class)
        ->name('api.products.search');

    Route::post('/sales-orders', [SalesOrderApiController::class, 'store'])
        ->name('api.sales-orders.store');

    Route::post('/invoices', [InvoiceApiController::class, 'store'])
        ->name('api.invoices.store');

    Route::resource('payments', PaymentController::class);

    Route::post('/inventory-movements', [InventoryMovementApiController::class, 'store'])
        ->name('api.inventory-movements.store');

    Route::get('/warehouses/search', WarehouseSearchController::class)
        ->name('api.warehouses.search');
});

Route::middleware(['auth'])->group(function () {
    Route::resource('sales-orders', SalesOrderController::class);

    Route::resource('invoices', InvoiceController::class);

    Route::resource('inventory-movements', InventoryMovementController::class);
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('warehouses', WarehouseController::class);
    Route::resource('customers', CustomerController::class);
    Route::resource('vendors', VendorController::class);
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::resource('purchase-orders', PurchaseOrderController::class);
    Route::resource('expenses', ExpenseController::class);
});

Route::middleware(['auth'])->get('/test-vue-selectors', function () {
    return view('test-vue-selectors');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('users', UserController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
});

require __DIR__.'/auth.php';
