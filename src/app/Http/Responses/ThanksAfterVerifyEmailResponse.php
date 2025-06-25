<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class ThanksAfterVerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request)
    {
        // JSON リクエストなら 204、通常ブラウザなら /thanks へ
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended('/thanks');
    }
}