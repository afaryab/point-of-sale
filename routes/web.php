<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CounterController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\WebhookController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Counter routes
    Route::resource('counters', CounterController::class);
    Route::post('/counters/{counter}/open', [CounterController::class, 'open'])->name('counters.open');
    Route::post('/counters/{counter}/close', [CounterController::class, 'close'])->name('counters.close');
    
    // Product, Service, Plan routes
    Route::resource('products', ProductController::class);
    Route::resource('services', ServiceController::class);
    Route::resource('plans', PlanController::class);
    
    // Appointments
    Route::resource('appointments', AppointmentController::class);
    
    // Billing
    Route::resource('bills', BillController::class);
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'verified'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('service-providers', ServiceProviderController::class);
    Route::resource('settings', SettingController::class);
    Route::resource('webhooks', WebhookController::class);
});

require __DIR__.'/auth.php';
