<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $genres = [
            ['name' => 'Acción', 'description' => 'Anime con escenas de combate y aventura', 'color' => '#ff6b6b'],
            ['name' => 'Aventura', 'description' => 'Historias de exploración y descubrimiento', 'color' => '#4ecdc4'],
            ['name' => 'Comedia', 'description' => 'Anime humorístico y entretenido', 'color' => '#ffe66d'],
            ['name' => 'Drama', 'description' => 'Historias emotivas y profundas', 'color' => '#a8dadc'],
            ['name' => 'Fantasía', 'description' => 'Mundos mágicos y sobrenaturales', 'color' => '#b19cd9'],
            ['name' => 'Romance', 'description' => 'Historias de amor y relaciones', 'color' => '#ff8fab'],
            ['name' => 'Ciencia Ficción', 'description' => 'Tecnología avanzada y futuros alternativos', 'color' => '#00b4d8'],
            ['name' => 'Misterio', 'description' => 'Enigmas y casos por resolver', 'color' => '#6c757d'],
            ['name' => 'Horror', 'description' => 'Anime de terror y suspenso', 'color' => '#8b0000'],
            ['name' => 'Sobrenatural', 'description' => 'Elementos paranormales y místicos', 'color' => '#9d4edd'],
            ['name' => 'Deportes', 'description' => 'Competencias y superación deportiva', 'color' => '#06ffa5'],
            ['name' => 'Slice of Life', 'description' => 'Vida cotidiana y momentos simples', 'color' => '#ffb5a7'],
            ['name' => 'Mecha', 'description' => 'Robots gigantes y batallas épicas', 'color' => '#457b9d'],
            ['name' => 'Psicológico', 'description' => 'Exploración de la mente humana', 'color' => '#6a4c93'],
            ['name' => 'Thriller', 'description' => 'Suspenso y tensión constante', 'color' => '#e63946'],
            ['name' => 'Histórico', 'description' => 'Basado en eventos históricos', 'color' => '#bc6c25'],
            ['name' => 'Militar', 'description' => 'Conflictos bélicos y estrategia', 'color' => '#2f4f4f'],
            ['name' => 'Escolar', 'description' => 'Vida estudiantil y escuela', 'color' => '#ffd60a'],
            ['name' => 'Isekai', 'description' => 'Transportado a otro mundo', 'color' => '#7209b7'],
            ['name' => 'Música', 'description' => 'Centrado en la música y artistas', 'color' => '#f72585'],
        ];

        foreach ($genres as $genre) {
            Genre::create([
                'name' => $genre['name'],
                'slug' => Str::slug($genre['name']),
                'description' => $genre['description'],
                'color' => $genre['color'],
            ]);
        }
    }
}
