<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;
use App\Http\Resources\GenreResource;
use Illuminate\Support\Facades\Cache;

class GenreController extends Controller
{
    /**
     * Display a listing of genres
     */
    public function index(): JsonResponse
    {
        $genres = Cache::remember('genres_all', 3600, function () {
            return Genre::withCount('animes')->orderBy('name')->get();
        });
        
        return GenreResource::collection($genres)->response();
    }

    /**
     * Store a newly created genre
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:genres',
            'description' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $genre = Genre::create($validated);

        return response()->json($genre, 201);
    }

    /**
     * Display the specified genre
     */
    public function show(Genre $genre): JsonResponse
    {
        return response()->json($genre->load('animes'));
    }

    /**
     * Update the specified genre
     */
    public function update(Request $request, Genre $genre): JsonResponse
    {
        $validated = $request->validate([
            'name' => 'string|max:255|unique:genres,name,' . $genre->id,
            'description' => 'nullable|string',
            'color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
        ]);

        if (isset($validated['name'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        $genre->update($validated);

        return response()->json($genre);
    }

    /**
     * Remove the specified genre
     */
    public function destroy(Genre $genre): JsonResponse
    {
        $genre->delete();
        return response()->json(['message' => 'Género eliminado exitosamente']);
    }
}
