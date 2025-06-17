<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        $user = $request->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.index');
        } elseif ($user->role === 'owner') {
            return redirect()->route('owner.index');
        } else {
            return redirect()->route('shop.index');
        }
    }
}