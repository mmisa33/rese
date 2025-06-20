<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:50'],
            'area_id' => ['required', 'exists:areas,id'],
            'genre_id' => ['required', 'exists:genres,id'],
            'description' => ['required', 'string', 'max:500'],
        ];

        if ($this->isMethod('post')) {
            // 新規登録時は画像必須
            $rules['image'] = ['required', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
        } else {
            // 更新時は任意（nullable）
            $rules['image'] = ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'];
        }

        return $rules;
    }

    public function messages(): array
    {
        return [
            'name.required' => '店舗名を入力してください',
            'name.max' => '店舗名は50文字以内で入力してください',
            'image.required' => '画像を選択してください',
            'image.image' => '画像ファイルを選択してください',
            'image.mimes' => '画像は jpeg, png, jpg, webp 形式で指定してください',
            'image.max' => '画像サイズは2MB以内にしてください',
            'area_id.required' => 'エリアを選択してください',
            'area_id.exists' => '選択されたエリアは存在しません',
            'genre_id.required' => 'ジャンルを選択してください',
            'genre_id.exists' => '選択されたジャンルは存在しません',
            'description.required' => '店舗説明を入力してください',
            'description.max' => '説明は500文字以内で入力してください',
        ];
    }
}