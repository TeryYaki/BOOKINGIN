<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class BookingController extends Controller
{
    protected $firebaseDatabase;

    public function __construct()
    {
        // 1. Cek File Credentials
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            // --- PENTING: PASTIKAN URL INI BENAR ---
            // Cek di Firebase Console > Realtime Database
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/'; 

            try {
                $factory = (new Factory)
                    ->withServiceAccount($serviceAccountPath)
                    ->withDatabaseUri($databaseUri);
                
                $this->firebaseDatabase = $factory->createDatabase();
            } catch (\Throwable $e) {
                // Jangan die dulu di sini, nanti dicek saat mau simpan
                $this->firebaseDatabase = null;
            }
        } else {
            $this->firebaseDatabase = null;
        }
    }

    // 1. PROSES HITUNG HARGA (Simpan ke Session)
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

        return redirect()->route('payment.show')->with('booking', $bookingData);
    }

    // 2. HALAMAN PEMBAYARAN
    public function showPayment()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');
        return view('payment', compact('booking'));
    }

    // 3. SUKSES BAYAR (HANYA FIREBASE)
    public function success()
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect('/')->with('error', 'Sesi habis.');
        }

        $user = Auth::user();

        // Cek Koneksi Firebase
        if (!$this->firebaseDatabase) {
            dd("ERROR: Tidak dapat terhubung ke Firebase. Cek apakah file 'firebase_credentials.json' ada di folder project utama, atau URL Database salah.");
        }

        // Gunakan ID manual jika firebase_uid kosong
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
            // MENYIMPAN KE FIREBASE
            $this->firebaseDatabase
                 ->getReference('tickets/' . $userId . '/' . $booking['order_id'])
                 ->set($firebaseData);
                 
        } catch (\Throwable $e) {
            // JIKA GAGAL, TAMPILKAN ERROR DI LAYAR AGAR TAHU PENYEBABNYA
            dd("GAGAL SIMPAN KE FIREBASE: " . $e->getMessage());
        }

        // Jika berhasil lewat sini, hapus session dan tampilkan tiket
        $finalTicket = $booking;
        session()->forget('booking');

        return view('ticket', ['booking' => $finalTicket]);
    }
}