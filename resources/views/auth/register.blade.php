<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Bookingin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('images/the-premiere-1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: inherit;
            background-size: inherit;
            background-position: inherit;
            background-repeat: inherit;
            filter: blur(8px);
            z-index: -1;
        }
        .card {
            background: rgba(255, 255, 255, 0.7);
            width: 100%;
            max-width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            position: relative;
            z-index: 1;
            backdrop-filter: blur(5px);
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
        }
        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 12px;
            margin-top: 20px;
            background: #222;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }
        button:hover {
            background: #444;
        }
        button:disabled {
            background: #777;
            cursor: not-allowed;
        }
        .link {
            text-align: center;
            margin-top: 15px;
        }
        .link a {
            text-decoration: none;
            color: #222;
            font-weight: bold;
        }
        .error {
            color: red;
            font-size: 12px;
            margin-top: 5px;
            display: none;
            text-align: center;
        }
        #generalError {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Daftar Akun</h2>

    <div id="generalError" class="error"></div>

    <form id="registerForm">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" id="nama" name="nama" placeholder="Nama Lengkap" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Password (Min. 6 Karakter)" required autocomplete="new-password">
        </div>
        <div class="form-group">
            <label for="confirmPassword">Konfirmasi Password</label>
            <input type="password" id="confirmPassword" name="confirmPassword" placeholder="Konfirmasi Password" required autocomplete="new-password">
            <div id="passwordError" class="error">Password tidak cocok.</div>
        </div>

        <button type="submit" id="submitBtn">Daftar</button>

        <div class="link">
            Sudah punya akun? <a href="/login">Masuk</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="module">
    // Import Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, createUserWithEmailAndPassword, updateProfile } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // --- PASTE KONFIGURASI FIREBASE ANDA DI SINI ---
    const firebaseConfig = {
        apiKey: "API_KEY_ANDA",
        authDomain: "PROJECT_ID.firebaseapp.com",
        projectId: "PROJECT_ID",
        storageBucket: "PROJECT_ID.appspot.com",
        messagingSenderId: "SENDER_ID",
        appId: "APP_ID"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    const registerForm = document.getElementById('registerForm');
    const submitBtn = document.getElementById('submitBtn');
    const generalError = document.getElementById('generalError');
    const passwordError = document.getElementById('passwordError');

    registerForm.addEventListener('submit', function(event) {
        event.preventDefault(); // Mencegah reload halaman

        const nama = document.getElementById('nama').value;
        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;

        // Reset Error
        passwordError.style.display = 'none';
        generalError.style.display = 'none';

        // Validasi Password
        if (password !== confirmPassword) {
            passwordError.style.display = 'block';
            return;
        }

        if (password.length < 6) {
            generalError.innerText = "Password harus minimal 6 karakter.";
            generalError.style.display = 'block';
            return;
        }

        // Mulai Loading
        submitBtn.disabled = true;
        submitBtn.innerText = "Mendaftarkan...";

        // 1. Buat User di Firebase
        createUserWithEmailAndPassword(auth, email, password)
            .then((userCredential) => {
                const user = userCredential.user;
                
                // 2. Update Profile Firebase dengan Nama
                return updateProfile(user, {
                    displayName: nama
                }).then(() => {
                    return user.getIdToken();
                });
            })
            .then((token) => {
                // 3. Kirim Data ke Laravel Backend
                // Pastikan route '/register-firebase' sudah dibuat di routes/web.php
                return axios.post('/register-firebase', {
                    token: token,
                    name: nama // Kirim nama eksplisit untuk disimpan di DB Lokal
                });
            })
            .then((response) => {
                if (response.data.status === 'success') {
                    // 4. Redirect ke Dashboard/Home
                    window.location.href = '/dashboard'; 
                }
            })
            .catch((error) => {
                console.error("Error:", error);
                
                // Handling Error Firebase
                let errorMessage = "Terjadi kesalahan saat mendaftar.";
                if (error.code === 'auth/email-already-in-use') {
                    errorMessage = "Email sudah terdaftar.";
                } else if (error.code === 'auth/weak-password') {
                    errorMessage = "Password terlalu lemah.";
                } else if (error.response) {
                    // Error dari Laravel Backend
                    errorMessage = "Server Error: " + error.response.data.message;
                }

                generalError.innerText = errorMessage;
                generalError.style.display = 'block';
                submitBtn.disabled = false;
                submitBtn.innerText = "Daftar";
            });
    });
</script>

</body>
</html>