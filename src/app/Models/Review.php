<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    // 評価の範囲（1〜5）
    public const RATING_MIN = 1;
    public const RATING_MAX = 5;

    protected $fillable = ['user_id', 'reservation_id', 'rating', 'comment'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
