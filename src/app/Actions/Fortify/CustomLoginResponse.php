<?php

namespace App\Actions\Fortify;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Laravel\Fortify\Contracts\LoginResponse as LoginResponseContract;

class CustomLoginResponse implements LoginResponseContract
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @return JsonResponse|RedirectResponse
     */
    public function toResponse($request)
    {
        // SPA / API ログイン時は 204 JSON
        if ($request->wantsJson()) {
            return new JsonResponse(['two_factor' => false], 204);
        }

        $user = $request->user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.index'),
            'owner' => redirect()->route('owner.index'),
            default => redirect()->route('shop.index'),
        };
    }
}