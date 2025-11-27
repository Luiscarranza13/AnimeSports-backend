<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('animes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('synopsis');
            $table->string('poster_image')->nullable(); // URL del poster
            $table->string('banner_image')->nullable(); // URL del banner/hero
            $table->string('trailer_url')->nullable(); // URL del trailer
            $table->string('studio')->nullable();
            $table->integer('year');
            $table->enum('status', ['ongoing', 'completed', 'upcoming', 'cancelled'])->default('upcoming');
            $table->integer('episodes_count')->default(0);
            $table->integer('duration_minutes')->nullable(); // Duración promedio por episodio
            $table->decimal('rating', 3, 2)->default(0.00); // Rating de 0.00 a 10.00
            $table->integer('rating_count')->default(0);
            $table->boolean('is_featured')->default(false); // Para destacados en home
            $table->json('metadata')->nullable(); // Datos adicionales (cast, etc.)
            $table->timestamps();
            
            $table->index(['status', 'is_featured']);
            $table->index(['year', 'rating']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('animes');
    }
};
