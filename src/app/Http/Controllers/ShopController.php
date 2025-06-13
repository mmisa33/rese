<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Like;

class ShopController extends Controller
{
    // 飲食店一覧ページを表示
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();

        $shops = Shop::filter($request->only(['area', 'genre', 'keyword']))->get();

        return view('shop.index', compact('shops', 'areas', 'genres'));
    }

    // いいね機能
    public function toggleLike($shop_id)
    {
        $user = Auth::user();

        $like = Like::where('user_id', $user->id)->where('shop_id', $shop_id)->first();

        if ($like) {
            $like->delete(); // いいね解除
        } else {
            Like::create([
                'user_id' => $user->id,
                'shop_id' => $shop_id,
            ]); // いいね追加
        }

        return back();
    }

    // 飲食店詳細ページを表示
    public function show($id)
    {
        $shop = Shop::findOrFail($id);

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

        return view('shop.detail', compact('shop', 'timeOptions', 'peopleOptions'));
    }
}
