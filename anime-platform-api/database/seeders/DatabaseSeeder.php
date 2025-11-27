<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@anime-platform.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => true,
        ]);

        // Crear usuario normal
        \App\Models\User::create([
            'name' => 'Usuario Test',
            'email' => 'user@anime-platform.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
            'is_admin' => false,
        ]);

        // Llamar a los seeders
        $this->call([
            GenreSeeder::class,
            AnimeSeeder::class,
        ]);

        // Crear noticias de ejemplo
        \App\Models\News::create([
            'title' => 'Nueva temporada de Attack on Titan confirmada',
            'slug' => 'nueva-temporada-attack-on-titan',
            'excerpt' => 'El estudio Mappa confirma una nueva película para cerrar la serie.',
            'content' => 'Después del éxito de la temporada final, se ha confirmado que habrá una película que cerrará definitivamente la historia de Attack on Titan...',
            'thumbnail' => 'https://example.com/news1-thumb.jpg',
            'author_id' => 1,
            'is_published' => true,
            'is_featured' => true,
            'published_at' => now(),
            'tags' => ['attack-on-titan', 'mappa', 'película']
        ]);
    }
}
