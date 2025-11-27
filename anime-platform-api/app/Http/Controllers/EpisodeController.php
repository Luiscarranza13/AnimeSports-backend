<?php

namespace App\Http\Controllers;

use App\Models\Episode;
use App\Models\Anime;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class EpisodeController extends Controller
{
    /**
     * Display episodes for a specific anime
     */
    public function index(Anime $anime, Request $request): JsonResponse
    {
        $query = $anime->episodes();

        if ($request->has('exclude_filler')) {
            $query->notFiller();
        }

        $episodes = $query->orderBy('episode_number')
                         ->paginate($request->get('per_page', 50));

        return response()->json($episodes);
    }

    /**
     * Store a newly created episode
     */
    public function store(Request $request, Anime $anime): JsonResponse
    {
        $validated = $request->validate([
            'episode_number' => 'required|integer|min:1|unique:episodes,episode_number,NULL,id,anime_id,' . $anime->id,
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|url',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'nullable|integer|min:1',
            'air_date' => 'nullable|date',
            'is_filler' => 'boolean',
        ]);

        $validated['anime_id'] = $anime->id;

        $episode = Episode::create($validated);

        // Actualizar el conteo de episodios del anime
        $anime->update(['episodes_count' => $anime->episodes()->count()]);

        return response()->json($episode->load('anime'), 201);
    }

    /**
     * Display the specified episode
     */
    public function show(Episode $episode): JsonResponse
    {
        return response()->json($episode->load('anime'));
    }

    /**
     * Update the specified episode
     */
    public function update(Request $request, Episode $episode): JsonResponse
    {
        $validated = $request->validate([
            'episode_number' => 'integer|min:1|unique:episodes,episode_number,' . $episode->id . ',id,anime_id,' . $episode->anime_id,
            'title' => 'string|max:255',
            'description' => 'nullable|string',
            'thumbnail' => 'nullable|url',
            'video_url' => 'nullable|url',
            'duration_minutes' => 'nullable|integer|min:1',
            'air_date' => 'nullable|date',
            'is_filler' => 'boolean',
        ]);

        $episode->update($validated);

        return response()->json($episode->load('anime'));
    }

    /**
     * Remove the specified episode
     */
    public function destroy(Episode $episode): JsonResponse
    {
        $anime = $episode->anime;
        $episode->delete();

        // Actualizar el conteo de episodios del anime
        $anime->update(['episodes_count' => $anime->episodes()->count()]);

        return response()->json(['message' => 'Episodio eliminado exitosamente']);
    }
}
