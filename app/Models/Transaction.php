<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi: Transaksi milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // [PENTING] Relasi ke Showtime (Pengganti Movie, Date, Time, Region)
    // Dari sini kita bisa ambil info: $transaction->showtime->movie->title
    public function showtime()
    {
        return $this->belongsTo(Showtime::class);
    }
}