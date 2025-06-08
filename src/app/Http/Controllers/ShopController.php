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
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();

        $shops = Shop::filter($request->only(['area', 'genre', 'keyword']))->get();

        return view('shops.index', compact('shops', 'areas', 'genres'));
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

    public function show($shop_id)
    {
        $shop = Shop::findOrFail($shop_id);
        return view('shops.show', compact('shop'));
    }
}