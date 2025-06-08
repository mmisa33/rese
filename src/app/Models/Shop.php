<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'area_id',
        'genre_id',
        'image_path',
    ];

    // 検索処理
    public function scopeFilter($query, $filters)
    {
        if (!empty($filters['area'])) {
            $query->where('area_id', $filters['area']);
        }

        if (!empty($filters['genre'])) {
            $query->where('genre_id', $filters['genre']);
        }

        if (!empty($filters['keyword'])) {
            $query->where('name', 'like', '%' . $filters['keyword'] . '%');
        }

        return $query;
    }

    // リレーション
    public function area()
    {
        return $this->belongsTo(Area::class);
    }

    public function genre()
    {
        return $this->belongsTo(Genre::class);
    }

    public function likedByUsers()
    {
        return $this->belongsToMany(User::class, 'likes')->withTimestamps();
    }
}