<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Shop;
use App\Http\Requests\ReservationRequest;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Exception\ApiErrorException;

class ReservationController extends Controller
{
    // 定数設定
    private const UNIT_PRICE = 3000;
    private const START_HOUR = 11;
    private const END_HOUR = 22;
    private const MAX_PEOPLE = 10;

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
        return view('user.reservation.done');
    }

    // 予約削除処理
    public function destroy($id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();
        $reservation->delete();

        return redirect()->route('mypage')->with('status', '予約を削除しました');
    }

    // 予約編集フォームを表示
    public function edit($id)
    {
        $reservation = Reservation::with('shop')->findOrFail($id);

        // 時間選択（11:00〜22:30）
        $timeOptions = [];
        for ($h = self::START_HOUR; $h <= self::END_HOUR; $h++) {
            $timeOptions[] = sprintf('%02d:00', $h);
            $timeOptions[] = sprintf('%02d:30', $h);
        }

        // 人数選択（1〜10人）
        $peopleOptions = range(1, self::MAX_PEOPLE);

        return view('user.reservation.edit', compact('reservation', 'timeOptions', 'peopleOptions'));
    }

    // 予約更新処理
    public function update(ReservationRequest $request, $id)
    {
        $reservation = Reservation::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $reservation->update([
            'date'   => $request->date,
            'time'   => $request->time,
            'number' => $request->number,
        ]);

        return redirect()->route('mypage')->with('status', '予約内容を更新しました');
    }

    // Stripe決済付き予約処理
    public function storeWithPayment(ReservationRequest $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $shop = Shop::findOrFail($request->shop_id);
            $quantity = (int) $request->number;
            $unitPrice = self::UNIT_PRICE;  // 1人3,000円

            $checkoutSession = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $shop->name . ' 予約（' . $quantity . '人）',
                        ],
                        'unit_amount' => $unitPrice,
                    ],
                    'quantity' => $quantity,
                ]],
                'mode' => 'payment',
                'success_url' => route('reservation.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('shop.show', ['shop_id' => $shop->id]),
                'metadata' => [
                    'user_id'  => Auth::id(),
                    'shop_id'  => $shop->id,
                    'date'     => $request->date,
                    'time'     => $request->time,
                    'number'   => $quantity,
                ],
            ]);

            return redirect($checkoutSession->url);
        } catch (ApiErrorException $e) {
            return back()->withErrors(['message' => '決済処理中にエラーが発生しました。もう一度お試しください。']);
        }
    }

    // Stripe決済成功処理
    public function paymentSuccess(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $session = StripeSession::retrieve($request->session_id);
            $metadata = $session->metadata;

            Reservation::create([
                'user_id' => $metadata->user_id,
                'shop_id' => $metadata->shop_id,
                'date'    => $metadata->date,
                'time'    => $metadata->time,
                'number'  => $metadata->number,
            ]);

            return redirect()->route('reservation.done');
        } catch (ApiErrorException $e) {
            return redirect()->route('mypage')->withErrors(['message' => '決済完了後の処理に失敗しました。']);
        }
    }

    // 予約内容確認画面
    public function verify($id)
    {
        $reservation = Reservation::with('shop', 'user')->findOrFail($id);

        return view('user.reservation.verify', compact('reservation'));
    }
}