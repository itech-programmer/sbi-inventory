<?php

use App\Contracts\Product\ProductServiceInterface;
use app\Http\Controllers\Api\V1\CategoryController;
use app\Http\Controllers\Api\V1\ProductController;
use Illuminate\Support\Facades\Route;

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::post('export', function (ProductServiceInterface $service) {
        $service->exportToExcel();
        return response()->json(['status' => 'Export queued']);
    });
    Route::post('/', [ProductController::class, 'store']);
    Route::get('{product}', [ProductController::class, 'show']);
    Route::put('{product}', [ProductController::class, 'update']);
    Route::delete('{product}', [ProductController::class, 'destroy']);
});

Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::post('/', [CategoryController::class, 'store']);
    Route::get('{category}', [CategoryController::class, 'show']);
    Route::put('{category}', [CategoryController::class, 'update']);
    Route::delete('{category}', [CategoryController::class, 'destroy']);
});