<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Showtime; 
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;
use Illuminate\Support\Facades\Validator; // [DITAMBAHKAN] Untuk cek validasi

class BookingController extends Controller
{
    protected $firebaseDatabase;

    public function __construct()
    {
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
        } else {
            $this->firebaseDatabase = null;
        }
    }

    // [API] Cek Kursi Terisi
    public function getOccupiedSeats(Request $request) {
        $showtimeId = $request->showtime_id;

        if (!$showtimeId) {
            return response()->json([]);
        }

        // [PERBAIKAN] Tambahkan ->where('status', 'paid') 
        // Agar hanya kursi yang "SUKSES DIBAYAR" yang diblokir (abu-abu)
        $occupied = Transaction::where('showtime_id', $showtimeId)
            ->where('status', 'paid') 
            ->pluck('seats')
            ->toArray();

        $allSeats = [];
        foreach ($occupied as $seatString) {
            $cleanString = str_replace(['"', "'", '[', ']', ' '], '', $seatString);
            $seats = explode(',', $cleanString);
            
            foreach($seats as $s) {
                if(!empty($s)) {
                    $allSeats[] = strtoupper($s); 
                }
            }
        }

        return response()->json(array_values(array_unique($allSeats)));
    }

    // 1. PROSES DATA DENGAN PENDETEKSI ERROR SUPER KETAT
    public function process(Request $request)
    {
        // [PERBAIKAN 1]: Cek apakah ada data kursi/jadwal yang kosong!
        $validator = Validator::make($request->all(), [
            'showtime_id' => 'required|exists:showtimes,id',
            'seats'       => 'required',
        ]);

        if ($validator->fails()) {
            // Jika validasi gagal (kursi belum dipilih), tampilkan alasannya ke layar
            dd('GAGAL LANJUT KE PEMBAYARAN. Alasan: ', $validator->errors()->all(), 'Data yang terkirim dari web:', $request->all());
        }

        try {
            $showtime = Showtime::with(['movie', 'studio'])->findOrFail($request->showtime_id);
            $requestedSeats = explode(',', $request->seats);

            // [PERBAIKAN 2]: Cek kursi ganda
            $existing = Transaction::where('showtime_id', $showtime->id)->get();
            foreach($existing as $trans) {
                $booked = explode(',', $trans->seats);
                if(array_intersect($requestedSeats, $booked)) {
                    // Jika bentrok, berhentikan sistem dan beri tahu pengguna!
                    dd('GAGAL: KURSI SUDAH TERISI! Anda mencoba memesan kursi yang sudah dibeli sebelumnya. Silakan kembali dan pilih kursi lain.');
                }
            }

            $totalPrice = count($requestedSeats) * $showtime->price;

            // [PERBAIKAN 3]: Gunakan optional() agar tidak error 500 jika relasi Studio/Movie dihapus/kosong
            $bookingData = [
                'showtime_id' => $showtime->id,
                'movie_title' => optional($showtime->movie)->title ?? 'Judul Tidak Ditemukan',
                'poster'      => optional($showtime->movie)->poster_path ?? '',
                'studio_name' => optional($showtime->studio)->name ?? 'Studio 01',
                'region'      => optional($showtime->studio)->region ?? 'Jakarta', 
                'date'        => $showtime->date,         
                'time'        => $showtime->start_time,   
                'seats'       => $requestedSeats,
                'total_price' => $totalPrice,
                'order_id'    => 'TIX-' . strtoupper(uniqid()), 
            ];

            session(['booking' => $bookingData]);

            return redirect()->route('payment.show');

        } catch (\Throwable $e) {
            // [PERBAIKAN 4]: Tangkap error misterius lainnya
            dd('TERJADI ERROR SISTEM SAAT MEMPROSES DATA:', $e->getMessage());
        }
    }

    public function showPayment()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');
        return view('payment', compact('booking'));
    }

    // 2. SUKSES BAYAR (Sudah dilengkapi pengecek Firebase)
    public function success()
    {
        $booking = session('booking');
        if (!$booking) return redirect('/');

        $user = Auth::user();

        // Simpan ke MySQL
        Transaction::create([
            'user_id'     => $user->id,
            'showtime_id' => $booking['showtime_id'], 
            'order_id'    => $booking['order_id'],
            'seats'       => implode(',', $booking['seats']),
            'total_price' => $booking['total_price'],
            'status'      => 'paid'
        ]);

        // Simpan ke Firebase
        if ($this->firebaseDatabase) {
            $userId = $user->firebase_uid ?? 'user_' . $user->id;
            $firebaseData = [
                'order_id'    => $booking['order_id'],
                'movie_title' => $booking['movie_title'],
                'studio'      => $booking['studio_name'],
                'region'      => $booking['region'], 
                'seats'       => implode(', ', $booking['seats']), 
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
            } catch (\Throwable $e) {
                dd('GAGAL SIMPAN KE FIREBASE: ' . $e->getMessage());
            }
        } else {
            dd('KONEKSI FIREBASE GAGAL: File firebase_credentials.json tidak ditemukan atau URL salah.');
        }

        $finalTicket = $booking;
        session()->forget('booking');

        return view('ticket', ['booking' => $finalTicket]);
    }
}