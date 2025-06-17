<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user();

        // 予約を取得して、未来判定フラグを追加
        $reservations = Reservation::where('user_id', $user->id)
            ->with('shop')
            ->get()
            ->map(function ($reservation) {
                $reservation->isFuture = Carbon::parse($reservation->date)->isFuture();
                return $reservation;
            });

        $favorites = Like::with('shop.area', 'shop.genre')->where('user_id', $user->id)->get();

        return view('user.mypage', compact('user', 'reservations', 'favorites'));
    }
}
