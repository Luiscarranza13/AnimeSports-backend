<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'title' => 'sometimes|string|max:255',
            'synopsis' => 'sometimes|string|min:50',
            'poster_image' => 'nullable|url|max:500',
            'banner_image' => 'nullable|url|max:500',
            'trailer_url' => 'nullable|url|max:500',
            'studio' => 'nullable|string|max:255',
            'year' => 'sometimes|integer|min:1900|max:' . (date('Y') + 5),
            'status' => 'sometimes|in:ongoing,completed,upcoming,cancelled',
            'episodes_count' => 'sometimes|integer|min:0|max:10000',
            'duration_minutes' => 'nullable|integer|min:1|max:300',
            'is_featured' => 'sometimes|boolean',
            'genres' => 'sometimes|array|min:1',
            'genres.*' => 'exists:genres,id',
            'metadata' => 'nullable|array',
        ];
    }
}
