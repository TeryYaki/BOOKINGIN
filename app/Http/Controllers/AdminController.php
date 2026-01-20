<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Kreait\Firebase\Factory; // Import Library Firebase
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator; // Untuk paginasi manual

class AdminController extends Controller {

    protected $firebaseDatabase;

    public function __construct()
    {
        // 1. KONEKSI FIREBASE (Sama seperti BookingController)
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
    
    public function dashboard() {
        // 2. AMBIL DATA DARI FIREBASE
        $allTickets = [];
        $totalRevenue = 0;
        $totalTickets = 0;

        if ($this->firebaseDatabase) {
            // Ambil semua data di node 'tickets'
            $reference = $this->firebaseDatabase->getReference('tickets');
            $snapshot = $reference->getValue();

            if ($snapshot) {
                // Loop User ID
                foreach ($snapshot as $userId => $orders) {
                    // Loop Order ID
                    foreach ($orders as $orderId => $data) {
                        
                        // Konversi array kursi menjadi string
                        $seats = is_array($data['seats'] ?? []) 
                                 ? implode(', ', $data['seats'] ?? []) 
                                 : ($data['seats'] ?? '-');

                        // Format Tanggal (Timestamp Firebase berupa miliseconds)
                        $date = isset($data['timestamp']) 
                                ? Carbon::createFromTimestamp($data['timestamp'] / 1000) 
                                : now();

                        // Masukkan ke array utama sebagai Object (biar mudah dibaca di Blade)
                        $allTickets[] = (object) [
                            'order_id'    => $data['order_id'] ?? $orderId,
                            'user_name'   => $data['user_name'] ?? 'Guest',
                            'movie_title' => $data['movie_title'] ?? 'Unknown Movie',
                            'seats'       => $seats,
                            'total_price' => $data['price'] ?? 0,
                            'region'      => $data['region'] ?? '-', // Menampilkan Region juga
                            'created_at'  => $date
                        ];

                        // Hitung Statistik
                        $totalRevenue += ($data['price'] ?? 0);
                        $totalTickets++;
                    }
                }
            }
        }

        // 3. SORTING (Urutkan dari yang terbaru)
        usort($allTickets, function($a, $b) {
            return $b->created_at <=> $a->created_at; 
        });

        // 4. PAGINASI MANUAL (Karena data dari array, bukan Eloquent)
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 5; // Tampilkan 5 data per halaman
        $currentItems = array_slice($allTickets, ($currentPage - 1) * $perPage, $perPage);
        
        $recentTransactions = new LengthAwarePaginator(
            $currentItems, 
            count($allTickets), 
            $perPage, 
            $currentPage, 
            ['path' => LengthAwarePaginator::resolveCurrentPath()]
        );

        // Ambil Data Film (SQL Local) untuk fitur tambah film
        $movies = Movie::latest()->get();
        $totalMovies = Movie::count();

        // 5. KIRIM KE VIEW
        return view('admin.dashboard', compact(
            'movies', 
            'totalRevenue', 
            'totalTickets', 
            'totalMovies', 
            'recentTransactions'
        ));
    }

    // --- (Fungsi Store & Destroy tetap sama, tidak berubah) ---
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'poster' => 'required|image',
            'status' => 'required'
        ]);
        $imageName = time().'.'.$request->poster->extension();
        $request->poster->move(public_path('images/movies'), $imageName);

        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'poster_path' => 'images/movies/'.$imageName,
            'status' => $request->status
        ]);
        return redirect()->back()->with('success', 'Film berhasil ditambahkan!');
    }

    public function destroy($id) {
        Movie::destroy($id);
        return redirect()->back()->with('success', 'Film berhasil dihapus!');
    }
}