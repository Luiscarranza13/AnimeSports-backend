<?php

namespace Database\Seeders;

use App\Models\Anime;
use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AnimeSeeder extends Seeder
{
    public function run(): void
    {
        $animes = [
            [
                'title' => 'Attack on Titan',
                'synopsis' => 'La humanidad vive dentro de ciudades rodeadas por enormes muros debido a los Titanes, gigantescas criaturas humanoides que devoran humanos. La historia sigue a Eren Yeager, quien jura exterminar a todos los Titanes después de que uno de ellos destruye su ciudad natal.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/10/47347.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1578632767115-351597cf2477?w=1920',
                'trailer_url' => 'https://www.youtube.com/watch?v=LHtdKWJdif4',
                'studio' => 'MAPPA',
                'year' => 2013,
                'status' => 'completed',
                'episodes_count' => 87,
                'duration_minutes' => 24,
                'is_featured' => true,
                'genres' => ['Acción', 'Drama', 'Fantasía'],
            ],
            [
                'title' => 'Demon Slayer',
                'synopsis' => 'Tanjiro Kamado es un joven que vive en las montañas. Un día regresa a casa para encontrar a su familia masacrada y su hermana Nezuko convertida en demonio. Tanjiro se embarca en un viaje para encontrar una cura y vengar a su familia.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/1286/99889.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1578632292335-df3abbb0d586?w=1920',
                'trailer_url' => 'https://www.youtube.com/watch?v=VQGCKyvzIM4',
                'studio' => 'ufotable',
                'year' => 2019,
                'status' => 'ongoing',
                'episodes_count' => 55,
                'duration_minutes' => 24,
                'is_featured' => true,
                'genres' => ['Acción', 'Aventura', 'Sobrenatural'],
            ],
            [
                'title' => 'My Hero Academia',
                'synopsis' => 'En un mundo donde el 80% de la población tiene superpoderes llamados "Quirks", Izuku Midoriya nace sin ninguno. A pesar de esto, sueña con convertirse en un héroe como su ídolo All Might.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/10/78745.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1612036782180-6f0b6cd846fe?w=1920',
                'studio' => 'Bones',
                'year' => 2016,
                'status' => 'ongoing',
                'episodes_count' => 138,
                'duration_minutes' => 24,
                'is_featured' => true,
                'genres' => ['Acción', 'Comedia', 'Escolar'],
            ],
            [
                'title' => 'One Piece',
                'synopsis' => 'Monkey D. Luffy sueña con convertirse en el Rey de los Piratas. Después de comer una Fruta del Diablo, gana el poder de estirarse como goma, pero pierde la habilidad de nadar. Junto a su tripulación, navega los mares en busca del tesoro legendario One Piece.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/6/73245.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1559827260-dc66d52bef19?w=1920',
                'studio' => 'Toei Animation',
                'year' => 1999,
                'status' => 'ongoing',
                'episodes_count' => 1090,
                'duration_minutes' => 24,
                'is_featured' => true,
                'genres' => ['Acción', 'Aventura', 'Comedia', 'Fantasía'],
            ],
            [
                'title' => 'Jujutsu Kaisen',
                'synopsis' => 'Yuji Itadori es un estudiante de secundaria con habilidades físicas extraordinarias. Después de tragar un dedo maldito perteneciente al Rey de las Maldiciones Sukuna, se une a una escuela secreta de hechiceros para matar a Sukuna.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/1171/109222.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1578632749014-ca77efd052eb?w=1920',
                'studio' => 'MAPPA',
                'year' => 2020,
                'status' => 'ongoing',
                'episodes_count' => 47,
                'duration_minutes' => 24,
                'is_featured' => true,
                'genres' => ['Acción', 'Sobrenatural', 'Escolar'],
            ],
            [
                'title' => 'Spy x Family',
                'synopsis' => 'Un espía debe crear una familia falsa para ejecutar una misión, sin saber que la niña que adopta es telépata y la mujer con la que se casa es una asesina.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/1441/122795.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1578632292335-df3abbb0d586?w=1920',
                'studio' => 'Wit Studio',
                'year' => 2022,
                'status' => 'ongoing',
                'episodes_count' => 25,
                'duration_minutes' => 24,
                'is_featured' => false,
                'genres' => ['Acción', 'Comedia', 'Slice of Life'],
            ],
            [
                'title' => 'Chainsaw Man',
                'synopsis' => 'Denji es un joven que vive en la pobreza extrema. Después de ser traicionado y asesinado, se fusiona con su perro demonio Pochita y se convierte en Chainsaw Man, un híbrido humano-demonio.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/1806/126216.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1612036782180-6f0b6cd846fe?w=1920',
                'studio' => 'MAPPA',
                'year' => 2022,
                'status' => 'completed',
                'episodes_count' => 12,
                'duration_minutes' => 24,
                'is_featured' => false,
                'genres' => ['Acción', 'Horror', 'Sobrenatural'],
            ],
            [
                'title' => 'Steins;Gate',
                'synopsis' => 'Un grupo de amigos descubre cómo enviar mensajes al pasado. A medida que experimentan con esta tecnología, se ven envueltos en una conspiración que amenaza sus vidas.',
                'poster_image' => 'https://cdn.myanimelist.net/images/anime/5/73199.jpg',
                'banner_image' => 'https://images.unsplash.com/photo-1451187580459-43490279c0fa?w=1920',
                'studio' => 'White Fox',
                'year' => 2011,
                'status' => 'completed',
                'episodes_count' => 24,
                'duration_minutes' => 24,
                'is_featured' => false,
                'genres' => ['Ciencia Ficción', 'Thriller', 'Drama'],
            ],
        ];

        foreach ($animes as $animeData) {
            $genreNames = $animeData['genres'];
            unset($animeData['genres']);
            
            $animeData['slug'] = Str::slug($animeData['title']);
            $animeData['rating'] = rand(70, 100) / 10;
            $animeData['rating_count'] = rand(1000, 50000);
            
            $anime = Anime::create($animeData);
            
            $genreIds = Genre::whereIn('name', $genreNames)->pluck('id');
            $anime->genres()->attach($genreIds);
        }
    }
}
