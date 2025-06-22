<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOwnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules(): array
    {
        $owner = $this->getOwner();

        return [
            'owner_name' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'string',
                'email',
                'max:100',
                Rule::unique('users', 'email')->ignore($owner ? $owner->id : null),
            ],
            'shop_name' => $owner && $owner->shop
                ? ['required', 'string', 'max:255']  // 店舗情報が作成されている場合
                : ['nullable'],  // 店舗情報が作成されていない場合
            'password' => ['nullable', 'min:8', 'max:50'],
        ];
    }

    // ルートからownerモデルを取得（なければnull）
    protected function getOwner()
    {
        $ownerParam = $this->route('owner');

        if ($ownerParam instanceof \App\Models\User) {
            return $ownerParam;
        }

        return \App\Models\User::find($ownerParam);
    }

    public function messages(): array
    {
        return [
            'shop_name.max' => '店舗名は255文字以内で入力してください',
            'shop_name.required' => '店舗名を入力してください',

            'owner_name.required' => '店舗代表者名を入力してください',
            'owner_name.string' => '店舗代表者名は文字列で入力してください',
            'owner_name.max' => '店舗代表者名は50文字以内で入力してください',

            'email.required' => 'メールアドレスを入力してください',
            'email.string' => 'メールアドレスは文字列で入力してください',
            'email.email' => '有効なメールアドレスを入力してください',
            'email.max' => 'メールアドレスは100文字以内で入力してください',
            'email.unique' => 'このメールアドレスは既に使用されています',

            'password.min' => 'パスワードは8文字以上で入力してください',
            'password.max' => 'パスワードは50文字以内で入力してください',
        ];
    }
}