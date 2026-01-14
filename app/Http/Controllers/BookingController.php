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
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            // URL DATABASE YANG BENAR (SUDAH DIPERBAIKI)
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/'; 
            
            try {
                $factory = (new Factory)
                    ->withServiceAccount($serviceAccountPath)
                    ->withDatabaseUri($databaseUri);
                
                $this->firebaseDatabase = $factory->createDatabase();
            } catch (\Throwable $e) {
                $this->firebaseDatabase = null;
            }
        } else {
            $this->firebaseDatabase = null;
        }
    }

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

    public function showPayment()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');
        return view('payment', compact('booking'));
    }

    public function success()
    {
        $booking = session('booking');

        if (!$booking) {
            return redirect('/')->with('error', 'Sesi habis.');
        }

        $user = Auth::user();

        // Cek Koneksi
        if (!$this->firebaseDatabase) {
            dd("ERROR: Tidak dapat terhubung ke Firebase. Cek file 'firebase_credentials.json' atau URL Database.");
        }

        // Logika ID User (Harus sama dengan ProfileController)
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
            // Simpan Data
            $this->firebaseDatabase
                 ->getReference('tickets/' . $userId . '/' . $booking['order_id'])
                 ->set($firebaseData);
                 
        } catch (\Throwable $e) {
            dd("GAGAL SIMPAN KE FIREBASE: " . $e->getMessage());
        }

        $finalTicket = $booking;
        session()->forget('booking');

        return view('ticket', ['booking' => $finalTicket]);
    }
}