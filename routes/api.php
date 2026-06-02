<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'message' => 'API La Bambucha funcionando correctamente',
        'timestamp' => now()->toDateTimeString(),
    ]);
});

// Rutas de Productos
Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index'])->name('products.index');
    Route::get('/{id}', [ProductController::class, 'show'])->name('products.show');
    Route::get('/category/{category}', [ProductController::class, 'byCategory'])->name('products.category');
    
    // Rutas protegidas (se pueden agregar middleware auth después)
    Route::post('/', [ProductController::class, 'store'])->name('products.store');
    Route::put('/{id}', [ProductController::class, 'update'])->name('products.update');
    Route::delete('/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
});

// Rutas de Pedidos
Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::get('/statistics/summary', [OrderController::class, 'statistics'])->name('orders.statistics');
    
    Route::post('/', [OrderController::class, 'store'])->name('orders.store');
    Route::put('/{id}/status', [OrderController::class, 'updateStatus'])->name('orders.updateStatus');
    Route::delete('/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
