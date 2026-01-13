<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bookingin</title>
    <style>
        /* CSS Desain Asli Anda */
        body {
            font-family: Arial, sans-serif;
            margin: 0; padding: 0; height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: url('images/the-premiere-1.jpg') no-repeat center center fixed;
            background-size: cover; position: relative;
        }
        body::before {
            content: ''; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background: inherit; filter: blur(8px); z-index: -1;
        }
        .card {
            background: rgba(255, 255, 255, 0.7);
            width: 360px; padding: 30px; border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px); position: relative; z-index: 1;
        }
        h2 { text-align: center; margin-bottom: 25px; color: #333; }
        input { width: 100%; padding: 12px; margin-top: 10px; border: 1px solid #ccc; border-radius: 8px; box-sizing: border-box; }
        button { width: 100%; padding: 12px; margin-top: 20px; background: #222; color: white; border: none; border-radius: 8px; cursor: pointer; transition: 0.3s; }
        button:hover { background: #444; }
        button:disabled { background: #777; cursor: not-allowed; }
        .error { color: red; font-size: 12px; margin-top: 10px; display: none; text-align: center; }
        .link { text-align: center; margin-top: 15px; font-size: 14px; }
        .link a { color: #222; font-weight: bold; text-decoration: none; }
    </style>
</head>
<body>

<div class="card">
    <h2>Login</h2>
    
    <div id="errorMessage" class="error"></div>

    <form id="loginForm">
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="password" placeholder="Password" required>
        
        <button type="submit" id="loginBtn">Masuk</button>
        
        <div class="link">
            Belum punya akun? <a href="/register">Daftar</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="module">
    // Import Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // --- ISI CONFIG FIREBASE DI SINI (COPY DARI FIREBASE CONSOLE) ---
    const firebaseConfig = {
        apiKey: "AIzaSyCc1j2rkEI6M8mlFgDpiY77GIu3VyOm4T8",
        authDomain: "bookingin-eb994.firebaseapp.com",
        projectId: "bookingin-eb994",
        storageBucket: "bookingin-eb994.firebasestorage.app",
        messagingSenderId: "969038093060",
        appId: "1:969038093060:web:0bf3103bce1d8373930e51",
    };

    // Inisialisasi
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    // Logika Login
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault(); // Mencegah reload halaman biasa

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn = document.getElementById('loginBtn');
        const err = document.getElementById('errorMessage');

        // Reset tampilan saat loading
        err.style.display = 'none';
        btn.disabled = true;
        btn.innerText = 'Memproses...';

        // 1. Coba Login ke Firebase
        signInWithEmailAndPassword(auth, email, password)
            .then((userCredential) => {
                // 2. Jika berhasil, ambil Token
                return userCredential.user.getIdToken();
            })
            .then((token) => {
                // 3. Kirim Token ke Laravel (Backend)
                return axios.post('/login-firebase', {
                    token: token
                });
            })
            .then((response) => {
                // 4. Jika Laravel membalas "success", pindah halaman
                if (response.data.status === 'success') {
                    window.location.href = response.data.redirect;
                }
            })
            .catch((error) => {
                console.error(error); // Cek Console browser jika ingin detail
                
                // Tampilkan pesan error ke user
                btn.disabled = false;
                btn.innerText = 'Masuk';
                
                let pesan = "Login Gagal.";
                if (error.code === 'auth/invalid-credential') {
                    pesan = "Email atau Password salah.";
                } else if (error.code === 'auth/user-not-found') {
                    pesan = "Akun tidak ditemukan. Silakan daftar.";
                } else if (error.response) {
                    pesan = "Server Error: " + error.response.status;
                }
                
                err.innerText = pesan;
                err.style.display = 'block';
            });
    });
</script>

</body>
</html>