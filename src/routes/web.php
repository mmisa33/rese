<?php

use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search', [ShopController::class, 'index'])->name('shop.search');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');

Route::middleware(['auth'])->group(function () {
    Route::post('/like/{shop_id}', [ShopController::class, 'toggleLike'])->name('shop.like');
    Route::post('/done', [ReservationController::class, 'store'])->name('reservation.store');
});
