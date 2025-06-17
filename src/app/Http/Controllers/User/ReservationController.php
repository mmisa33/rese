<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Http\Requests\ReservationRequest;
use Illuminate\Support\Facades\Auth;

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

        return redirect()->route('mypage');
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

        return redirect()->route('mypage');
    }
}