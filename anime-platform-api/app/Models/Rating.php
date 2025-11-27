<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'anime_id',
        'score',
        'review'
    ];

    protected $casts = [
        'score' => 'decimal:1'
    ];

    // Relaciones
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    // Boot method para actualizar rating del anime
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($rating) {
            $rating->anime->updateRating();
        });

        static::deleted(function ($rating) {
            $rating->anime->updateRating();
        });
    }
}
