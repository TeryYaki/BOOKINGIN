<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase\Factory;

class ProfileController extends Controller
{
    protected $firebaseDatabase;

    public function __construct()
    {
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            // PASTIKAN URL INI SAMA DENGAN YANG ADA DI BOOKING CONTROLLER
            $databaseUri = 'https://bookingin-1b326-default-rtdb.asia-southeast1.firebasedatabase.app/'; 

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

    public function index()
    {
        $user = Auth::user();
        $tickets = [];

        if ($this->firebaseDatabase) {
            // --- PERBAIKAN DI SINI ---
            // Kita gunakan logika yang sama dengan BookingController:
            // Jika firebase_uid ada, pakai itu. Jika tidak, pakai "user_ID" dari database MySQL.
            $userId = $user->firebase_uid ?? 'user_' . $user->id;

            try {
                // Ambil data dari path: tickets/user_1
                $reference = $this->firebaseDatabase->getReference('tickets/' . $userId);
                
                $snapshot = $reference->getValue();

                if ($snapshot) {
                    // Urutkan dari yang terbaru (berdasarkan timestamp)
                    $tickets = collect($snapshot)->sortByDesc('timestamp');
                }
            } catch (\Exception $e) {
                // Jika error, biarkan kosong agar halaman tidak crash
            }
        }

        return view('profile', compact('user', 'tickets'));
    }
}