<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Studio;
use Carbon\Carbon; // [PENTING] Import library untuk hitung jam

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

        // [PERBAIKAN] Hitung End Time Otomatis
        // Asumsi durasi film standar 2 jam (120 menit) + 15 menit bersih-bersih
        // Jika Anda punya kolom 'duration' di tabel movies, bisa ambil dari sana.
        try {
            $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        } catch (\Exception $e) {
            // Fallback jika format input berbeda (misal H:i:s)
            $startTime = Carbon::createFromFormat('H:i:s', $request->start_time);
        }
        
        $endTime = $startTime->copy()->addMinutes(135); // Tambah 2 jam 15 menit

        Showtime::create([
            'movie_id' => $request->movie_id,
            'studio_id' => $request->studio_id,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $endTime->format('H:i'), // [PENTING] Masukkan end_time
            'price' => $request->price
        ]);

        return redirect()->route('admin.dashboard')->with('success', 'Jadwal tayang berhasil ditambahkan!');
    }
}