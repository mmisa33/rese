<?php

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\User\MypageController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\ReviewController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OwnerController;

use Illuminate\Support\Facades\Route;

// メール認証チェック
Route::get('/verify/check', [AuthController::class, 'verifyCheck'])->name('verify.check');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search', [ShopController::class, 'index'])->name('shop.search');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');

Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'create'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'store'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

Route::middleware(['auth', 'verified', 'role:user'])->group(function () {
    Route::post('/like/{shop_id}', [ShopController::class, 'toggleLike'])->name('shop.like');
    Route::post('/done', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/done', [ReservationController::class, 'done'])->name('reservation.done');

    Route::get('/mypage', [MypageController::class, 'mypage'])->name('mypage');
    Route::delete('/reservation/{id}', [ReservationController::class, 'destroy'])->name('reservation.destroy');
    Route::get('/reservation/{id}/edit', [ReservationController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservation/{id}', [ReservationController::class, 'update'])->name('reservation.update');

    // 評価ページ表示・保存
    Route::get('/review/{reservation_id}', [ReviewController::class, 'create'])->name('review.create');
    Route::post('/review/{reservation_id}', [ReviewController::class, 'store'])->name('review.store');
});

// 管理者用
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/owner/create', [OwnerController::class, 'create'])->name('admin.owner.create');
    Route::post('/owner', [OwnerController::class, 'store'])->name('admin.owner.store');
    Route::get('/owner/{owner}', [OwnerController::class, 'show'])->name('admin.owner.show');
});

// 店舗代表者用
Route::middleware(['auth', 'role:owner'])->group(function () {
    // 利用者用マイページなど
    // Route::get('/owner/dashboard', [OwnerController::class, 'dashboard'])->name('owner.dashboard');
});