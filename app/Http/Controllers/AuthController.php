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
        try {
            $idToken = $request->input('token');
            $displayName = $request->input('name');

            // Verifikasi Token ke Firebase
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');

            // Simpan/Update User di Database Lokal
            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $displayName ?? 'User',
                    'password' => bcrypt('firebase_dummy_password'), // Password dummy karena login pakai Google/Firebase
                    'firebase_uid' => $uid,
                    'role' => 'user'
                ]
            );

            // Login-kan user ke Laravel
            Auth::login($user);

            // Tentukan Arah Redirect (Admin -> Dashboard, User -> Beranda)
            $redirect = ($user->role === 'admin') ? '/admin/dashboard' : '/';

            return response()->json([
                'status' => 'success',
                'redirect' => $redirect
            ]);

        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    // --- LOGIN ---
    public function firebaseLogin(Request $request)
    {
        try {
            $idToken = $request->input('token');
            
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');

            // Cari user di database lokal
            $user = User::where('email', $email)->first();

            // Jika user tidak ada di lokal (tapi ada di Firebase), buatkan akun lokal
            if (!$user) {
                $user = User::create([
                    'name' => 'User Firebase',
                    'email' => $email,
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
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
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