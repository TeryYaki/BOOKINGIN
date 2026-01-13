<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migrasi untuk menambah kolom Firebase.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom firebase_uid setelah kolom id
            $table->string('firebase_uid')->nullable()->unique()->after('id');
            // Tambahkan kolom role setelah kolom email
            $table->string('role')->default('user')->after('email');
        });
    }

    /**
     * Batalkan migrasi (Hapus kolom jika rollback).
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['firebase_uid', 'role']);
        });
    }
};