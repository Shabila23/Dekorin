<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DekorinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionApprovalController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Admin\AuthController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);
Route::resource('dekorins', DekorinController::class);
Route::resource('categories', CategoryController::class);
Route::resource('transactions', TransactionController::class)->only(['index', 'edit', 'update', 'destroy']);

Route::get('/saldo/approval', [TransactionApprovalController::class, 'index'])->name('transactions.approval');
Route::patch('/saldo/{id}/approve', [TransactionApprovalController::class, 'approve'])->name('transactions.approve');
Route::patch('/saldo/{id}/reject', [TransactionApprovalController::class, 'reject'])->name('transactions.reject');

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');

    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', function () {
            return view('welcome', ['title' => 'Admin Dashboard']);
        })->name('admin.dashboard');

        Route::get('/create', [AdminController::class, 'create'])->name('admin.create');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
    });
});
