<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticeMailRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $role = $this->user()->role ?? null;

        // 管理者の送信対象
        if ($role === 'admin') {
            $targetRule = ['required', 'in:all,owners,custom'];
        // 店舗代表者の送信対象
        } elseif ($role === 'owner') {
            $targetRule = ['required', 'in:owners,users,reservations,likes,custom'];
        // 管理者と店舗代表者以外は送信不可
        } else {
            $targetRule = ['prohibited'];
        }

        return [
            'target' => $targetRule,
            'subject' => ['required', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:2000'],
            'emails' => ['required_if:target,custom'],
        ];
    }

    public function messages()
    {
        return [
            'target.required' => '宛先を選択してください',
            'target.in'       => '宛先が存在しません',

            'subject.required' => '件名を入力してください',
            'subject.max'     => '件名は50文字以内で入力してください',

            'message.required' => '本文を入力してください',
            'message.max'     => '本文は2000文字以内で入力してください',

            'emails.required_if' => '手動指定の場合はメールアドレスを入力してください',
        ];
    }
}