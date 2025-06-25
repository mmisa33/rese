<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservation;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $shopId = auth()->user()->shop->id;
        $today = Carbon::today()->format('Y-m-d');

        $dates = Reservation::where('shop_id', $shopId)
            ->select('date')
            ->distinct()
            ->orderBy('date', 'asc')
            ->pluck('date')
            ->mapWithKeys(function ($date) {
                return [$date => Carbon::parse($date)->format('Y年n月j日')];
            });

        $selectedDate = $request->input('date');

        $query = Reservation::with('user')
            ->where('shop_id', $shopId);

        if ($selectedDate) {
            $query->where('date', $selectedDate);
        }

        $allReservations = $query->get();

        $reservations = $allReservations->sortBy(function ($r) use ($today) {
            return ($r->date < $today ? 1 : 0) . $r->date . $r->time;
        });

        return view('owner.reservation.index', compact('reservations', 'dates', 'selectedDate'));
    }
}