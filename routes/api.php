<?php

use App\Http\Controllers\BuyerController;
use App\Http\Controllers\ProductCategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\StoreBalanceController;
use App\Http\Controllers\StoreBalanceHistoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WithdrawalController;
use Illuminate\Support\Facades\Route;

// User
Route::apiResource('user', UserController::class);
Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);

# Store
Route::apiResource('store', StoreController::class);
Route::get('store/all/paginated', [StoreController::class, 'getAllPaginated']);
Route::post('store/{id}/verified', [StoreController::class, 'updateVerifiedStatus']);

// StoreBalance
Route::apiResource('store-balance', StoreBalanceController::class)->except(['store', 'update', 'delete']);
Route::get('store-balance/all/paginated', [StoreBalanceController::class, 'getAllPaginated']);

// StoreBalanceHistory
Route::apiResource('store-balance-history', StoreBalanceHistoryController::class)->except(['store', 'update', 'delete']);
Route::get('store-balance-history/all/paginated', [StoreBalanceHistoryController::class, 'getAllPaginated']);

// Withdrawal
Route::apiResource('withdrawal', WithdrawalController::class)->except(['update', 'delete']);
Route::get('withdrawal/all/paginated', [WithdrawalController::class, 'getAllPaginated']);
Route::post('withdrawal/{id}/approve', [WithdrawalController::class, 'approve']);

// Buyer
Route::apiResource('buyer', BuyerController::class);
Route::get('buyer/all/paginated', [BuyerController::class, 'getAllPaginated']);

// ProductCategory
Route::apiResource('product-category', ProductCategoryController::class);
Route::get('product-category/all/paginated', [ProductCategoryController::class, 'getAllPaginated']);
Route::get('product-category/slug/{slug}', [ProductCategoryController::class, 'showBySlug']);

// Product
Route::apiResource('product', ProductController::class);
Route::get('product/all/paginated', [ProductController::class, 'getAllPaginated']);
Route::get('product/slug/{slug}', [ProductController::class, 'showBySlug']);

// Transaction
Route::apiResource('transaction', TransactionController::class);
Route::get('transaction/all/paginated', [TransactionController::class, 'getAllPaginated']);
Route::get('transaction/code/{code}', [TransactionController::class, 'showByCode']);

// ProductReview
Route::post('product-review', [ProductReviewController::class, 'store']);
