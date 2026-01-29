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
        $table->string('name');
        $table->string('city'); // SEBELUMNYA 'location', UBAH JADI 'city'
        $table->integer('total_rows');
        $table->integer('total_cols');
        $table->json('layout_config')->nullable();
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('studios');
    }
};
