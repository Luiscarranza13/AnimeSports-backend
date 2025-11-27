<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'anime_id',
        'episode_number',
        'title',
        'description',
        'thumbnail',
        'video_url',
        'duration_minutes',
        'air_date',
        'is_filler'
    ];

    protected $casts = [
        'air_date' => 'date',
        'is_filler' => 'boolean'
    ];

    // Relaciones
    public function anime(): BelongsTo
    {
        return $this->belongsTo(Anime::class);
    }

    // Scopes
    public function scopeByAnime($query, $animeId)
    {
        return $query->where('anime_id', $animeId);
    }

    public function scopeNotFiller($query)
    {
        return $query->where('is_filler', false);
    }
}
