<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RatingController extends Controller
{
    /**
     * Get ratings for an anime
     */
    public function index(Anime $anime, Request $request): JsonResponse
    {
        $ratings = $anime->ratings()
            ->with('user:id,name')
            ->orderBy('created_at', 'desc')
            ->paginate($request->get('per_page', 20));

        return response()->json($ratings);
    }

    /**
     * Store or update a rating
     */
    public function store(Request $request, Anime $anime): JsonResponse
    {
        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:10',
            'review' => 'nullable|string|max:1000'
        ]);

        $rating = Rating::updateOrCreate(
            [
                'user_id' => $request->user()->id,
                'anime_id' => $anime->id
            ],
            $validated
        );

        return response()->json([
            'message' => 'Calificación guardada exitosamente',
            'rating' => $rating->load('user:id,name')
        ], $rating->wasRecentlyCreated ? 201 : 200);
    }

    /**
     * Get user's rating for an anime
     */
    public function show(Request $request, Anime $anime): JsonResponse
    {
        $rating = Rating::where([
            'user_id' => $request->user()->id,
            'anime_id' => $anime->id
        ])->first();

        if (!$rating) {
            return response()->json(['message' => 'No has calificado este anime'], 404);
        }

        return response()->json($rating);
    }

    /**
     * Delete a rating
     */
    public function destroy(Request $request, Anime $anime): JsonResponse
    {
        $deleted = Rating::where([
            'user_id' => $request->user()->id,
            'anime_id' => $anime->id
        ])->delete();

        if ($deleted) {
            return response()->json(['message' => 'Calificación eliminada']);
        }

        return response()->json(['message' => 'No se encontró la calificación'], 404);
    }
}
