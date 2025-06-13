<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reservation;

class UserController extends Controller
{
    public function mypage()
    {
        $user = Auth::user(); // ←これが必要
        $reservations = Reservation::where('user_id', $user->id)->get();
        $favorites = Like::with('shop')->where('user_id', $user->id)->get();

        return view('user.mypage', compact('user', 'reservations', 'favorites'));
    }
}
