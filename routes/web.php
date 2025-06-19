<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DekorinController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionApprovalController;

Route::get('/', function () {
    return view('welcome');
});

// Resource routes
Route::resource('users', UserController::class);
Route::resource('dekorins', DekorinController::class); // Ganti dari books ke dekorins
Route::resource('categories', CategoryController::class);

Route::resource('transactions', TransactionController::class)->only([
    'index',
    'edit',
    'update',
    'destroy'
]);

// Custom routes untuk approval saldo
Route::get('/saldo/approval', [TransactionApprovalController::class, 'index'])->name('transactions.approval');
Route::patch('/saldo/{id}/approve', [TransactionApprovalController::class, 'approve'])->name('transactions.approve');
Route::patch('/saldo/{id}/reject', [TransactionApprovalController::class, 'reject'])->name('transactions.reject');
Route::get('/dekorins', [DekorinController::class, 'index'])->name('dekorins.index');


//ini adalah kode perubahan

