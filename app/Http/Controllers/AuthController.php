<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $firebaseAuth;

    // Inject Firebase Auth Contract
    public function __construct(FirebaseAuth $firebaseAuth)
    {
        $this->firebaseAuth = $firebaseAuth;
    }

    // Menampilkan Halaman Login
    public function showLogin()
    {
        return view('auth.login');
    }

    // Menampilkan Halaman Register
    public function showRegister()
    {
        return view('auth.register');
    }

    // --- LOGIKA REGISTER DENGAN FIREBASE ---
    public function firebaseRegister(Request $request)
    {
        $idToken = $request->input('token');
        $displayName = $request->input('name');

        try {
            // 1. Verifikasi Token ke Server Firebase
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');

            // 2. Simpan User ke Database Laravel (MySQL)
            $user = User::updateOrCreate(
                ['email' => $email], // Cek by email
                [
                    'firebase_uid' => $uid,
                    'name' => $displayName ?? 'User Baru',
                    'password' => bcrypt(Str::random(16)), // Password dummy karena login pake Firebase
                    'role' => 'user' // Default role user biasa
                ]
            );

            // 3. Login otomatis ke Laravel
            Auth::login($user);

            return response()->json([
                'status' => 'success', 
                'message' => 'Register berhasil',
                'redirect' => '/dashboard' // Ganti sesuai halaman setelah login
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    // --- LOGIKA LOGIN DENGAN FIREBASE ---
    public function firebaseLogin(Request $request)
    {
        $idToken = $request->input('token');

        try {
            // 1. Verifikasi Token
            $verifiedIdToken = $this->firebaseAuth->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');
            $email = $verifiedIdToken->claims()->get('email');

            // 2. Cari User di Database Lokal
            $user = User::where('firebase_uid', $uid)->orWhere('email', $email)->first();

            if (!$user) {
                // Jika user ada di Firebase tapi belum ada di DB Lokal (Sangat jarang terjadi jika alur register benar)
                // Kita buatkan datanya
                 $user = User::create([
                    'firebase_uid' => $uid,
                    'name' => 'User Firebase',
                    'email' => $email,
                    'password' => bcrypt(Str::random(16)),
                    'role' => 'user'
                ]);
            }

            // Update UID jika login lewat email biasa sebelumnya
            if ($user->firebase_uid !== $uid) {
                $user->firebase_uid = $uid;
                $user->save();
            }

            // 3. Login ke Session Laravel
            Auth::login($user);

            // 4. Cek Role untuk Redirect
            $redirectUrl = ($user->role === 'admin') ? '/admin/dashboard' : '/';

            return response()->json([
                'status' => 'success',
                'role' => $user->role,
                'redirect' => $redirectUrl
            ]);

        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 401);
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}