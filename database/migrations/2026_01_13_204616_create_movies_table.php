<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Judul Film
            $table->text('description')->nullable(); // Sinopsis
            $table->string('poster_path'); // Lokasi Gambar
            $table->enum('status', ['now_showing', 'upcoming']); // Kategori
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('movies');
    }
};