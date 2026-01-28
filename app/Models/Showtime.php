<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Movie;   // <--- TAMBAHKAN INI
use App\Models\Studio;  // <--- TAMBAHKAN INI JUGA (Biar aman)

class Showtime extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function studio()
    {
        return $this->belongsTo(Studio::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}