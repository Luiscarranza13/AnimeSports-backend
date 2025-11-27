<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use App\Models\Genre;
use App\Models\User;
use App\Models\News;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    /**
     * Get general platform statistics
     */
    public function index(): JsonResponse
    {
        $stats = Cache::remember('platform_stats', 600, function () {
            return [
                'total_animes' => Anime::count(),
                'total_episodes' => DB::table('episodes')->count(),
                'total_genres' => Genre::count(),
                'total_users' => User::count(),
                'total_news' => News::where('is_published', true)->count(),
                'total_ratings' => DB::table('ratings')->count(),
                'average_rating' => round(Anime::avg('rating'), 2),
                'most_popular_anime' => Anime::orderBy('rating_count', 'desc')->first(['id', 'title', 'rating_count']),
                'highest_rated_anime' => Anime::where('rating_count', '>', 100)->orderBy('rating', 'desc')->first(['id', 'title', 'rating']),
                'newest_anime' => Anime::latest()->first(['id', 'title', 'created_at']),
            ];
        });

        return response()->json($stats);
    }

    /**
     * Get anime statistics by year
     */
    public function byYear(): JsonResponse
    {
        $stats = Cache::remember('stats_by_year', 3600, function () {
            return Anime::select('year', DB::raw('count(*) as count'), DB::raw('avg(rating) as avg_rating'))
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get();
        });

        return response()->json($stats);
    }

    /**
     * Get anime statistics by genre
     */
    public function byGenre(): JsonResponse
    {
        $stats = Cache::remember('stats_by_genre', 3600, function () {
            return Genre::withCount('animes')
                ->with(['animes' => function ($query) {
                    $query->select('animes.id')->selectRaw('avg(rating) as avg_rating');
                }])
                ->orderBy('animes_count', 'desc')
                ->get()
                ->map(function ($genre) {
                    return [
                        'id' => $genre->id,
                        'name' => $genre->name,
                        'color' => $genre->color,
                        'animes_count' => $genre->animes_count,
                        'avg_rating' => round($genre->animes->avg('rating'), 2),
                    ];
                });
        });

        return response()->json($stats);
    }

    /**
     * Get anime statistics by status
     */
    public function byStatus(): JsonResponse
    {
        $stats = Cache::remember('stats_by_status', 600, function () {
            return Anime::select('status', DB::raw('count(*) as count'))
                ->groupBy('status')
                ->get();
        });

        return response()->json($stats);
    }

    /**
     * Get top rated animes
     */
    public function topRated(): JsonResponse
    {
        $animes = Cache::remember('top_rated_animes', 600, function () {
            return Anime::with('genres')
                ->where('rating_count', '>', 50)
                ->orderBy('rating', 'desc')
                ->limit(20)
                ->get(['id', 'title', 'poster_image', 'rating', 'rating_count', 'year']);
        });

        return response()->json($animes);
    }

    /**
     * Get most popular animes
     */
    public function mostPopular(): JsonResponse
    {
        $animes = Cache::remember('most_popular_animes', 600, function () {
            return Anime::with('genres')
                ->orderBy('rating_count', 'desc')
                ->limit(20)
                ->get(['id', 'title', 'poster_image', 'rating', 'rating_count', 'year']);
        });

        return response()->json($animes);
    }
}
