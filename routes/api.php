<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserApiController;

Route::post('/login-user', [UserApiController::class, 'login_user']);
Route::post('/register-user', [UserApiController::class, 'register_user']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [UserApiController::class, 'logout']);
    Route::get('/profile', [UserApiController::class, 'profile']);
    Route::post('/top-up', [UserApiController::class, 'topUpSaldo']);
    Route::get('/books', [UserApiController::class, 'getBooks']);
    Route::get('/book/{id}', [UserApiController::class, 'getBookById']);
    Route::get('/books/category/{category_name}', [UserApiController::class, 'getBooksByCategory']);
    Route::get('/books/purchased/{user_id}', [UserApiController::class, 'getPurchasedBooksByUser']);
    Route::get('/transactions/user/{user_id}', [UserApiController::class, 'getTransactionsByUser']);
    Route::post('/transactions/payment', [UserApiController::class, 'purchaseBook']);

    Route::get('/categories', [UserApiController::class, 'getCategories']);

    Route::get('/check-token', function (Request $request) {
        return response()->json([
            'status' => 'success',
            'message' => 'Token valid',
            'user' => $request->user()
        ]);
    });


});
