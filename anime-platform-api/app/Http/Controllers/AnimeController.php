<?php

namespace App\Http\Controllers;

use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Http\Resources\AnimeResource;
use App\Http\Requests\StoreAnimeRequest;
use App\Http\Requests\UpdateAnimeRequest;
use Illuminate\Support\Facades\Cache;

class AnimeController extends Controller
{
    /**
     * Display a listing of animes with filters
     */
    public function index(Request $request): JsonResponse
    {
        $cacheKey = 'animes_' . md5(json_encode($request->all()));
        
        $animes = Cache::remember($cacheKey, 300, function () use ($request) {
            $query = Anime::with(['genres']);

            // Filtros
            if ($request->has('q')) {
                $query->where('title', 'like', '%' . $request->q . '%')
                      ->orWhere('synopsis', 'like', '%' . $request->q . '%');
            }

            if ($request->has('genre')) {
                $query->byGenre($request->genre);
            }

            if ($request->has('year')) {
                $query->byYear($request->year);
            }

            if ($request->has('status')) {
                $query->byStatus($request->status);
            }

            if ($request->has('featured')) {
                $query->featured();
            }

            if ($request->has('studio')) {
                $query->where('studio', 'like', '%' . $request->studio . '%');
            }

            if ($request->has('min_rating')) {
                $query->where('rating', '>=', $request->min_rating);
            }

            // Ordenamiento
            $sortBy = $request->get('sort_by', 'created_at');
            $sortOrder = $request->get('sort_order', 'desc');
            
            if ($sortBy === 'popularity') {
                $query->orderBy('rating_count', $sortOrder);
            } elseif ($sortBy === 'rating') {
                $query->orderBy('rating', $sortOrder);
            } else {
                $query->orderBy($sortBy, $sortOrder);
            }

            return $query->paginate($request->get('per_page', 20));
        });

        return AnimeResource::collection($animes)->response();
    }

    /**
     * Store a newly created anime
     */
    public function store(StoreAnimeRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['title']);

        $genres = $validated['genres'] ?? [];
        unset($validated['genres']);

        $anime = Anime::create($validated);

        if (!empty($genres)) {
            $anime->genres()->sync($genres);
        }

        Cache::tags(['animes'])->flush();

        return (new AnimeResource($anime->load(['genres'])))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified anime
     */
    public function show(Anime $anime, Request $request): JsonResponse
    {
        $anime->load(['genres', 'episodes' => function ($query) {
            $query->orderBy('episode_number');
        }]);

        // Si el usuario está autenticado, cargar su rating y favorito
        if ($request->user()) {
            $anime->load(['ratings' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }, 'favorites' => function ($query) use ($request) {
                $query->where('user_id', $request->user()->id);
            }]);
        }

        return (new AnimeResource($anime))->response();
    }

    /**
     * Update the specified anime
     */
    public function update(UpdateAnimeRequest $request, Anime $anime): JsonResponse
    {
        $validated = $request->validated();

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        $genres = $validated['genres'] ?? null;
        unset($validated['genres']);

        $anime->update($validated);

        if ($genres !== null) {
            $anime->genres()->sync($genres);
        }

        Cache::tags(['animes'])->flush();

        return (new AnimeResource($anime->load(['genres'])))->response();
    }

    /**
     * Remove the specified anime
     */
    public function destroy(Anime $anime): JsonResponse
    {
        $anime->delete();
        Cache::tags(['animes'])->flush();
        return response()->json(['message' => 'Anime eliminado exitosamente']);
    }

    /**
     * Get featured animes for home page
     */
    public function featured(): JsonResponse
    {
        $animes = Cache::remember('animes_featured', 600, function () {
            return Anime::featured()
                ->with(['genres'])
                ->orderBy('rating', 'desc')
                ->limit(10)
                ->get();
        });

        return AnimeResource::collection($animes)->response();
    }

    /**
     * Get trending animes
     */
    public function trending(): JsonResponse
    {
        $animes = Cache::remember('animes_trending', 300, function () {
            return Anime::with(['genres'])
                ->where('created_at', '>=', now()->subDays(30))
                ->orderBy('rating', 'desc')
                ->orderBy('rating_count', 'desc')
                ->limit(10)
                ->get();
        });

        return AnimeResource::collection($animes)->response();
    }

    /**
     * Advanced search with multiple filters
     */
    public function search(Request $request): JsonResponse
    {
        $query = Anime::with(['genres']);

        // Búsqueda por texto
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('synopsis', 'like', "%{$searchTerm}%")
                  ->orWhere('studio', 'like', "%{$searchTerm}%");
            });
        }

        // Filtros múltiples de géneros
        if ($request->filled('genres')) {
            $genreIds = explode(',', $request->genres);
            $query->whereHas('genres', function ($q) use ($genreIds) {
                $q->whereIn('genres.id', $genreIds);
            }, '=', count($genreIds));
        }

        // Rango de años
        if ($request->filled('year_from')) {
            $query->where('year', '>=', $request->year_from);
        }
        if ($request->filled('year_to')) {
            $query->where('year', '<=', $request->year_to);
        }

        // Rango de rating
        if ($request->filled('rating_from')) {
            $query->where('rating', '>=', $request->rating_from);
        }
        if ($request->filled('rating_to')) {
            $query->where('rating', '<=', $request->rating_to);
        }

        // Estado
        if ($request->filled('status')) {
            $statuses = explode(',', $request->status);
            $query->whereIn('status', $statuses);
        }

        // Ordenamiento avanzado
        $sortBy = $request->get('sort_by', 'rating');
        $sortOrder = $request->get('sort_order', 'desc');
        
        switch ($sortBy) {
            case 'popularity':
                $query->orderBy('rating_count', $sortOrder);
                break;
            case 'rating':
                $query->orderBy('rating', $sortOrder);
                break;
            case 'year':
                $query->orderBy('year', $sortOrder);
                break;
            case 'title':
                $query->orderBy('title', $sortOrder);
                break;
            default:
                $query->orderBy('created_at', $sortOrder);
        }

        $animes = $query->paginate($request->get('per_page', 20));

        return AnimeResource::collection($animes)->response();
    }
}
