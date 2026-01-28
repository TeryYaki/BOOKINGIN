<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Studio; // [PENTING] Jangan lupa import ini
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request) 
    {
        $query = Movie::query();

        // 1. Filter Judul (Search)
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // 2. Filter Lokasi (Advanced Relation)
        // Logika: Cari film yang PUNYA jadwal tayang DI studio yang kotanya X
        if ($request->filled('location')) {
            $query->whereHas('showtimes.studio', function($q) use ($request) {
                $q->where('city', $request->location);
            });
        }

        // Eksekusi Query dengan Eager Loading
        $movies = $query->with('showtimes')->latest()->get(); 
        
        // Ambil daftar kota unik untuk dropdown di View
        $cities = Studio::select('city')->distinct()->orderBy('city')->pluck('city');

        // Pastikan nama view sesuai dengan file blade Anda.
        // Jika file ada di resources/views/movies.blade.php gunakan 'movies'
        // Jika file ada di resources/views/Movies/index.blade.php gunakan 'Movies.index'
        return view('movies', compact('movies', 'cities'));
    }
}