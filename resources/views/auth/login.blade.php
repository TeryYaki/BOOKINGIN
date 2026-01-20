<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bookingin</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --brand-blue: #3b82f6;
            --brand-blue-hover: #2563eb;
            --glass-bg: rgba(20, 20, 20, 0.75);
            --glass-border: rgba(255, 255, 255, 0.1);
            --text-color: #ffffff;
            --text-muted: #a3a3a3;
        }

        body {
            font-family: 'Roboto', sans-serif;
            margin: 0; padding: 0; height: 100vh;
            display: flex; align-items: center; justify-content: center;
            background: url('images/the-premiere-1.jpg') no-repeat center center fixed;
            background-size: cover; 
            position: relative;
            color: var(--text-color);
        }

        /* Overlay Gelap di Background */
        body::before {
            content: ''; position: absolute; inset: 0;
            background: radial-gradient(circle at center, rgba(0,0,0,0.6) 0%, rgba(0,0,0,0.9) 100%);
            backdrop-filter: blur(5px);
            z-index: -1;
        }

        .login-card {
            background: var(--glass-bg);
            width: 100%; max-width: 400px;
            padding: 40px; 
            border-radius: 20px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(15px);
            border: 1px solid var(--glass-border);
            text-align: center;
            animation: fadeIn 0.8s ease-out;
        }

        .logo {
            font-family: 'Montserrat', sans-serif;
            font-size: 2rem;
            font-weight: 800;
            margin-bottom: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #60a5fa 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
            display: inline-block;
        }

        .subtitle {
            color: var(--text-muted);
            font-size: 0.95rem;
            margin-bottom: 30px;
        }

        /* Input Styles */
        .input-group {
            position: relative;
            margin-bottom: 20px;
            text-align: left;
        }

        .input-group i {
            position: absolute;
            top: 50%;
            left: 15px;
            transform: translateY(-50%);
            color: var(--text-muted);
            transition: 0.3s;
        }

        input {
            width: 100%;
            padding: 14px 14px 14px 45px; /* Padding kiri buat icon */
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--glass-border);
            border-radius: 12px;
            color: white;
            font-size: 1rem;
            outline: none;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        input:focus {
            background: rgba(255, 255, 255, 0.1);
            border-color: var(--brand-blue);
            box-shadow: 0 0 15px rgba(59, 130, 246, 0.2);
        }
        
        input:focus + i { color: var(--brand-blue); }

        /* Button Styles */
        button {
            width: 100%;
            padding: 14px;
            margin-top: 10px;
            background: linear-gradient(135deg, var(--brand-blue), var(--brand-blue-hover));
            color: white;
            border: none;
            border-radius: 12px;
            font-weight: 700;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }

        button:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(59, 130, 246, 0.5);
        }

        button:disabled {
            background: #555;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
            color: #aaa;
        }

        /* Error & Links */
        .error {
            background: rgba(239, 68, 68, 0.15);
            border: 1px solid rgba(239, 68, 68, 0.3);
            color: #fca5a5;
            padding: 10px;
            border-radius: 8px;
            font-size: 0.85rem;
            margin-bottom: 20px;
            display: none;
            text-align: left;
            display: flex; align-items: center; gap: 8px;
        }

        .link {
            margin-top: 25px;
            font-size: 0.9rem;
            color: var(--text-muted);
        }

        .link a {
            color: var(--brand-blue);
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
        }

        .link a:hover {
            color: #60a5fa;
            text-decoration: underline;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

<div class="login-card">
    <div class="logo">BOOKINGIN</div>
    <p class="subtitle">Silakan masuk untuk melanjutkan</p>
    
    <div id="errorMessage" class="error" style="display: none;">
        <i class="fa-solid fa-circle-exclamation"></i> <span></span>
    </div>

    <form id="loginForm">
        <div class="input-group">
            <input type="email" id="email" placeholder="Email Address" required>
            <i class="fa-solid fa-envelope"></i>
        </div>

        <div class="input-group">
            <input type="password" id="password" placeholder="Password" required>
            <i class="fa-solid fa-lock"></i>
        </div>
        
        <button type="submit" id="loginBtn">Masuk Sekarang</button>
        
        <div class="link">
            Belum punya akun? <a href="/register">Daftar disini</a>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script type="module">
    // Import Firebase
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // CONFIG FIREBASE
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
        e.preventDefault(); 

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const btn = document.getElementById('loginBtn');
        const err = document.getElementById('errorMessage');
        const errText = err.querySelector('span'); // Untuk teks di dalam div error

        // Reset tampilan saat loading
        err.style.display = 'none';
        btn.disabled = true;
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...'; // Tambah loading icon

        // 1. Coba Login ke Firebase
        signInWithEmailAndPassword(auth, email, password)
            .then((userCredential) => {
                return userCredential.user.getIdToken();
            })
            .then((token) => {
                // 2. Kirim Token ke Laravel
                return axios.post('/login-firebase', {
                    token: token
                });
            })
            .then((response) => {
                if (response.data.status === 'success') {
                    window.location.href = response.data.redirect;
                }
            })
            .catch((error) => {
                console.error(error);
                
                btn.disabled = false;
                btn.innerText = 'Masuk Sekarang';
                
                let pesan = "Login Gagal.";
                if (error.code === 'auth/invalid-credential') {
                    pesan = "Email atau Password salah.";
                } else if (error.code === 'auth/user-not-found') {
                    pesan = "Akun tidak ditemukan. Silakan daftar.";
                } else if (error.response) {
                    pesan = "Server Error: " + error.response.status;
                }
                
                if(errText) errText.innerText = pesan; // Masukkan teks error
                else err.innerText = pesan; // Fallback jika span tidak ada
                
                err.style.display = 'flex'; // Tampilkan kotak error
            });
    });
</script>

</body>
</html>