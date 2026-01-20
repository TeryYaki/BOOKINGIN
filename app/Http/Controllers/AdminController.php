<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Kreait\Firebase\Factory; 
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator; 

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
    
    public function dashboard() {
        // 2. AMBIL DATA DARI FIREBASE (Logic tetap sama seperti sebelumnya)
        $allTickets = [];
        $totalRevenue = 0;
        $totalTickets = 0;

        if ($this->firebaseDatabase) {
            $reference = $this->firebaseDatabase->getReference('tickets');
            $snapshot = $reference->getValue();

            if ($snapshot) {
                foreach ($snapshot as $userId => $orders) {
                    foreach ($orders as $orderId => $data) {
                        
                        $seats = is_array($data['seats'] ?? []) 
                                 ? implode(', ', $data['seats'] ?? []) 
                                 : ($data['seats'] ?? '-');

                        $date = isset($data['timestamp']) 
                                ? Carbon::createFromTimestamp($data['timestamp'] / 1000) 
                                : now();

                        $allTickets[] = (object) [
                            'order_id'    => $data['order_id'] ?? $orderId,
                            'user_name'   => $data['user_name'] ?? 'Guest',
                            'movie_title' => $data['movie_title'] ?? 'Unknown',
                            'seats'       => $seats,
                            'total_price' => $data['price'] ?? 0,
                            'region'      => $data['region'] ?? '-',
                            'screening_date' => $data['date'] ?? '-', 
                            'screening_time' => $data['time'] ?? '-',
                            'created_at'  => $date
                        ];

                        $totalRevenue += ($data['price'] ?? 0);
                        $totalTickets++;
                    }
                }
            }
        }

        // Sorting & Pagination
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

        // Ambil Data Film (SQL Local)
        $movies = Movie::latest()->get();
        $totalMovies = Movie::count();

        return view('admin.dashboard', compact(
            'movies', 
            'totalRevenue', 
            'totalTickets', 
            'totalMovies', 
            'recentTransactions'
        ));
    }

    // --- FUNGSI TAMBAH FILM (UPDATE: Simpan Harga) ---
    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'poster' => 'required|image',
            'status' => 'required',
            'ticket_price' => 'required|numeric|min:0' // Validasi Harga
        ]);

        $imageName = time().'.'.$request->poster->extension();
        $request->poster->move(public_path('images/movies'), $imageName);

        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'poster_path' => 'images/movies/'.$imageName,
            'status' => $request->status,
            'ticket_price' => $request->ticket_price // Simpan ke Database
        ]);
        
        return redirect()->back()->with('success', 'Film berhasil ditambahkan!');
    }

    // --- FUNGSI EDIT FILM (BARU) ---
    public function update(Request $request, $id) {
        // Validasi input edit
        $request->validate([
            'title' => 'required',
            'status' => 'required',
            'ticket_price' => 'required|numeric|min:0'
        ]);

        $movie = Movie::findOrFail($id);

        // Data yang akan diupdate
        $dataToUpdate = [
            'title' => $request->title,
            'description' => $request->description,
            'status' => $request->status,
            'ticket_price' => $request->ticket_price
        ];

        // Cek jika admin mengupload poster baru (Optional)
        if ($request->hasFile('poster')) {
            $imageName = time().'.'.$request->poster->extension();
            $request->poster->move(public_path('images/movies'), $imageName);
            
            // Update path poster baru
            $dataToUpdate['poster_path'] = 'images/movies/'.$imageName;
        }

        // Lakukan update ke database
        $movie->update($dataToUpdate);

        return redirect()->back()->with('success', 'Data film berhasil diperbarui!');
    }

    // --- FUNGSI HAPUS FILM ---
    public function destroy($id) {
        Movie::destroy($id);
        return redirect()->back()->with('success', 'Film berhasil dihapus!');
    }
}