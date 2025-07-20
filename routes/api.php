<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderController;

Route::prefix('orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store']);
    Route::post('{order}/advance', [OrderController::class, 'advance']);
    Route::get('{order}', [OrderController::class, 'show']);
});
