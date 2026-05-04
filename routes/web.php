<?php

use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemSettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WalletController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('transactions', App\Http\Controllers\TransactionController::class);
    Route::resource('categories', App\Http\Controllers\CategoryController::class)->except(['create', 'show', 'edit', 'update']);
    Route::resource('wallets', WalletController::class)->only(['index', 'store', 'destroy']);
});

// User Routes
Route::resource('budgets', BudgetController::class);

// Category Routes
Route::resource('categories', CategoryController::class);

// Wallet Routes
Route::resource('wallets', WalletController::class);

// Admin Routes
Route::get('/admin/settings', [SystemSettingController::class, 'index'])->name('admin.settings');
Route::patch('/admin/settings/{id}', [SystemSettingController::class, 'update'])->name('admin.settings.update');
Route::post('/admin/users/{user}/toggle', [UserController::class, 'toggleStatus'])->name('admin.users.toggle');
Route::get('/admin/users', [App\Http\Controllers\UserController::class, 'index'])->name('admin.users.index');

require __DIR__.'/auth.php';
