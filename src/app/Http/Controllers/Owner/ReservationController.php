<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    // 予約一覧ページを表示
    public function index(Request $request)
    {
        $user = auth()->user();

        if (!$user->shop) {
            return view('owner.reservation.index')->with([
                'shopExists' => false,
            ]);
        }

        $shopId = $user->shop->id;

        // 検索フィルター
        $filters = [
            'month' => $request->input('month'),
            'keyword' => $request->input('keyword'),
            'sort' => $request->input('sort'),
        ];

        $reservations = Reservation::with('user')
            ->where('shop_id', $shopId)
            ->filter($filters)
            ->paginate(30);

        return view('owner.reservation.index', compact('reservations', 'filters'));
    }
}