<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AnimeController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\EpisodeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserFavoriteController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Rutas públicas
Route::post('/auth/register', [AuthController::class, 'register']);
Route::post('/auth/login', [AuthController::class, 'login']);

// Rutas de animes (públicas)
Route::get('/animes', [AnimeController::class, 'index']);
Route::get('/animes/featured', [AnimeController::class, 'featured']);
Route::get('/animes/trending', [AnimeController::class, 'trending']);
Route::get('/animes/search', [AnimeController::class, 'search']);
Route::get('/animes/{anime}', [AnimeController::class, 'show']);
Route::get('/animes/{anime}/ratings', [\App\Http\Controllers\RatingController::class, 'index']);

// Rutas de géneros (públicas)
Route::get('/genres', [GenreController::class, 'index']);
Route::get('/genres/{genre}', [GenreController::class, 'show']);

// Rutas de episodios (públicas)
Route::get('/animes/{anime}/episodes', [EpisodeController::class, 'index']);
Route::get('/episodes/{episode}', [EpisodeController::class, 'show']);

// Rutas de noticias (públicas)
Route::get('/news', [NewsController::class, 'index']);
Route::get('/news/{news}', [NewsController::class, 'show']);

// Rutas de estadísticas (públicas)
Route::prefix('stats')->group(function () {
    Route::get('/', [\App\Http\Controllers\StatsController::class, 'index']);
    Route::get('/by-year', [\App\Http\Controllers\StatsController::class, 'byYear']);
    Route::get('/by-genre', [\App\Http\Controllers\StatsController::class, 'byGenre']);
    Route::get('/by-status', [\App\Http\Controllers\StatsController::class, 'byStatus']);
    Route::get('/top-rated', [\App\Http\Controllers\StatsController::class, 'topRated']);
    Route::get('/most-popular', [\App\Http\Controllers\StatsController::class, 'mostPopular']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::post('/auth/logout', [AuthController::class, 'logout']);
    Route::get('/auth/me', [AuthController::class, 'me']);
    
    // Favoritos de usuario
    Route::get('/user/favorites', [UserFavoriteController::class, 'index']);
    Route::post('/user/favorites', [UserFavoriteController::class, 'store']);
    Route::delete('/user/favorites/{anime}', [UserFavoriteController::class, 'destroy']);
    Route::get('/user/favorites/{anime}/check', [UserFavoriteController::class, 'check']);
    
    // Calificaciones
    Route::post('/animes/{anime}/ratings', [\App\Http\Controllers\RatingController::class, 'store']);
    Route::get('/animes/{anime}/ratings/me', [\App\Http\Controllers\RatingController::class, 'show']);
    Route::delete('/animes/{anime}/ratings', [\App\Http\Controllers\RatingController::class, 'destroy']);
    
    // Rutas de administración (requieren permisos adicionales)
    Route::middleware('admin')->group(function () {
        // CRUD Animes
        Route::post('/animes', [AnimeController::class, 'store']);
        Route::put('/animes/{anime}', [AnimeController::class, 'update']);
        Route::delete('/animes/{anime}', [AnimeController::class, 'destroy']);
        
        // CRUD Géneros
        Route::post('/genres', [GenreController::class, 'store']);
        Route::put('/genres/{genre}', [GenreController::class, 'update']);
        Route::delete('/genres/{genre}', [GenreController::class, 'destroy']);
        
        // CRUD Episodios
        Route::post('/animes/{anime}/episodes', [EpisodeController::class, 'store']);
        Route::put('/episodes/{episode}', [EpisodeController::class, 'update']);
        Route::delete('/episodes/{episode}', [EpisodeController::class, 'destroy']);
        
        // CRUD Noticias
        Route::post('/news', [NewsController::class, 'store']);
        Route::put('/news/{news}', [NewsController::class, 'update']);
        Route::delete('/news/{news}', [NewsController::class, 'destroy']);
    });
});
