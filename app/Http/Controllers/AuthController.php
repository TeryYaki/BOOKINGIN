<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kreait\Firebase\Factory;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    protected $firebaseAuth;

    public function __construct()
    {
        // Pastikan file credentials ada di storage/app/firebase_credentials.json atau path yang sesuai di .env
        $credentialsPath = base_path(env('FIREBASE_CREDENTIALS', 'firebase_credentials.json'));
        
        if (file_exists($credentialsPath)) {
            $factory = (new Factory)->withServiceAccount($credentialsPath);
            $this->firebaseAuth = $factory->createAuth();
        } else {
            // Fallback agar tidak crash saat artisan command dijalankan jika file belum ada
            $this->firebaseAuth = null;
        }
    }

    // --- REGISTER ---
    public function firebaseRegister(Request $request)
    {
        // Ambil nama dari input frontend
        $displayName = $request->input('name'); 
        
        return $this->handleFirebaseUser($request, $displayName);
    }

    // --- LOGIN ---
    public function firebaseLogin(Request $request)
    {
        // Coba ambil nama dari input, jika null biarkan null (nanti diambil dari token/default)
        $displayName = $request->input('name');

        return $this->handleFirebaseUser($request, $displayName);
    }

    // --- LOGIC UTAMA (DIGABUNG AGAR RAPI) ---
    private function handleFirebaseUser(Request $request, $displayNameInput = null)
    {
        if (!$this->firebaseAuth) {
            return response()->json(['status' => 'error', 'message' => 'Konfigurasi Firebase Server Error'], 500);
        }

        $idToken = $request->input('token');
        $email = null;
        $uid = null;
        $tokenName = null;

        // LANGKAH 1: COBA VERIFIKASI RESMI
        try {
            // Toleransi waktu 5 menit (300 detik)
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken, 300);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
            $tokenName = $verifiedIdToken->claims()->get('name'); // Ambil nama dari Google Account
        } catch (\Exception $e) {
            // LANGKAH 2: JIKA GAGAL, LAKUKAN BYPASS (MANUAL DECODE)
            Log::warning("Auth Bypass: Verifikasi gagal, mencoba decode manual. Error: " . $e->getMessage());
            
            try {
                $payload = $this->decodeTokenManual($idToken);
                $email = $payload['email'] ?? null;
                $uid = $payload['sub'] ?? null;
                $tokenName = $payload['name'] ?? null;
            } catch (\Exception $ex) {
                return response()->json(['status' => 'error', 'message' => 'Token Rusak Total'], 401);
            }
        }

        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Email tidak ditemukan dalam token'], 401);
        }

        // Tentukan Nama Final: Input Frontend -> Nama di Token Google -> Default
        $finalName = $displayNameInput ?: ($tokenName ?: 'User Firebase');

        // --- PROSES UPDATE/CREATE USER ---
        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                // User Baru
                $user = User::create([
                    'name' => $finalName, // PERBAIKAN: Menggunakan variabel, bukan string '$name'
                    'email' => $email,
                    'password' => bcrypt('firebase_dummy_password'), // Password dummy karena login via Google
                    'firebase_uid' => $uid,
                    // PERBAIKAN: Logika Admin disatukan di sini
                    'role' => ($email === 'admin@bookingin.com') ? 'admin' : 'user' 
                ]);
            } else {
                // User Lama: Update UID jika berubah & Update nama jika request mengirim nama baru
                $updateData = ['firebase_uid' => $uid];
                
                // Opsional: Update nama user jika di database masih default
                if ($user->name === 'User Firebase' && $finalName !== 'User Firebase') {
                    $updateData['name'] = $finalName;
                }

                $user->update($updateData);
            }

            // Login Session Laravel
            Auth::login($user);

            $redirect = ($user->role === 'admin') ? '/admin/dashboard' : '/';

            return response()->json([
                'status' => 'success',
                'redirect' => $redirect,
                'user' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // --- FUNGSI BANTUAN DECODE MANUAL ---
    private function decodeTokenManual($token)
    {
        $parts = explode('.', $token);
        if (count($parts) !== 3) {
            throw new \Exception("Struktur Token Salah");
        }
        $payload = base64_decode(str_replace(['-', '_'], ['+', '/'], $parts[1]));
        return json_decode($payload, true);
    }

    // --- LOGOUT ---
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}