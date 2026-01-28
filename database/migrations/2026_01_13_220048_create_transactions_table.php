<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            
            // [PERUBAHAN UTAMA DI SINI]
            // Kita ganti movie_id, date, time, region dengan satu kunci ini:
            $table->foreignId('showtime_id')->constrained()->onDelete('cascade'); 
            
            $table->string('order_id')->unique();
            $table->string('seats'); // Tetap simpan "A1,A2"
            $table->bigInteger('total_price');
            $table->string('status')->default('paid'); 
            
            // Kolom date, time, region DIHAPUS karena datanya diambil dari showtime_id
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};