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

        // ユーザー名検索
        $query->when(!empty($filters['keyword']), function ($q) use ($filters) {
            $q->whereHas('user', function ($q) use ($filters) {
                $q->where('name', 'like', '%' . $filters['keyword'] . '%');
            });
        });

        // 並び順
        $sort = in_array($filters['sort'] ?? '', ['asc', 'desc']) ? $filters['sort'] : 'asc';
        $query->orderBy('date', $sort)->orderBy('time', $sort);

        return $query;
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
