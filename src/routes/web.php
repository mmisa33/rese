<?php

use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ShopController::class, 'index'])->name('shops.index');
Route::get('/search', [ShopController::class, 'index'])->name('shops.search');

Route::middleware(['auth'])->group(function () {
    Route::post('/like/{shop_id}', [ShopController::class, 'toggleLike'])->name('shops.like');
});

Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');
