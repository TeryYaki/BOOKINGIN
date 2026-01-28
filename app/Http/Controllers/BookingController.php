<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Showtime; // [PENTING] Pakai Model Showtime
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class BookingController extends Controller
{
    protected $firebaseDatabase;

    public function __construct()
    {
        // ... (Kode koneksi Firebase sama seperti sebelumnya, tidak berubah) ...
        $serviceAccountPath = base_path('firebase_credentials.json');
        if (file_exists($serviceAccountPath)) {
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/'; 
            try {
                $factory = (new Factory)->withServiceAccount($serviceAccountPath)->withDatabaseUri($databaseUri);
                $this->firebaseDatabase = $factory->createDatabase();
            } catch (\Throwable $e) { $this->firebaseDatabase = null; }
        }
    }

    // [API] Cek Kursi Terisi berdasarkan ID JADWAL (Lebih simpel & akurat)
    public function getOccupiedSeats(Request $request) {
        $showtimeId = $request->showtime_id;

        // Cukup cari transaksi di showtime ini
        $occupied = Transaction::where('showtime_id', $showtimeId)
            ->pluck('seats')
            ->toArray();

        $allSeats = [];
        foreach ($occupied as $seatString) {
            $seats = explode(',', $seatString);
            $allSeats = array_merge($allSeats, $seats);
        }

        return response()->json($allSeats);
    }

    // 1. PROSES DATA
    public function process(Request $request)
    {
        // Validasi: Sekarang kita cuma butuh showtime_id dan seats
        $request->validate([
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required',
        ]);

        // Ambil Data Jadwal Lengkap (termasuk Film & Studio)
        $showtime = Showtime::with(['movie', 'studio'])->findOrFail($request->showtime_id);
        
        $requestedSeats = explode(',', $request->seats);

        // Validasi Double Booking (Cek MySQL)
        $existing = Transaction::where('showtime_id', $showtime->id)->get();
        foreach($existing as $trans) {
            $booked = explode(',', $trans->seats);
            if(array_intersect($requestedSeats, $booked)) {
                return redirect()->back()->with('error', 'Kursi sudah terisi!');
            }
        }

        // Hitung Harga (Ambil dari harga khusus jadwal tersebut)
        $totalPrice = count($requestedSeats) * $showtime->price;

        // Simpan ke Session (Struktur Data Disederhanakan)
        $bookingData = [
            'showtime_id' => $showtime->id,
            'movie_title' => $showtime->movie->title,
            'poster'      => $showtime->movie->poster_path,
            'studio_name' => $showtime->studio->name, // Info Studio
            'date'        => $showtime->date,         // Info Tanggal
            'time'        => $showtime->start_time,   // Info Jam
            'seats'       => $requestedSeats,
            'total_price' => $totalPrice,
            'order_id'    => 'TIX-' . strtoupper(uniqid()), 
        ];

        session(['booking' => $bookingData]);

        return redirect()->route('payment.show');
    }

    public function showPayment()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');
        return view('payment', compact('booking'));
    }

    // 2. SUKSES BAYAR
    public function success()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');

        $user = Auth::user();

        // [PENTING] Simpan ke MySQL menggunakan showtime_id
        Transaction::create([
            'user_id'     => $user->id,
            'showtime_id' => $booking['showtime_id'], // KUNCI UTAMA
            'order_id'    => $booking['order_id'],
            'seats'       => implode(',', $booking['seats']),
            'total_price' => $booking['total_price'],
            'status'      => 'paid'
        ]);

        // Simpan ke Firebase (Opsional: strukturnya boleh tetap flat agar mudah dibaca di console)
        if ($this->firebaseDatabase) {
            $userId = $user->firebase_uid ?? 'user_' . $user->id;
            $firebaseData = [
                'order_id'    => $booking['order_id'],
                'movie_title' => $booking['movie_title'],
                'studio'      => $booking['studio_name'], // Tambahan info studio
                'seats'       => $booking['seats'],
                'date'        => $booking['date'],
                'time'        => $booking['time'],
                'price'       => $booking['total_price'],
                'user_name'   => $user->name,
                'poster'      => asset($booking['poster']),
                'timestamp'   => ['.sv' => 'timestamp'] 
            ];
            
            try {
                $this->firebaseDatabase
                     ->getReference('tickets/' . $userId . '/' . $booking['order_id'])
                     ->set($firebaseData);
            } catch (\Throwable $e) {}
        }

        $finalTicket = $booking;
        session()->forget('booking');

        return view('ticket', ['booking' => $finalTicket]);
    }
}