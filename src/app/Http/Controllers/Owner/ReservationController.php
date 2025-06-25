<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        // 予約日で絞り込み用に全予約日の一覧を取得（重複なし）
        $dates = Reservation::where('shop_id', auth()->user()->shop->id)
            ->select('date')
            ->distinct()
            ->orderBy('date', 'asc')
            ->pluck('date');

        // 絞り込み条件の予約日
        $selectedDate = $request->input('date');

        // 予約一覧を取得、予約日で絞り込みがあれば適用
        $query = Reservation::with('user')
            ->where('shop_id', auth()->user()->shop->id);

        if ($selectedDate) {
            $query->where('date', $selectedDate);
        }

        $reservations = $query->orderBy('date')->orderBy('time')->get();

        return view('owner.reservation.index', compact('reservations', 'dates', 'selectedDate'));
    }
}