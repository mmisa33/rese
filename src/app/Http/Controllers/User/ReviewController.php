<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    //  評価投稿ページを表示
    public function create($reservation_id)
    {
        $reservation = Reservation::with('shop')->findOrFail($reservation_id);

        // 自分の予約かつ未評価か確認
        if ($reservation->user_id !== Auth::id() || $reservation->review) {
            abort(403);
        }

        $ratings = range(Review::RATING_MIN, Review::RATING_MAX);

        return view('review.create', compact('reservation', 'ratings'));
    }

    // 評価の登録処理
    public function store(ReviewRequest $request, $reservation_id)
    {
        $reservation = Reservation::with('shop')->findOrFail($reservation_id);

        if ($reservation->user_id !== Auth::id() || $reservation->review) {
            abort(403);
        }

        Review::create([
            'user_id' => Auth::id(),
            'reservation_id' => $reservation_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->route('mypage')->with('status', 'レビューを投稿しました');
    }
}