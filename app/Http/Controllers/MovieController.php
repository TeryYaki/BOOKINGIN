<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Studio;
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

        // 2. Filter Lokasi (Cari film yang tayang di kota X)
        if ($request->filled('location')) {
            $query->whereHas('showtimes.studio', function($q) use ($request) {
                $q->where('city', $request->location);
            });
        }

        // 3. Eksekusi Query (Optimasi: Load showtimes DAN studio sekaligus)
        $movies = $query->with(['showtimes.studio'])->latest()->get(); 
        
        // 4. Ambil daftar kota unik untuk dropdown
        $cities = Studio::select('city')->distinct()->orderBy('city')->pluck('city');

        // Pastikan folder view bernama 'movies' (huruf kecil)
        return view('movies.index', compact('movies', 'cities'));
    }
}