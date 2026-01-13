<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - Bookingin</title>
    <style>
        body { font-family: Arial, sans-serif; background: url('images/the-premiere-1.jpg') center/cover no-repeat; display: flex; align-items: center; justify-content: center; height: 100vh; margin: 0; }
        .card { background: rgba(255, 255, 255, 0.85); padding: 30px; border-radius: 12px; width: 350px; text-align: center; }
        input { width: 90%; padding: 10px; margin: 10px 0; border: 1px solid #ccc; border-radius: 5px; }
        button { width: 100%; padding: 10px; background: #222; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #444; }
        .error { color: red; font-size: 12px; display: none; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="card">
    <h2>Daftar</h2>
    <div id="errorMsg" class="error"></div>
    <form id="regForm">
        <input type="text" id="nama" placeholder="Nama Lengkap" required>
        <input type="email" id="email" placeholder="Email" required>
        <input type="password" id="pass" placeholder="Password (Min 6 Karakter)" required>
        <button type="submit" id="btnReg">Daftar</button>
    </form>
    <p>Sudah punya akun? <a href="/login">Masuk</a></p>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, createUserWithEmailAndPassword, updateProfile } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // --- GANTI DENGAN CONFIG ANDA ---
    const firebaseConfig = {
        apiKey: "AIzaSyCc1j2rkEI6M8mlFgDpiY77GIu3VyOm4T8",
        authDomain: "bookingin-eb994.firebaseapp.com",
        projectId: "bookingin-eb994",
        storageBucket: "bookingin-eb994.firebasestorage.app",
        messagingSenderId: "969038093060",
        appId: "1:969038093060:web:0bf3103bce1d8373930e51",
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);
    
    // Setup CSRF Token
    axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    document.getElementById('regForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('btnReg');
        const err = document.getElementById('errorMsg');
        
        btn.disabled = true; btn.innerText = "Memproses...";
        err.style.display = 'none';

        try {
            // 1. Daftar ke Firebase
            const userCred = await createUserWithEmailAndPassword(auth, document.getElementById('email').value, document.getElementById('pass').value);
            await updateProfile(userCred.user, { displayName: document.getElementById('nama').value });
            const token = await userCred.user.getIdToken();

            // 2. Kirim ke Laravel
            const response = await axios.post('/register-firebase', {
                token: token,
                name: document.getElementById('nama').value
            });

            // 3. Redirect ke Beranda
            if(response.data.status === 'success') {
                window.location.href = response.data.redirect; 
            }

        } catch (error) {
            console.error(error);
            err.innerText = "Gagal Mendaftar: " + (error.code || "Cek koneksi/server");
            err.style.display = 'block';
            btn.disabled = false; btn.innerText = "Daftar";
        }
    });
</script>
</body>
</html>