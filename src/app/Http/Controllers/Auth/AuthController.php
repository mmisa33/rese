<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AuthController extends Controller
{
    // ログインページ表示
    public function create(Request $request)
    {
        return $request->is('admin/*')
            ? view('admin.auth.login') // 管理者・店舗代表者用ログインページ
            : view('auth.login');      // 一般ユーザー用ログインページ
    }

    // ログイン処理
    public function store(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // 管理者 or 店舗代表者のみ許可
            if (in_array($user->role, ['admin', 'owner'])) {
                $request->session()->regenerate();

                // role別にリダイレクト先を分ける
                if ($user->role === 'admin') {
                    return redirect()->intended(route('admin.index'));
                } else {
                    return redirect()->intended(route('owner.index'));
                }
            }

            Auth::logout();
            return back()->withErrors(['email' => '管理者または店舗代表者のみログイン可能です']);
        }

        return back()->withErrors(['email' => 'ログイン情報が登録されていません']);
    }

    // メール認証チェック
    public function verifyCheck()
    {
        $user = Auth::user();

        if ($user->role === 'user') {
            if ($user instanceof MustVerifyEmail && $user->hasVerifiedEmail()) {
                return redirect()->intended('/thanks');
            }

            return redirect()->route('verification.notice')
                ->with('error', 'メール認証が完了していません');
        }

        // 管理者・店舗代表者はメール認証不要
        return $this->redirectToDashboard($user->role);
    }

    // ログアウト処理
    public function logout(Request $request)
    {
        $role = Auth::user()->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // role によってリダイレクト先を切り替え
        if ($role === 'admin' || $role === 'owner') {
            return redirect()->route('admin.login');
        }

        return redirect()->route('login');
    }
}