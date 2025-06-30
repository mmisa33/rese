<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    // 予約一覧ページを表示
    public function index(Request $request)
    {
        $user = auth()->user();
        // 店舗情報がまだ存在しない場合
        if (!$user->shop) {
            return view('owner.reservation.index')->with([
                'shopExists' => false,
            ]);
        }

        $shop = $user->shop;
        $shopId = $shop->id;

        $dates = Reservation::where('shop_id', $shopId)
            ->distinct()
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->mapWithKeys(fn($d) => [$d => Carbon::parse($d)->format('Y年n月j日')]);

        $selectedDate = $request->input('date');

        $query = Reservation::with('user')->where('shop_id', $shopId);
        if ($selectedDate) {
            $query->where('date', $selectedDate);
        }

        $reservations = $query->get()->sortBy([['date', 'asc'], ['time', 'asc']]);

        return view('owner.reservation.index', compact('reservations', 'dates', 'selectedDate'));
    }
}