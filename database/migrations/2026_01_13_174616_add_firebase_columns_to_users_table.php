<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Menyimpan ID unik dari Firebase
            $table->string('firebase_uid')->nullable()->unique()->after('id');
            // Menyimpan peran: 'admin' atau 'user'
            $table->string('role')->default('user')->after('email'); 
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['firebase_uid', 'role']);
        });
    }
};