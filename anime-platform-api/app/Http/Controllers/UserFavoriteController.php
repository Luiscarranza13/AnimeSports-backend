<?php

namespace App\Http\Controllers;

use App\Models\UserFavorite;
use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class UserFavoriteController extends Controller
{
    /**
     * Get user's favorite animes
     */
    public function index(Request $request): JsonResponse
    {
        $favorites = $request->user()
            ->favoriteAnimes()
            ->with(['genres'])
            ->paginate($request->get('per_page', 20));

        return response()->json($favorites);
    }

    /**
     * Add anime to favorites
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'anime_id' => 'required|exists:animes,id'
        ]);

        $favorite = UserFavorite::firstOrCreate([
            'user_id' => $request->user()->id,
            'anime_id' => $validated['anime_id']
        ]);

        if ($favorite->wasRecentlyCreated) {
            return response()->json([
                'message' => 'Anime agregado a favoritos',
                'favorite' => $favorite->load('anime')
            ], 201);
        }

        return response()->json([
            'message' => 'El anime ya está en favoritos'
        ], 200);
    }

    /**
     * Remove anime from favorites
     */
    public function destroy(Request $request, $animeId): JsonResponse
    {
        $deleted = UserFavorite::where([
            'user_id' => $request->user()->id,
            'anime_id' => $animeId
        ])->delete();

        if ($deleted) {
            return response()->json([
                'message' => 'Anime removido de favoritos'
            ]);
        }

        return response()->json([
            'message' => 'El anime no estaba en favoritos'
        ], 404);
    }

    /**
     * Check if anime is in user's favorites
     */
    public function check(Request $request, $animeId): JsonResponse
    {
        $isFavorite = UserFavorite::where([
            'user_id' => $request->user()->id,
            'anime_id' => $animeId
        ])->exists();

        return response()->json([
            'is_favorite' => $isFavorite
        ]);
    }
}