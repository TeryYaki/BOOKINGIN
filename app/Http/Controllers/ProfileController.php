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
        // Koneksi ke Firebase (Sama seperti BookingController)
        $serviceAccountPath = base_path('firebase_credentials.json');

        if (file_exists($serviceAccountPath)) {
            // GANTI URL INI DENGAN URL DATABASE ANDA
            $databaseUri = 'https://bookingin-eb994-default-rtdb.asia-southeast1.firebasedatabase.app/';

            $factory = (new Factory)
                ->withServiceAccount($serviceAccountPath)
                ->withDatabaseUri($databaseUri);
            
            $this->firebaseDatabase = $factory->createDatabase();
        } else {
            $this->firebaseDatabase = null;
        }
    }

    public function index()
    {
        $user = Auth::user();
        $tickets = [];

        if ($this->firebaseDatabase) {
            $userId = $user->firebase_uid ?? 'user_' . $user->id;

            // --- HAPUS TRY/CATCH, BIARKAN ERROR MUNCUL ---
            // try {
                $reference = $this->firebaseDatabase->getReference('tickets/' . $userId);
                $snapshot = $reference->getValue(); // <--- Jika SSL Error, ini akan meledak dan menampilkan pesan di layar

                if ($snapshot) {
                    $tickets = collect($snapshot)->sortByDesc('timestamp');
                }
            // } catch (\Exception $e) {
            //    // Diamkan error
            // }
        }

        return view('profile', compact('user', 'tickets'));
    }
}