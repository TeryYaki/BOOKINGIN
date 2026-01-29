<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    // Cek apakah kolom ticket_price SUDAH ADA. Jika BELUM, baru tambahkan.
    if (!Schema::hasColumn('movies', 'ticket_price')) {
        Schema::table('movies', function (Blueprint $table) {
            $table->integer('ticket_price')->default(45000); 
            // Sesuaikan tipe data/default dengan kodingan asli Anda jika berbeda
        });
    }
}

    public function down()
    {
        Schema::table('movies', function (Blueprint $table) {
            $table->dropColumn('ticket_price');
        });
    }
};
