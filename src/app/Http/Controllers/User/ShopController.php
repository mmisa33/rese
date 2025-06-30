<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;
use App\Models\Like;

class ShopController extends Controller
{
    // 定数を設定
    private const START_HOUR = 11;
    private const END_HOUR = 22;
    private const MAX_PEOPLE = 10;

    // 飲食店一覧ページを表示
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();

        $shops = Shop::filter($request->only(['area', 'genre', 'keyword']))->get();

        return view('user.shop.index', compact('shops', 'areas', 'genres'));
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

        // 時間選択（11:00〜22:30）
        $timeOptions = [];
        for ($h = self::START_HOUR; $h <= self::END_HOUR; $h++) {
            $timeOptions[] = sprintf('%02d:00', $h);
            $timeOptions[] = sprintf('%02d:30', $h);
        }

        // 人数選択（1〜10人）
        $peopleOptions = range(1, self::MAX_PEOPLE);

        return view('user.shop.detail', compact('shop', 'timeOptions', 'peopleOptions'));
    }
}