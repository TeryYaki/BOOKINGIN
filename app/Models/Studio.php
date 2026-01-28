<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Studio extends Model
{
    use HasFactory;

    // Izinkan semua kolom diisi (mass assignment)
    protected $guarded = [];

    // Relasi: Satu Studio punya BANYAK Jadwal Tayang
    public function showtimes()
    {
        return $this->hasMany(Showtime::class);
    }
}