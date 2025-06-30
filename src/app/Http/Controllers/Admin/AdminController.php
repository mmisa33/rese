<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NoticeMail;

class AdminController extends Controller
{
    // 管理者の管理画面を表示
    public function index()
    {
        // 店舗代表者を取得
        $owners = User::where('role', 'owner')->with('shop')->paginate(15);

        // お知らせメール一覧
        $notices = NoticeMail::where('user_id', auth()->id())->latest()->paginate(15);

        return view('admin.index', compact('owners', 'notices'));
    }
}