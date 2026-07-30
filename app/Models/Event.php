<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'category_id',
        'organizer_id',
        'title',
        'description',
        'date',
        'location',
        'price',
        'stock',
        'poster_path'
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Rata-rata rating event ini (dibulatkan 1 desimal), 0 jika belum ada ulasan
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getReviewsCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    // Apakah event ini sudah "tuntas" + lewat H+1, sehingga boleh diulas
    public function isReviewable(): bool
    {
        return $this->date && now()->greaterThanOrEqualTo(
            \Carbon\Carbon::parse($this->date)->addDay()
        );
    }
}
