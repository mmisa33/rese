<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

// メール認証チェック
Route::get('/verify/check', [AuthController::class, 'verifyCheck'])->name('verify.check');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search', [ShopController::class, 'index'])->name('shop.search');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/like/{shop_id}', [ShopController::class, 'toggleLike'])->name('shop.like');
    Route::post('/done', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/done', [ReservationController::class, 'done'])->name('reservation.done');

    Route::get('/mypage', [UserController::class, 'mypage'])->name('mypage');
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');
});