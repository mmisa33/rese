<?php

namespace App\Actions\Fortify;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    public function toResponse($request)
    {
        if ($request->wantsJson()) {
            return new JsonResponse(['two_factor' => false], 204);
        }

        $user = $request->user();

        switch ($user->role) {
            case 'admin':
                return redirect()->route('admin.index');
            case 'owner':
                return redirect()->route('owner.index');
            default:
                return redirect()->route('shop.index');
        }
    }
}