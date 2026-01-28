<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_showtimes_table.php
    public function up()
    {
    Schema::create('showtimes', function (Blueprint $table) {
        $table->id();
        $table->foreignId('movie_id')->constrained()->onDelete('cascade');
        $table->foreignId('studio_id')->constrained()->onDelete('cascade');
        $table->date('date');           // 2026-02-01
        $table->time('start_time');     // 14:00:00
        $table->time('end_time');       // 16:00:00
        $table->decimal('price', 10, 2); // Harga khusus jam ini (bisa beda weekend/weekday)
        $table->timestamps();
    });
}   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('showtimes');
    }
};
