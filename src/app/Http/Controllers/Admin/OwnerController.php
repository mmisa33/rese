<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateOwnerRequest;
use App\Models\User;

class OwnerController extends Controller
{
    // 店舗代表者作成ページを表示
    public function create()
    {
        return view('admin.owner.create');
    }

    // 店舗代表者の登録処理
    public function store(RegisterRequest $request)
    {
        $data = $request->validated();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => 'owner',
        ]);

        return redirect()->route('admin.index')->with('status', '店舗代表者を作成しました');
    }

    // 店舗代表者詳細ページを表示
    public function show(User $owner)
    {
        $owner->load('shop');

        return view('admin.owner.detail', compact('owner'));
    }

    // 店舗代表者の更新処理
    public function update(UpdateOwnerRequest $request, User $owner)
    {
        $owner->load('shop');

        if ($owner->shop) {
            $owner->shop->name = $request->input('shop_name');
            $owner->shop->save();
        }

        $owner->name = $request->input('owner_name');
        $owner->email = $request->input('email');

        if ($request->filled('password')) {
            $owner->password = Hash::make($request->input('password'));
        }

        $owner->save();

        return redirect()->route('admin.index')
            ->with('status', "店舗代表者情報を更新しました");
    }

    // 店舗代表者の削除処理
    public function destroy(User $owner)
    {
        // 店舗が存在して、予約があれば削除をブロック
        if ($owner->shop && $owner->shop->reservations()->exists()) {
            return redirect()->back()->with('error', '予約が存在するため、削除できません');
        }

        // 店舗があれば先に削除
        DB::transaction(function () use ($owner) {
            if ($owner->shop) {
                $owner->shop->delete();
            }
            $owner->delete();
        });

        return redirect()->route('admin.index')
            ->with('status', '店舗代表者を削除しました');
    }
}