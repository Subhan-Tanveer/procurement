<?php

use App\Http\Controllers\Supplier\AuthController as SupplierAuthController;
use App\Http\Controllers\Supplier\DashboardController;
use App\Http\Controllers\Supplier\ProductController as SupplierProductController;
use App\Http\Controllers\Supplier\MediaController as SupplierMediaController;
use Illuminate\Support\Facades\Route;

// ── Supplier Application Intake (guest only) ───────────────────────────────
Route::middleware('guest')->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/register', [SupplierAuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [SupplierAuthController::class, 'register'])->middleware('throttle:5,1');
    Route::get('/success', [SupplierAuthController::class, 'success'])->name('success');
});

// ── Legacy Supplier Holding Page (auth, any status) ────────────────────────
Route::middleware('auth')->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/pending', [SupplierAuthController::class, 'pending'])->name('pending');
});

// ── Supplier Portal (auth + approved supplier) ──────────────────────────────
Route::middleware(['auth', 'supplier.access'])->prefix('supplier')->name('supplier.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/products',          [SupplierProductController::class, 'index'])->name('products.index');
    Route::get('/products/create',   [SupplierProductController::class, 'create'])->name('products.create');
    Route::post('/products',         [SupplierProductController::class, 'store'])->name('products.store');
    Route::get('/products/{id}',     [SupplierProductController::class, 'show'])->name('products.show');
    Route::get('/products/{id}/edit',[SupplierProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{id}',     [SupplierProductController::class, 'update'])->name('products.update');

    Route::post('/media/upload', [SupplierMediaController::class, 'upload'])->name('media.upload');
    Route::get('/media',         [SupplierMediaController::class, 'index'])->name('media.index');
});
