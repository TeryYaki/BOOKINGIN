<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Studio;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    public function index(Request $request) 
    {
        // Mulai Query
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

        // Eksekusi Query
        $movies = $query->with('showtimes')->get(); // 'with' agar query lebih ringan (eager loading)
        
        // Ambil daftar kota unik untuk dropdown
        $cities = Studio::select('city')->distinct()->orderBy('city')->pluck('city');

        return view('movies.index', compact('movies', 'cities'));
    }
}