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
            // URL DATABASE YANG BENAR (SUDAH DIPERBAIKI)
            // Pastikan URL ini SAMA PERSIS dengan yang ada di BookingController
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

    public function index()
    {
        $user = Auth::user();
        $tickets = [];

        if ($this->firebaseDatabase) {
            // Logika ID User (SAMA DENGAN BOOKING CONTROLLER)
            $userId = $user->firebase_uid ?? 'user_' . $user->id;

            try {
                // Ambil data dari path yang benar
                $reference = $this->firebaseDatabase->getReference('tickets/' . $userId);
                $snapshot = $reference->getValue();

                if ($snapshot) {
                    $tickets = collect($snapshot)->sortByDesc('timestamp');
                }
            } catch (\Exception $e) {
                // Diamkan error jika gagal ambil data
            }
        }

        return view('profile', compact('user', 'tickets'));
    }
}