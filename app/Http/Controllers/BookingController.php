<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class BookingController extends Controller
{
    protected $firebaseDatabase;
    protected $connectionError;

    public function __construct()
    {
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            // URL Database Anda
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/'; 

            try {
                $factory = (new Factory)
                    ->withServiceAccount($serviceAccountPath)
                    ->withDatabaseUri($databaseUri);
                
                $this->firebaseDatabase = $factory->createDatabase();
            } catch (\Throwable $e) {
                $this->firebaseDatabase = null;
                $this->connectionError = $e->getMessage();
            }
        } else {
            $this->firebaseDatabase = null;
            $this->connectionError = "File credential tidak ditemukan.";
        }
    }

    // 1. PROSES DATA (VALIDASI & SESSION)
    public function process(Request $request)
    {
        // Validasi input region juga
        $request->validate([
            'movie_id' => 'required',
            'seats' => 'required',
            'time' => 'required',
            'region' => 'required' // <--- Tambahan Validasi
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
            'region' => $request->region, // <--- Simpan Kota ke Data
            'total_price' => $totalPrice,
            'order_id' => 'TIX-' . strtoupper(uniqid()), 
            'created_at' => now()->toDateTimeString()
        ];

        // Simpan ke Session
        session(['booking' => $bookingData]);

        return redirect()->route('payment.show');
    }

    public function showPayment()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');
        return view('payment', compact('booking'));
    }

    // 2. SUKSES BAYAR (KIRIM KE FIREBASE)
    public function success()
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect('/')->with('error', 'Sesi habis.');
        }

        if (!$this->firebaseDatabase) {
            dd("GAGAL KONEK FIREBASE: " . $this->connectionError);
        }

        $user = Auth::user();
        $userId = $user->firebase_uid ?? 'user_' . $user->id;

        $firebaseData = [
            'order_id' => $booking['order_id'],
            'movie_title' => $booking['movie_title'],
            'seats' => $booking['seats'],
            'time' => $booking['time'],
            'region' => $booking['region'], // <--- Kirim Kota ke Firebase
            'price' => $booking['total_price'],
            'user_name' => $user->name,
            'user_email' => $user->email,
            'poster' => asset($booking['poster']),
            'timestamp' => ['.sv' => 'timestamp']
        ];

        try {
            $this->firebaseDatabase
                 ->getReference('tickets/' . $userId . '/' . $booking['order_id'])
                 ->set($firebaseData);
                 
        } catch (\Throwable $e) {
            dd("GAGAL SIMPAN (Write Error): " . $e->getMessage());
        }

        $finalTicket = $booking;
        session()->forget('booking');

        return view('ticket', ['booking' => $finalTicket]);
    }
}