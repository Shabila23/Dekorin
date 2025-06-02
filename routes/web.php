<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\TransactionApprovalController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('users', UserController::class);
Route::resource('books', BookController::class);
Route::resource('categories', CategoryController::class);
Route::resource('transactions', TransactionController::class)->only([
    'index',
    'edit',
    'update',
    'destroy'
]);

Route::get('/saldo/approval', [TransactionApprovalController::class, 'index'])->name('transactions.approval');
Route::patch('/saldo/{id}/approve', [TransactionApprovalController::class, 'approve'])->name('transactions.approve');
Route::patch('/saldo/{id}/reject', [TransactionApprovalController::class, 'reject'])->name('transactions.reject');

//ini adalah kode perubahan
