<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar Akun - Bookingin</title>
    
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

        .register-card {
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
            padding: 12px;
            border-radius: 8px;
            font-size: 0.9rem;
            margin-bottom: 20px;
            display: none;
            text-align: left;
            align-items: center; gap: 10px;
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

<div class="register-card">
    <div class="logo">BOOKINGIN</div>
    <p class="subtitle">Buat akun baru untuk mulai memesan</p>
    
    <div id="errorMsg" class="error">
        <i class="fa-solid fa-triangle-exclamation"></i> <span></span>
    </div>

    <form id="regForm">
        <div class="input-group">
            <input type="text" id="nama" placeholder="Nama Lengkap" required>
            <i class="fa-solid fa-user"></i>
        </div>

        <div class="input-group">
            <input type="email" id="email" placeholder="Alamat Email" required>
            <i class="fa-solid fa-envelope"></i>
        </div>

        <div class="input-group">
            <input type="password" id="pass" placeholder="Password (Min 6 Karakter)" required>
            <i class="fa-solid fa-lock"></i>
        </div>

        <button type="submit" id="btnReg">Daftar Sekarang</button>
    </form>
    
    <div class="link">
        Sudah punya akun? <a href="/login">Masuk disini</a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script type="module">
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, createUserWithEmailAndPassword, updateProfile } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // --- CONFIG FIREBASE ANDA ---
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]');
    if(csrfToken) {
        axios.defaults.headers.common['X-CSRF-TOKEN'] = csrfToken.getAttribute('content');
    }

    document.getElementById('regForm').addEventListener('submit', async (e) => {
        e.preventDefault();
        const btn = document.getElementById('btnReg');
        const err = document.getElementById('errorMsg');
        const errText = err.querySelector('span') || err; // Fallback jika span tidak ditemukan
        
        btn.disabled = true; 
        btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Memproses...';
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
            
            // Format Pesan Error yang lebih rapi
            let msg = "Gagal Mendaftar.";
            if(error.code === 'auth/email-already-in-use') msg = "Email sudah terdaftar.";
            else if(error.code === 'auth/weak-password') msg = "Password terlalu lemah (min 6 karakter).";
            else if(error.code) msg = "Error: " + error.code;

            if(err.querySelector('span')) err.querySelector('span').innerText = msg;
            else err.innerText = msg;

            err.style.display = 'flex'; // Gunakan flex agar icon sejajar
            btn.disabled = false; 
            btn.innerText = "Daftar Sekarang";
        }
    });
</script>
</body>
</html>