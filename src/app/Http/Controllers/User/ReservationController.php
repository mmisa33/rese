<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Shop;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReservationController extends Controller
{
    // 予約機能
    public function store(ReservationRequest $request)
    {
        Reservation::create([
            'user_id' => Auth::id(),
            'shop_id' => $request->shop_id,
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return redirect()->route('reservation.done');
    }

    // 予約完了ページを表示
    public function done()
    {
        return view('reservation.done');
    }

    // 予約削除
    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $reservation->delete();

        return redirect()->route('mypage')->with('status', '予約を削除しました');
    }

    // 編集フォームを表示
    public function edit($id)
    {
        $reservation = Reservation::with('shop')->findOrFail($id);

        // 時間選択（11:00〜22:30まで）
        $startHour = 11;
        $endHour = 22;
        $timeOptions = [];
        for ($h = $startHour; $h <= $endHour; $h++) {
            $timeOptions[] = sprintf('%02d:00', $h);
            $timeOptions[] = sprintf('%02d:30', $h);
        }

        // 人数選択（1〜10人）
        $peopleOptions = range(1, 10);

        return view('reservation.edit', compact('reservation', 'timeOptions', 'peopleOptions'));
    }

    // 更新処理
    public function update(ReservationRequest $request, $id)
    {
        $reservation = Reservation::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        $reservation->update([
            'date' => $request->date,
            'time' => $request->time,
            'number' => $request->number,
        ]);

        return redirect()->route('mypage')->with('status', '予約内容を更新しました');
    }

    // Stripe決済付き予約処理
    public function storeWithPayment(ReservationRequest $request)
    {
        // Stripe秘密キーを設定
        Stripe::setApiKey(config('services.stripe.secret'));

        // 対象の店舗情報取得
        $shop = Shop::findOrFail($request->shop_id);
        $quantity = (int) $request->number;
        $unitPrice = 3000; // 1人あたりの金額（円）

        // StripeのCheckoutセッション作成（
        $checkoutSession = StripeSession::create([
            'payment_method_types' => ['card'], // カード支払い
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $shop->name . ' 予約（' . $quantity . '人）',
                    ],
                    'unit_amount' => $unitPrice, // 人数分請求
                ],
                'quantity' => $quantity,
            ]],
            'mode' => 'payment', // 一括支払い
            'success_url' => route('reservation.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('shop.show', ['shop_id' => $shop->id]),
            'metadata' => [
                'user_id' => Auth::id(),
                'shop_id' => $shop->id,
                'date' => $request->date,
                'time' => $request->time,
                'number' => $quantity,
            ],
        ]);

        // Stripeの決済画面にリダイレクト
        return redirect($checkoutSession->url);
    }

    // Stripe決済成功後処理
    public function paymentSuccess(Request $request)
    {
        // Stripeの秘密キーをセット
        Stripe::setApiKey(config('services.stripe.secret'));

        // セッションIDを元にStripeのセッション情報取得
        $session = StripeSession::retrieve($request->session_id);
        $metadata = $session->metadata;

        // メタデータを元に予約確定（DB保存）
        Reservation::create([
            'user_id' => $metadata->user_id,
            'shop_id' => $metadata->shop_id,
            'date' => $metadata->date,
            'time' => $metadata->time,
            'number' => $metadata->number,
        ]);

        return view('reservation.done');
    }

    public function verify($id)
    {
        $reservation = Reservation::with('shop', 'user')->findOrFail($id);

        return view('reservation.verify', compact('reservation'));
    }
}