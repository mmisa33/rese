<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create($reservation_id)
    {
        $reservation = Reservation::with('shop')->findOrFail($reservation_id);

        // 自分の予約か＆評価済でないかチェック
        if ($reservation->user_id !== Auth::id() || $reservation->review) {
            abort(403);
        }

        return view('review.create', compact('reservation'));
    }

    public function store(Request $request, $reservation_id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $reservation = Reservation::findOrFail($reservation_id);

        if ($reservation->user_id !== Auth::id() || $reservation->review) {
            abort(403);
        }

        Review::create([
            'user_id' => Auth::id(),
            'reservation_id' => $reservation_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('mypage')->with('message', '評価を投稿しました。');
    }
}
