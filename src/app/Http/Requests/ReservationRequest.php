<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Reservation;

class ReservationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'date' => ['required', 'date', 'after:today'],
            'time' => ['required'],
            'number' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'date.required' => '日付を選択してください',
            'date.after' => '日付は本日以降を選択してください',
            'time.required' => '時間を選択してください',
            'number.required' => '人数を選択してください',
        ];
    }

    // 同じ店舗に同日に予約が重複していないかをチェック
    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            $userId = auth()->id();
            $shopId = $this->input('shop_id');
            $date = $this->input('date');
            $reservationId = $this->route('id');

            $alreadyReserved = Reservation::where([
                ['user_id', $userId],
                ['shop_id', $shopId],
                ['date', $date],
            ])
                ->when($reservationId, fn($q) => $q->where('id', '!=', $reservationId))
                ->exists();

            if ($alreadyReserved) {
                $validator->errors()->add('date', '同日の予約が存在します。別の日を選択してください');
            }
        });
    }
}
