<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\NoticeMail;

class AdminController extends Controller
{
    public function index()
    {
        // 店舗代表者を取得
        $owners = User::where('role', 'owner')->with('shop')->paginate(15);

        // お知らせメール一覧
        $notices = NoticeMail::latest()->take(10)->get();

        return view('admin.index', compact( 'owners', 'notices'));
    }
}