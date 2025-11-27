<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    /**
     * Display a listing of news
     */
    public function index(Request $request): JsonResponse
    {
        $query = News::published()->with('author');

        if ($request->has('featured')) {
            $query->featured();
        }

        if ($request->has('tag')) {
            $query->byTag($request->tag);
        }

        $news = $query->orderBy('published_at', 'desc')
                     ->paginate($request->get('per_page', 15));

        return response()->json($news);
    }

    /**
     * Store a newly created news article
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'content' => 'required|string',
            'thumbnail' => 'nullable|url',
            'banner_image' => 'nullable|url',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_at' => 'nullable|date',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['author_id'] = $request->user()->id;

        if ($validated['is_published'] && !isset($validated['published_at'])) {
            $validated['published_at'] = now();
        }

        $news = News::create($validated);

        return response()->json($news->load('author'), 201);
    }

    /**
     * Display the specified news article
     */
    public function show(News $news): JsonResponse
    {
        return response()->json($news->load('author'));
    }

    /**
     * Update the specified news article
     */
    public function update(Request $request, News $news): JsonResponse
    {
        $validated = $request->validate([
            'title' => 'string|max:255',
            'excerpt' => 'string|max:500',
            'content' => 'string',
            'thumbnail' => 'nullable|url',
            'banner_image' => 'nullable|url',
            'is_published' => 'boolean',
            'is_featured' => 'boolean',
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_at' => 'nullable|date',
        ]);

        if (isset($validated['title'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        if (isset($validated['is_published']) && $validated['is_published'] && !$news->published_at) {
            $validated['published_at'] = now();
        }

        $news->update($validated);

        return response()->json($news->load('author'));
    }

    /**
     * Remove the specified news article
     */
    public function destroy(News $news): JsonResponse
    {
        $news->delete();
        return response()->json(['message' => 'Noticia eliminada exitosamente']);
    }
}
