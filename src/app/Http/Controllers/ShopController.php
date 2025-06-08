<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shop;
use App\Models\Area;
use App\Models\Genre;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        $areas = Area::all();
        $genres = Genre::all();

        $shops = Shop::filter($request->only(['area', 'genre', 'keyword']))->get();

        return view('shops.index', compact('shops', 'areas', 'genres'));
    }
}