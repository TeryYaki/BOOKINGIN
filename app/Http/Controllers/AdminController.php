<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Studio;
use App\Models\Showtime;
use Kreait\Firebase\Factory; 
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator; 
use DateTime; // Untuk format nama bulan

class AdminController extends Controller {

    protected $firebaseDatabase;

    public function __construct()
    {
        // 1. KONEKSI FIREBASE
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/'; 
            
            try {
                $factory = (new Factory)
                    ->withServiceAccount($serviceAccountPath)
                    ->withDatabaseUri($databaseUri);
                
                $this->firebaseDatabase = $factory->createDatabase();
            } catch (\Throwable $e) {
                $this->firebaseDatabase = null;
            }
        }
    }
    
    public function dashboard(Request $request) {
        // --- 1. SETTING FILTER (Dari Request atau Default) ---
        $selectedMonth = $request->input('month', date('n')); // Default: Bulan ini
        $selectedYear  = $request->input('year', date('Y'));  // Default: Tahun ini
        $filterType    = $request->input('filter_type', 'monthly'); // monthly atau yearly

        // --- 2. SIAPKAN VARIABEL PENAMPUNG ---
        $allTickets = [];
        $totalRevenue = 0; // Ini yang akan difilter
        $totalTickets = 0;
        $availableYears = []; // Untuk dropdown tahun

        // --- 3. AMBIL DATA DARI FIREBASE ---
        if ($this->firebaseDatabase) {
            $reference = $this->firebaseDatabase->getReference('tickets');
            $snapshot = $reference->getValue();

            if ($snapshot) {
                foreach ($snapshot as $userId => $orders) {
                    foreach ($orders as $orderId => $data) {
                        
                        // Parse Tanggal Transaksi
                        // Jika ada 'timestamp' (ms), pakai itu. Jika tidak, pakai now().
                        $dateObj = isset($data['timestamp']) 
                                   ? Carbon::createFromTimestamp($data['timestamp'] / 1000) 
                                   : now();
                        
                        $transYear = $dateObj->year;
                        $transMonth = $dateObj->month;

                        // Kumpulkan Tahun Unik untuk Dropdown
                        if (!in_array($transYear, $availableYears)) {
                            $availableYears[] = $transYear;
                        }

                        // --- LOGIKA FILTER PENDAPATAN ---
                        // Cek apakah transaksi ini lolos filter?
                        $isIncluded = false;

                        if ($filterType == 'yearly') {
                            // Filter Tahunan: Cukup cek tahunnya sama
                            if ($transYear == $selectedYear) {
                                $isIncluded = true;
                            }
                        } else {
                            // Filter Bulanan: Cek bulan DAN tahun
                            if ($transYear == $selectedYear && $transMonth == $selectedMonth) {
                                $isIncluded = true;
                            }
                        }

                        // Jika lolos filter, tambahkan ke Total Revenue
                        if ($isIncluded) {
                            $totalRevenue += ($data['price'] ?? 0);
                            // Opsional: Hitung tiket yang terjual pada periode ini saja
                            // $totalTickets++; 
                        }
                        
                        // Note: $totalTickets biasanya dihitung total semua (tanpa filter) 
                        // atau bisa juga difilter. Di sini saya hitung total global agar data tabel tetap lengkap.
                        $totalTickets++;


                        // Format Data untuk Tabel Riwayat (Tampilkan SEMUA riwayat, sorting nanti)
                        $seats = is_array($data['seats'] ?? []) 
                                 ? implode(', ', $data['seats'] ?? []) 
                                 : ($data['seats'] ?? '-');

                        $allTickets[] = (object) [
                            'order_id'    => $data['order_id'] ?? $orderId,
                            'user_name'   => $data['user_name'] ?? 'Guest',
                            'movie_title' => $data['movie_title'] ?? 'Unknown',
                            'seats'       => $seats,
                            'total_price' => $data['price'] ?? 0,
                            'region'      => $data['region'] ?? '-',
                            'screening_date' => $data['date'] ?? '-', 
                            'screening_time' => $data['time'] ?? '-',
                            'created_at'  => $dateObj
                        ];
                    }
                }
            }
        }

        // Urutkan Tahun Descending (2025, 2024...)
        rsort($availableYears);
        if (empty($availableYears)) $availableYears = [date('Y')];

        // --- 4. SORTING & PAGINATION (Untuk Tabel Bawah) ---
        usort($allTickets, function($a, $b) {
            return $b->created_at <=> $a->created_at; 
        });

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5; 
        $currentItems = array_slice($allTickets, ($currentPage - 1) * $perPage, $perPage);
        
        $recentTransactions = new LengthAwarePaginator(
            $currentItems, 
            count($allTickets), 
            $perPage, 
            $currentPage, 
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // --- 5. STATISTIK LAIN (SQL LOCAL) ---
        $movies = Movie::latest()->get();
        $totalMovies = Movie::count();
        $totalStudios = Studio::count(); // Pastikan model Studio diimport
        $totalShowtimes = Showtime::count(); // Pastikan model Showtime diimport

        return view('admin.dashboard', compact(
            'movies', 
            'totalRevenue', // Sudah difilter
            'totalTickets', // Global
            'totalMovies',
            'totalStudios',
            'totalShowtimes',
            'recentTransactions',
            'selectedMonth',
            'selectedYear',
            'availableYears'
        ));
    }

   // --- FUNGSI TAMBAH FILM ---
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'poster' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:now_showing,upcoming',
            'ticket_price' => 'required|numeric|min:0',
            'trailer_url' => 'nullable|url'
        ]);

        if ($request->hasFile('poster')) {
            $imageName = time() . '.' . $request->poster->extension();
            $request->poster->move(public_path('Images/movies'), $imageName);
            $validatedData['poster_path'] = 'Images/movies/' . $imageName;
        }

        unset($validatedData['poster']);
        Movie::create($validatedData);

        return redirect()->route('admin.dashboard')->with('success', 'Film berhasil ditambahkan!');
    }

    // --- FUNGSI EDIT FILM ---
    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'ticket_price' => 'required|numeric|min:0'
        ]);

        $movie = Movie::findOrFail($id);

        $dataToUpdate = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'ticket_price' => $request->ticket_price
        ];

        if ($request->hasFile('poster')) {
            $imageName = time().'.'.$request->poster->extension();
            $request->poster->move(public_path('Images/movies'), $imageName);
            $dataToUpdate['poster_path'] = 'Images/movies/'.$imageName;
        }

        $movie->update($dataToUpdate);

        return redirect()->route('admin.dashboard')->with('success', 'Data film berhasil diperbarui!');
    }

    // --- FUNGSI HAPUS FILM ---
    public function destroy($id) {
        $movie = Movie::findOrFail($id);
        
        // Opsional: Hapus file gambar poster jika ada
        if ($movie->poster_path && file_exists(public_path($movie->poster_path))) {
            @unlink(public_path($movie->poster_path));
        }

        $movie->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Film berhasil dihapus!');
    }
}