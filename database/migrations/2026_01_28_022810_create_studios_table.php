<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // database/migrations/xxxx_xx_xx_create_studios_table.php
public function up()
{
    Schema::create('studios', function (Blueprint $table) {
        $table->id();
        $table->string('name');         // Contoh: "Studio 1 - IMAX"
        $table->string('location');     // Contoh: "Jakarta - Grand Indonesia"
        $table->integer('total_rows');  // Contoh: 8 baris
        $table->integer('total_cols');  // Contoh: 10 kolom (Total 80 kursi)
        $table->json('layout_config')->nullable(); // Opsional: Jika ada lorong/layout aneh
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
