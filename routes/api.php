<?php

use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\StoreBalanceController;
use App\Http\Controllers\StoreBalanceHistoryController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('user', UserController::class);
    Route::get('user/all/paginated', [UserController::class, 'getAllPaginated']);

    Route::apiResource('store', StoreController::class);
    Route::get('store/all/paginated', [StoreController::class, 'getAllPaginated']);
    Route::post('store/{id}/verified', [StoreController::class, 'updateVerifiedStatus']);

    Route::apiResource('store-balance-history', StoreBalanceHistoryController::class);
    Route::get('store-balance-history/all/paginated', [StoreBalanceHistoryController::class, 'getAllPaginated']);

    Route::apiResource('store-balance', StoreBalanceController::class)->except(['store', 'update', 'destroy']);
    Route::get('store-balance/all/paginated', [StoreBalanceController::class, 'getAllPaginated']);

    Route::apiResource('withdrawal', \App\Http\Controllers\WithdrawalController::class)->except(['store', 'update', 'destroy']);
    Route::get('withdrawal/all/paginated', [\App\Http\Controllers\WithdrawalController::class, 'getAllPaginated']);
    Route::post('withdrawal/{id}/approve', [\App\Models\Withdrawal::class, 'approve']);

    Route::apiResource('buyer', \App\Http\Controllers\BuyerController::class);
    Route::get('buyer/all/paginated', [\App\Http\Controllers\BuyerController::class, 'getAllPaginated']);

    Route::apiResource('product-category', \App\Http\Controllers\ProductCategoryController::class);
    Route::get('product-category/all/paginated', [\App\Http\Controllers\ProductCategoryController::class, 'getAllPaginated']);
    Route::get('product-category/slug/{slug}', [\App\Http\Controllers\ProductCategoryController::class, 'showBySlug']);

    Route::apiResource('product', \App\Http\Controllers\ProductController::class);
    Route::get('product/all/paginated', [\App\Http\Controllers\ProductController::class, 'getAllPaginated']);
    Route::get('product/slug/{slug}', [\App\Http\Controllers\ProductController::class, 'showBySlug']);

    Route::apiResource('transaction', \App\Http\Controllers\TransactionController::class);
    Route::get('transaction/all/paginated', [\App\Http\Controllers\TransactionController::class, 'getAllPaginated']);
    Route::get('transaction/code/{code}', [\App\Http\Controllers\TransactionController::class, 'showByCode']);

    Route::post('product-review', [ProductReviewController::class, 'store']);
});

Route::get('/product-category', [\App\Http\Controllers\ProductCategoryController::class, 'index']);
Route::get('product-category/all/paginated', [\App\Http\Controllers\ProductCategoryController::class, 'getAllPaginated']);
Route::get('/product-category/slug/{slug}', [\App\Http\Controllers\ProductCategoryController::class, 'showBySlug']);

Route::get('/product', [\App\Http\Controllers\ProductController::class, 'index']);
Route::get('/product/all/paginated', [\App\Http\Controllers\ProductController::class, 'getAllPaginated']);
Route::get('/product/slug/{slug}', [\App\Http\Controllers\ProductController::class, 'showBySlug']);

Route::get('/store', [\App\Http\Controllers\StoreController::class, 'index']);

Route::get('/store/{store}', [\App\Http\Controllers\StoreController::class, 'show']);
