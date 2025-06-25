<?php

use App\Http\Controllers\Auth\AuthController;

use App\Http\Controllers\User\MypageController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\User\ReservationController;
use App\Http\Controllers\User\ReviewController;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\OwnerController as AdminOwnerController;
use App\Http\Controllers\Admin\NoticeMailController;

use App\Http\Controllers\Owner\OwnerController as ShopOwnerController;
use App\Http\Controllers\Owner\NoticeMailController as OwnerNoticeMailController;
use App\Http\Controllers\Owner\ReservationController as OwnerReservationController;

use Illuminate\Support\Facades\Route;

// メール認証チェック
Route::get('/verify/check', [AuthController::class, 'verifyCheck'])->name('verify.check');

Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/search', [ShopController::class, 'index'])->name('shop.search');
Route::get('/detail/{shop_id}', [ShopController::class, 'show'])->name('shop.show');

// 管理者用ログイン
Route::prefix('admin')->group(function () {
    Route::get('/login', [AuthController::class, 'createAdminLogin'])->name('admin.login');
    Route::post('/login', [AuthController::class, 'storeAdminLogin'])->name('admin.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout');
});

// 店舗代表者用ログイン
Route::prefix('owner')->group(function () {
    Route::get('/login', [AuthController::class, 'createOwnerLogin'])->name('owner.login');
    Route::post('/login', [AuthController::class, 'storeOwnerLogin'])->name('owner.login.submit');
    Route::post('/logout', [AuthController::class, 'logout'])->name('owner.logout');
});

// 一般ユーザー用
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

    // 決済処理
    Route::post('/reservation/with-payment', [ReservationController::class, 'storeWithPayment'])->name('reservation.with.payment');
    Route::get('/reservation/payment/success', [ReservationController::class, 'paymentSuccess'])->name('reservation.payment.success');

    Route::get('/reservation/verify/{id}', [ReservationController::class, 'verify'])->name('reservation.verify');

    Route::get('/thanks', [AuthController::class, 'thanks'])->name('thanks');
});

// 管理者用
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {
    Route::get('/index', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/owner/create', [AdminOwnerController::class, 'create'])->name('admin.owner.create');
    Route::post('/owner', [AdminOwnerController::class, 'store'])->name('admin.owner.store');
    Route::get('/owner/{owner}', [AdminOwnerController::class, 'show'])->name('admin.owner.show');
    Route::put('/owner/{owner}', [AdminOwnerController::class, 'update'])->name('admin.owner.update');
    Route::delete('/owner/{owner}', [AdminOwnerController::class, 'destroy'])->name('admin.owner.destroy');
    Route::get('/notice', [NoticeMailController::class, 'showNoticeForm'])->name('admin.notice.form');
    Route::post('/notice', [NoticeMailController::class, 'sendNotice'])->name('admin.notice.send');
    Route::get('/notice/{notice}', [NoticeMailController::class, 'showNotice'])->name('admin.notice.show');
});

// 店舗代表者用
Route::middleware(['auth', 'role:owner'])->prefix('owner')->group(function () {
    Route::get('/index', [ShopOwnerController::class, 'index'])->name('owner.index'); // ← 修正

    // 店舗情報の作成・編集
    // Route::get('/shop/create', [ShopOwnerController::class, 'createShop'])->name('owner.shop.create');
    Route::post('/shop', [ShopOwnerController::class, 'storeShop'])->name('owner.shop.store');

    // Route::get('/shop/edit', [ShopOwnerController::class, 'editShop'])->name('owner.shop.edit');
    Route::put('/shop', [ShopOwnerController::class, 'updateShop'])->name('owner.shop.update');

    // 予約確認
    Route::get('/reservation', [OwnerReservationController::class, 'index'])->name('owner.reservation');

    Route::get('/notice', [OwnerNoticeMailController::class, 'showNoticeForm'])->name('owner.notice.form');
    Route::post('/notice', [OwnerNoticeMailController::class, 'sendNotice'])->name('owner.notice.send');
    Route::get('/notice/{notice}', [OwnerNoticeMailController::class, 'showNotice'])->name('owner.notice.show');
});