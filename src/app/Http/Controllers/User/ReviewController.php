<?php

namespace App\Http\Controllers\User;

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Review;
use App\Http\Requests\ReviewRequest;


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

        return view('user.review.create', compact('reservation'));
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