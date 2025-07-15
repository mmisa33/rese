<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'shop_id',
        'date',
        'time',
        'number',
    ];

    // 検索処理
    public function scopeFilter($query, $filters)
    {
        // 日付範囲で絞り込み
        if (!empty($filters['start_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filters['start_date'])) {
            $query->where('date', '>=', $filters['start_date']);
        }
        if (!empty($filters['end_date']) && preg_match('/^\d{4}-\d{2}-\d{2}$/', $filters['end_date'])) {
            $query->where('date', '<=', $filters['end_date']);
        }

        // 来店状況で絞り込み
        if (!empty($filters['visit_status'])) {
            $now = Carbon::now()->format('Y-m-d H:i:s');
            if ($filters['visit_status'] === 'visited') {
                $query->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i') < ?", [$now]);
            } elseif ($filters['visit_status'] === 'upcoming') {
                $query->whereRaw("STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i') >= ?", [$now]);
            }
        }

        // ユーザー名検索
        $query->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['keyword'] . '%');
            });
        });

        return $query;
    }

    public function getVisitStatusAttribute()
    {
        $dateTime = Carbon::parse($this->date . ' ' . $this->time);
        return $dateTime->isPast() ? '来店済' : '来店前';
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
