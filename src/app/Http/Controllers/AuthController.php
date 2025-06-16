<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class AuthController extends Controller
{
    // メール認証チェック
    public function verifyCheck()
    {
        $user = Auth::user();

        // 認証済みの場合
        if ($user instanceof MustVerifyEmail && $user->hasVerifiedEmail()) {
            return redirect()->intended('/thanks');
        }

        // 認証未完了の場合
        return redirect()->route('verification.notice')
            ->with('error', 'メール認証が完了していません');
    }
}