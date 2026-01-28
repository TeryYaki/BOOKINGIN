<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Studio;

class ShowtimeController extends Controller
{
    // Tampilkan Form Tambah Jadwal
    public function create()
    {
        // Kita butuh data Film dan Studio untuk dropdown
        $movies = Movie::where('status', 'now_showing')->get();
        $studios = Studio::all();
        
        return view('admin.showtimes.create', compact('movies', 'studios'));
    }

    // Simpan Jadwal
    public function store(Request $request)
    {
        $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'studio_id' => 'required|exists:studios,id',
            'date' => 'required|date',
            'start_time' => 'required',
            'price' => 'required|numeric'
        ]);

        Showtime::create([
            'movie_id' => $request->movie_id,
            'studio_id' => $request->studio_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'price' => $request->price
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Jadwal tayang berhasil ditambahkan!');
    }
}