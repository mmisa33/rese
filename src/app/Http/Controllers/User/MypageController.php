<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use App\Models\Like;
use App\Models\Reservation;

class MypageController extends Controller
{
    // マイページを表示
    public function mypage()
    {
        $user = Auth::user();

        // 予約情報を取得
        $reservations = Reservation::where('user_id', $user->id)
            ->with('shop')
            ->orderBy('date', 'desc')
            ->paginate(10);

        foreach ($reservations as $reservation) {
            $reservation->isFuture = Carbon::parse($reservation->date)->isFuture();
        }

        // いいね店舗を取得
        $favorites = Like::with('shop.area', 'shop.genre')
            ->where('user_id', $user->id)
            ->paginate(10);

        return view('user.mypage', compact('user', 'reservations', 'favorites'));
    }
}