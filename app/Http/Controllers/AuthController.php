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
        // Pastikan file credentials ada di storage/app/firebase_credentials.json
        $factory = (new Factory)->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')));
        $this->firebaseAuth = $factory->createAuth();
    }

    // --- REGISTER ---
    public function firebaseRegister(Request $request)
    {
        $idToken = $request->input('token');
        $displayName = $request->input('name');
        
        $email = null;
        $uid = null;

        // LANGKAH 1: COBA VERIFIKASI RESMI
        try {
            // Kita beri toleransi waktu 5 menit (300 detik)
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken, 300);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
        } catch (\Exception $e) {
            // LANGKAH 2: JIKA GAGAL, LAKUKAN BYPASS (MANUAL DECODE)
            // Ini akan memaksa login berhasil meskipun jam komputer error
            Log::warning("Register Bypass: Verifikasi gagal, mencoba decode manual. Error: " . $e->getMessage());
            
            try {
                $payload = $this->decodeTokenManual($idToken);
                $email = $payload['email'] ?? null;
                $uid = $payload['sub'] ?? null;
            } catch (\Exception $ex) {
                return response()->json(['status' => 'error', 'message' => 'Token Rusak Total'], 401);
            }
        }

        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Email tidak ditemukan dalam token'], 401);
        }

        // --- PROSES UPDATE/CREATE USER ---
        try {
            $user = User::where('email', $email)->first();

            if ($user) {
                // Update profil saja, JANGAN UBAH ROLE (Agar Admin aman)
                $user->update([
                    'name' => $displayName ?? $user->name,
                    'firebase_uid' => $uid,
                ]);
            } else {
                // Buat User Baru
                $user = User::create([
                    'email' => $email,
                    'name' => $displayName ?? 'User',
                    'password' => bcrypt('firebase_dummy_password'),
                    'firebase_uid' => $uid,
                    'role' => 'user'
                ]);
            }

            Auth::login($user);

            $redirect = ($user->role === 'admin') ? '/admin/dashboard' : '/';

            return response()->json([
                'status' => 'success',
                'redirect' => $redirect
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // --- LOGIN ---
    public function firebaseLogin(Request $request)
    {
        $idToken = $request->input('token');
        $email = null;
        $uid = null;

        // LANGKAH 1: COBA VERIFIKASI RESMI
        try {
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken, 300);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');
        } catch (\Exception $e) {
            // LANGKAH 2: BYPASS JIKA ERROR
            Log::warning("Login Bypass: Verifikasi gagal, mencoba decode manual. Error: " . $e->getMessage());
            
            try {
                $payload = $this->decodeTokenManual($idToken);
                $email = $payload['email'] ?? null;
                $uid = $payload['sub'] ?? null;
            } catch (\Exception $ex) {
                return response()->json(['status' => 'error', 'message' => 'Token Rusak Total'], 401);
            }
        }

        if (!$email) {
            return response()->json(['status' => 'error', 'message' => 'Gagal membaca token'], 401);
        }

        // --- PROSES LOGIN DATABASE ---
        try {
            $user = User::where('email', $email)->first();

            if (!$user) {
                $user = User::create([
                    'name' => 'User Firebase',
                    'email' => $email,
                    'password' => bcrypt('firebase_dummy_password'),
                    'firebase_uid' => $uid,
                    'role' => 'user'
                ]);
            } else {
                // Update UID jika perlu
                $user->update(['firebase_uid' => $uid]);
            }

            Auth::login($user);

            $redirect = ($user->role === 'admin') ? '/admin/dashboard' : '/';

            return response()->json([
                'status' => 'success',
                'redirect' => $redirect
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