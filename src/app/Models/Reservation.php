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
        // 月で絞り込み
        if (!empty($filters['month']) && preg_match('/^\d{4}-\d{2}$/', $filters['month'])) {
            $start = Carbon::createFromFormat('Y-m', $filters['month'])->startOfMonth();
            $end = $start->copy()->endOfMonth();
            $query->whereBetween('date', [$start->toDateString(), $end->toDateString()]);
        }

        // 並び順
        $sort = in_array($filters['sort'] ?? '', ['asc', 'desc']) ? $filters['sort'] : 'asc';
        $query->orderBy('date', $sort)->orderBy('time', $sort);

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
