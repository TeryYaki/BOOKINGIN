<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Showtime;
use App\Models\Movie;
use App\Models\Studio;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB; // Pastikan ini ditambahkan

class ShowtimeController extends Controller
{
    // Tampilkan Form Tambah Jadwal
    public function create()
    {
        $movies = Movie::where('status', 'now_showing')->get();
        $studios = Studio::all();
        
        return view('admin.showtimes.create', compact('movies', 'studios'));
    }

    // Simpan Jadwal Massal
    public function store(Request $request)
    {
        // Validasi input sebagai array
        $request->validate([
            'schedules' => 'required|array|min:1',
            'schedules.*.movie_id' => 'required|exists:movies,id',
            'schedules.*.studio_id' => 'required|exists:studios,id',
            'schedules.*.date' => 'required|date',
            'schedules.*.start_time' => 'required',
            'schedules.*.price' => 'required|numeric|min:0'
        ]);

        // Gunakan Transaction untuk efisiensi dan keamanan database
        DB::transaction(function () use ($request) {
            foreach ($request->schedules as $item) {
                
                // Hitung End Time Otomatis per baris
                try {
                    $startTime = Carbon::createFromFormat('H:i', $item['start_time']);
                } catch (\Exception $e) {
                    $startTime = Carbon::createFromFormat('H:i:s', $item['start_time']);
                }
                
                // Tambah 2 jam 15 menit (135 menit)
                $endTime = $startTime->copy()->addMinutes(135);

                Showtime::create([
                    'movie_id'   => $item['movie_id'],
                    'studio_id'  => $item['studio_id'],
                    'date'       => $item['date'],
                    'start_time' => $item['start_time'],
                    'end_time'   => $endTime->format('H:i'), 
                    'price'      => $item['price']
                ]);
            }
        });

        return redirect()->route('admin.dashboard')->with('success', 'Semua jadwal tayang berhasil ditambahkan!');
    }
}