<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Laravel\Fortify\Contracts\VerifyEmailResponse as VerifyEmailResponseContract;

class ThanksAfterVerifyEmailResponse implements VerifyEmailResponseContract
{
    public function toResponse($request)
    {
        // メール認証後にサンクスページに遷移
        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect()->intended('/thanks');
    }
}