<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnimeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->is_admin;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'synopsis' => 'required|string|min:50',
            'poster_image' => 'nullable|url|max:500',
            'banner_image' => 'nullable|url|max:500',
            'trailer_url' => 'nullable|url|max:500',
            'studio' => 'nullable|string|max:255',
            'year' => 'required|integer|min:1900|max:' . (date('Y') + 5),
            'status' => 'required|in:ongoing,completed,upcoming,cancelled',
            'episodes_count' => 'integer|min:0|max:10000',
            'duration_minutes' => 'nullable|integer|min:1|max:300',
            'is_featured' => 'boolean',
            'genres' => 'required|array|min:1',
            'genres.*' => 'exists:genres,id',
            'metadata' => 'nullable|array',
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'El título es obligatorio',
            'synopsis.required' => 'La sinopsis es obligatoria',
            'synopsis.min' => 'La sinopsis debe tener al menos 50 caracteres',
            'year.required' => 'El año es obligatorio',
            'genres.required' => 'Debe seleccionar al menos un género',
            'genres.min' => 'Debe seleccionar al menos un género',
        ];
    }
}
