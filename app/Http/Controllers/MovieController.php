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

        // 1. Filter Judul
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

        // 2. Filter Lokasi
        if ($request->filled('location')) {
            $query->whereHas('showtimes.studio', function($q) use ($request) {
                $q->where('city', $request->location);
            });
        }

        // 3. Eksekusi dengan Optimasi Eager Loading (Nested)
        // Memuat 'showtimes' DAN 'studio' sekaligus untuk menghindari query berulang di view
        $movies = $query->with(['showtimes.studio'])->latest()->get(); 
        
        // 4. Data untuk Dropdown Filter
        $cities = Studio::select('city')->distinct()->orderBy('city')->pluck('city');

        // Pastikan nama folder view sesuai (Disarankan rename folder 'Movies' jadi 'movies' kecil)
        return view('Movies.index', compact('movies', 'cities'));
    }
}