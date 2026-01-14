<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class BookingController extends Controller
{
    protected $firebaseDatabase;
    protected $connectionError; // Variabel baru untuk menampung pesan error

    public function __construct()
    {
        // 1. Cek File Credentials
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            // URL Database (Pastikan ini benar dari Firebase Console Anda)
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/'; 

            try {
                $factory = (new Factory)
                    ->withServiceAccount($serviceAccountPath)
                    ->withDatabaseUri($databaseUri);
                
                $this->firebaseDatabase = $factory->createDatabase();
            } catch (\Throwable $e) {
                // TANGKAP ERRORNYA, JANGAN DIABAIKAN
                $this->firebaseDatabase = null;
                $this->connectionError = "Gagal Inisialisasi Firebase: " . $e->getMessage();
            }
        } else {
            $this->firebaseDatabase = null;
            $this->connectionError = "File 'firebase_credentials.json' TIDAK DITEMUKAN di: " . $serviceAccountPath;
        }
    }

    // 1. PROSES HITUNG HARGA
    public function process(Request $request)
    {
        $request->validate([
            'movie_id' => 'required',
            'seats' => 'required',
            'time' => 'required'
        ]);

        $movie = Movie::findOrFail($request->movie_id);
        $seats = explode(',', $request->seats); 
        $totalPrice = count($seats) * 45000;

        $bookingData = [
            'movie_id' => $movie->id,
            'movie_title' => $movie->title,
            'poster' => $movie->poster_path,
            'seats' => $seats,
            'time' => $request->time,
            'total_price' => $totalPrice,
            'order_id' => 'TIX-' . strtoupper(uniqid()), 
            'created_at' => now()->toDateTimeString()
        ];

        // PERBAIKAN: Gunakan session() agar data tidak hilang saat refresh/pindah halaman
        session(['booking' => $bookingData]);

        return redirect()->route('payment.show');
    }

    // 2. HALAMAN PEMBAYARAN
    public function showPayment()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');
        return view('payment', compact('booking'));
    }

    // 3. SUKSES BAYAR
    public function success()
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect('/')->with('error', 'Sesi habis.');
        }

        // --- DETEKTIF ERROR BEKERJA DI SINI ---
        if (!$this->firebaseDatabase) {
            // Tampilkan pesan error spesifik yang kita simpan di __construct tadi
            dd("STOP! Gagal Konek ke Firebase. Penyebab: " . $this->connectionError);
        }

        $user = Auth::user();
        $userId = $user->firebase_uid ?? 'user_' . $user->id;

        $firebaseData = [
            'order_id' => $booking['order_id'],
            'movie_title' => $booking['movie_title'],
            'seats' => $booking['seats'],
            'time' => $booking['time'],
            'price' => $booking['total_price'],
            'user_name' => $user->name,
            'user_email' => $user->email,
            'poster' => asset($booking['poster']),
            'timestamp' => ['.sv' => 'timestamp']
        ];

        try {
            // Simpan ke Firebase
            $this->firebaseDatabase
                 ->getReference('tickets/' . $userId . '/' . $booking['order_id'])
                 ->set($firebaseData);
                 
        } catch (\Throwable $e) {
            dd("GAGAL SIMPAN (Write Error): " . $e->getMessage());
        }

        // Hapus session dan tampilkan tiket
        $finalTicket = $booking;
        session()->forget('booking');

        return view('ticket', ['booking' => $finalTicket]);
    }
}