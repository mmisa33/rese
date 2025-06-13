<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use App\Models\Reservation;

class ReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required'],
            'number' => ['required'],
        ];
    }

    public function messages()
    {
        return [
            'date.required' => '日付を選択してください',
            'date.after' => '日付は本日以降を選択してください',
            'time.required' => '時間を選択してください',
            'number.required' => '人数を選択してください',
        ];
    }

    // 同じユーザーが同日に予約済みかチェック
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            $userId = auth()->id();
            $date = $this->input('date');
            $exists = Reservation::where('user_id', $userId)
                ->where('date', $date)
                ->exists();

            if ($exists) {
                $validator->errors()->add('date', '同日に既に予約があります。別の日を選択してください。');
            }
        });
    }
}
