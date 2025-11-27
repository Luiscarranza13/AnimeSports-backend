<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Anime extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'synopsis',
        'poster_image',
        'banner_image',
        'trailer_url',
        'studio',
        'year',
        'status',
        'episodes_count',
        'duration_minutes',
        'rating',
        'rating_count',
        'is_featured',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array',
        'is_featured' => 'boolean',
        'rating' => 'decimal:2'
    ];

    // Relaciones
    public function genres(): BelongsToMany
    {
        return $this->belongsToMany(Genre::class);
    }

    public function episodes(): HasMany
    {
        return $this->hasMany(Episode::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(UserFavorite::class);
    }

    // Scopes
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    public function scopeByYear($query, $year)
    {
        return $query->where('year', $year);
    }

    public function scopeByGenre($query, $genreId)
    {
        return $query->whereHas('genres', function ($q) use ($genreId) {
            $q->where('genres.id', $genreId);
        });
    }

    public function ratings(): HasMany
    {
        return $this->hasMany(Rating::class);
    }

    // Accessors
    public function getAverageRatingAttribute()
    {
        return $this->rating_count > 0 ? $this->rating : 0;
    }

    // Métodos
    public function updateRating()
    {
        $ratings = $this->ratings();
        $this->rating = $ratings->avg('score') ?? 0;
        $this->rating_count = $ratings->count();
        $this->save();
    }
}
