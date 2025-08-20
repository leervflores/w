<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\SuperAdminController;
use App\Http\Controllers\CustomerUserController;
use App\Http\Controllers\DriverVerificationController;

// Redirect root to login
Route::get('/', function () {
    return redirect()->route('admin.login');
});

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');

    Route::get('/admin/register', [AdminAuthController::class, 'showRegisterForm'])->name('admin.register');
    Route::post('/admin/register', [AdminAuthController::class, 'store'])->name('admin.register.store');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/drivers/pending', [DriverVerificationController::class, 'pending'])->name('drivers.pending');
    Route::post('/drivers/{id}/approve', [DriverVerificationController::class, 'approve'])->name('drivers.approve');
    Route::post('/drivers/{id}/reject', [DriverVerificationController::class, 'reject'])->name('drivers.reject');
    Route::post('/drivers/{id}/request-changes', [DriverVerificationController::class, 'requestChanges'])->name('drivers.requestChanges');
});
Route::middleware(['auth'])->group(function () {
    Route::get('/driver/register', [DriverController::class, 'create'])->name('driver.register');
    Route::post('/driver/register', [DriverController::class, 'store'])->name('driver.store');
    Route::get('/driver/status', [DriverController::class, 'status'])->name('driver.status');
});

// Admin routes
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/drivers/pending', [DriverVerificationController::class, 'pending'])->name('drivers.pending');
    Route::post('/drivers/{id}/approve', [DriverVerificationController::class, 'approve'])->name('drivers.approve');
    Route::post('/drivers/{id}/reject', [DriverVerificationController::class, 'reject'])->name('drivers.reject');
    Route::post('/drivers/{id}/request-changes', [DriverVerificationController::class, 'requestChanges'])->name('drivers.requestChanges');
});

// Authenticated routes
Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        $user = Auth::user();
        if ($user->role === 'suspended') {
            return view('suspended.index');
        }
        return redirect()->route('superadmin.dashboard');
    })->name('admin.dashboard');

    // CustomerUser CRUD
    Route::get('/customer_user', [CustomerUserController::class, 'index'])->name('customer_user.index');
    Route::get('/customer_user/{id}/edit', [CustomerUserController::class, 'edit'])->name('customer_user.edit');
    Route::put('/customer_user/{id}', [CustomerUserController::class, 'update'])->name('customer_user.update');
    Route::post('/customer_user', [CustomerUserController::class, 'store'])->name('customer_user.store');
    Route::delete('/customer_user/{id}', [CustomerUserController::class, 'destroy'])->name('customer_user.destroy');

    // SuperAdmin dashboard
    Route::prefix('superadmin')->group(function () {
        Route::get('/', [SuperAdminController::class, 'index'])->name('superadmin.dashboard');
        Route::post('/user', [SuperAdminController::class, 'store'])->name('superadmin.store');
        Route::put('/user/{id}', [SuperAdminController::class, 'update'])->name('superadmin.update');
        Route::delete('/user/{id}', [SuperAdminController::class, 'destroy'])->name('superadmin.destroy');

        Route::post('/customer', [SuperAdminController::class, 'storeCustomer'])->name('superadmin.storeCustomer');
        Route::put('/customer/{id}', [SuperAdminController::class, 'updateCustomer'])->name('superadmin.updateCustomer');
        Route::delete('/customer/{id}', [SuperAdminController::class, 'destroyCustomer'])->name('superadmin.destroyCustomer');
    });

    // Logout
    Route::post('/logout', function () {
        Auth::logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();
        return redirect()->route('admin.login');
    })->name('logout');
});
