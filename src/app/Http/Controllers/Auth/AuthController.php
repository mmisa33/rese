<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AuthController extends Controller
{
    // ユーザー用ログインページ表示
    public function createUserLogin()
    {
        return view('auth.login');
    }

    // ユーザー用ログイン処理
    public function storeUserLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'user') {
                Auth::logout();
                return back()->withErrors(['email' => '一般ユーザー以外はこの画面からログインできません。']);
            }

            $request->session()->regenerate();

            // ユーザーはメール認証が必須
            if ($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                Auth::logout();
                return redirect()->route('verification.notice')
                    ->with('error', 'メール認証が完了していません');
            }

            return redirect()->intended(route('shop.index'));
        }

        return back()->withErrors(['email' => 'ログイン情報が登録されていません']);
    }

    // オーナー用ログインページ表示
    public function createOwnerLogin()
    {
        return view('owner.auth.login');
    }

    // オーナー用ログイン処理
    public function storeOwnerLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'owner') {
                Auth::logout();
                return back()->withErrors(['email' => '店舗代表者以外はこの画面からログインできません。']);
            }

            $request->session()->regenerate();

            // メール認証は不要の場合が多いのでスキップ可能

            return redirect()->intended(route('owner.index'));
        }

        return back()->withErrors(['email' => 'ログイン情報が登録されていません']);
    }

    // 管理者用ログインページ表示
    public function createAdminLogin()
    {
        return view('admin.auth.login');
    }

    // 管理者用ログイン処理
    public function storeAdminLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->role !== 'admin') {
                Auth::logout();
                return back()->withErrors(['email' => '管理者以外はこの画面からログインできません。']);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.index'));
        }

        return back()->withErrors(['email' => 'ログイン情報が登録されていません']);
    }

    // ログアウト処理（共通）
    public function logout(Request $request)
    {
        $role = Auth::user()->role;

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($role === 'admin') {
            return redirect()->route('admin.login');
        } elseif ($role === 'owner') {
            return redirect()->route('owner.login');
        } else {
            return redirect()->route('login');
        }
    }
}