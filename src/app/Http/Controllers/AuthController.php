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
}