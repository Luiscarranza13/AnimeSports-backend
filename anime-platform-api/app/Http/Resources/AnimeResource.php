<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AnimeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'synopsis' => $this->synopsis,
            'poster_image' => $this->poster_image,
            'banner_image' => $this->banner_image,
            'trailer_url' => $this->trailer_url,
            'studio' => $this->studio,
            'year' => $this->year,
            'status' => $this->status,
            'episodes_count' => $this->episodes_count,
            'duration_minutes' => $this->duration_minutes,
            'rating' => round($this->rating, 2),
            'rating_count' => $this->rating_count,
            'is_featured' => $this->is_featured,
            'metadata' => $this->metadata,
            'genres' => GenreResource::collection($this->whenLoaded('genres')),
            'episodes' => EpisodeResource::collection($this->whenLoaded('episodes')),
            'user_rating' => $this->when(
                $request->user() && $this->relationLoaded('ratings'),
                function () use ($request) {
                    return $this->ratings->where('user_id', $request->user()->id)->first();
                }
            ),
            'is_favorite' => $this->when(
                $request->user() && $this->relationLoaded('favorites'),
                function () use ($request) {
                    return $this->favorites->where('user_id', $request->user()->id)->isNotEmpty();
                }
            ),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
