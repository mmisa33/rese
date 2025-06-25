<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\NoticeMail;

class OwnerController extends Controller
{
    public function index()
    {
        $owner = auth()->user();
        $shop = $owner->shop;

        // 店舗があるときだけ予約を取得
        $reservations = $shop
            ? $shop->reservations()->orderBy('date', 'desc')->orderBy('time', 'desc')->get()
            : collect();

        // ログイン中のオーナーが送信したお知らせメールだけ取得
        $notices = NoticeMail::where('user_id', auth()->id())->latest()->paginate(10);

        $areas = Area::all();
        $genres = Genre::all();

        return view('owner.index', compact('shop', 'reservations', 'areas', 'genres', 'notices'));
    }

    public function storeShop(ShopRequest $request)
    {
        $owner = auth()->user();

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('public/shop_images');
        }

        $owner->shop()->create($validated);

        return redirect()->route('owner.index')->with('success', '店舗情報を登録しました');
    }

    public function updateShop(ShopRequest $request)
    {
        $shop = auth()->user()->shop;

        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('public/shop_images');
        }

        $shop->update($validated);

        return redirect()->route('owner.index')->with('success', '店舗情報を更新しました');
    }

    // public function reservations()
    // {
    //     $shop = auth()->user()->shop;
    //     $reservations = $shop->reservations()->with('user')->orderBy('datetime')->get();

    //     return view('owner.reservations.index', compact('reservations'));
    // }
}