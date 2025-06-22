<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Models\NoticeMail;
use App\Models\User;

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

    public function showNoticeForm()
    {
        return view('admin.email.notice');
    }

    public function sendNotice(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:100',
            'message' => 'required|string|max:1000',
        ]);

        $users = User::where('role', 'user')->get();

        foreach ($users as $user) {
            Mail::to($user->email)->send(new NoticeMail($request->subject, $request->message));
        }

        return redirect()->route('admin.index')->with('success', 'お知らせメールを送信しました。');
    }
}