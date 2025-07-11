<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Http\Requests\ShopRequest;
use App\Models\Area;
use App\Models\Genre;
use App\Models\NoticeMail;

class OwnerController extends Controller
{
    // 店舗代表者の管理者ページを表示
    public function index()
    {
        $owner = auth()->user();
        $shop = $owner->shop;

        // 店舗があるときだけ予約を取得
        $reservations = $shop
            ? $shop->reservations()->orderBy('date', 'desc')->orderBy('time', 'desc')->get()
            : collect();

        $notices = NoticeMail::where('user_id', auth()->id())->latest()->paginate(15);

        $areas = Area::all();
        $genres = Genre::all();

        $imageUrl = '';
        if ($shop && $shop->image_path) {
            $disk = config('filesystems.default');
            if ($disk === 'local') {
                $disk = 'public';
            }

            $imageUrl = Storage::disk($disk)->url($shop->image_path);

        }

        return view('owner.index', compact('shop', 'reservations', 'areas', 'genres', 'notices', 'imageUrl'));
    }

    // 店舗情報の登録処理
    public function storeShop(ShopRequest $request)
    {
        $owner     = auth()->user();
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $disk = config('filesystems.default'); // local or s3

            // localが 'local' の場合は、公開用の 'public' に置き換え
            if ($disk === 'local') {
                $disk = 'public';
            }

            // 画像をアップロード
            $filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueFilename = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('image')->storeAs('shops', $uniqueFilename, $disk);

            // S3の際は公開権限を付与
            if ($disk === 's3') {
                Storage::disk('s3')->setVisibility($path, 'public');
            }

            $validated['image_path'] = $path;
        }

        $owner->shop()->create($validated);

        return redirect()->route('owner.index')->with('success', '店舗情報を登録しました');
    }

    // 店舗情報の更新処理
    public function updateShop(ShopRequest $request)
    {
        $shop      = auth()->user()->shop;
        $validated = $request->validated();

        if ($request->hasFile('image')) {
            $disk = config('filesystems.default'); // local or s3

            if ($disk === 'local') {
                $disk = 'public';
            }

            // 旧ファイルを削除
            if ($shop->image_path && Storage::disk($disk)->exists($shop->image_path)) {
                Storage::disk($disk)->delete($shop->image_path);
            }

            // 新しい画像をアップロード
            $filename = pathinfo($request->file('image')->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $uniqueFilename = $filename . '_' . time() . '.' . $extension;

            $path = $request->file('image')->storeAs('shops', $uniqueFilename, $disk);

            if ($disk === 's3') {
                Storage::disk('s3')->setVisibility($path, 'public');
            }

            $validated['image_path'] = $path;
        }

        $shop->update($validated);

        return redirect()->route('owner.index')->with('success', '店舗情報を更新しました');
    }
}