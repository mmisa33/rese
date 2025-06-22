<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'owner',
        ]);

        return redirect()->route('admin.index')->with('status', '店舗代表者を作成しました');
    }

    // 店舗代表者詳細ページを表示
    public function show($id)
    {
        $owner = User::with('shop')->findOrFail($id);
        return view('admin.owner.detail', compact('owner'));
    }
}