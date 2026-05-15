<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Api\DashboardStatsController;
use App\Http\Controllers\Api\CustomerSearchController;
use App\Http\Controllers\Api\ProductSearchController;

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
});

Route::middleware(['auth'])->get('/test-vue-selectors', function () {
    return view('test-vue-selectors');
});



require __DIR__.'/auth.php';
