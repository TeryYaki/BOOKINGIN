<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Bookingin</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url('images/the-premiere-1.jpg') no-repeat center center fixed;
            background-size: cover;
            position: relative;
        }
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(8px);
            z-index: -1;
        }
        .card {
            background: rgba(255, 255, 255, 0.7);
            width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px);
            position: relative;
            z-index: 1;
        }
        h2 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }
        input {
            width: 100%;
            padding: 12px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-size: 14px;
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
            transition: background 0.3s;
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
            margin-top: 10px;
            display: none;
            text-align: center;
        }
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
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getAuth, signInWithEmailAndPassword } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-auth.js";

    // --- PASTE KONFIGURASI FIREBASE ANDA DI SINI (SAMA DENGAN FILE REGISTER) ---
    const firebaseConfig = {
        apiKey: "API_KEY_ANDA",
        authDomain: "PROJECT_ID.firebaseapp.com",
        projectId: "PROJECT_ID",
        storageBucket: "PROJECT_ID.appspot.com",
        messagingSenderId: "SENDER_ID",
        appId: "APP_ID"
    };

    const app = initializeApp(firebaseConfig);
    const auth = getAuth(app);

    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const loginBtn = document.getElementById('loginBtn');
        const errorMsg = document.getElementById('errorMessage');

        // Reset UI
        errorMsg.style.display = 'none';
        loginBtn.disabled = true;
        loginBtn.innerText = 'Memproses...';

        // 1. Login ke Firebase
        signInWithEmailAndPassword(auth, email, password)
            .then((userCredential) => {
                // 2. Ambil Token
                return userCredential.user.getIdToken();
            })
            .then((token) => {
                // 3. Kirim Token ke Laravel (Route: /login-firebase)
                return axios.post('/login-firebase', {
                    token: token
                });
            })
            .then((response) => {
                if(response.data.status === 'success') {
                    // 4. Redirect sesuai arahan backend
                    window.location.href = response.data.redirect;
                }
            })
            .catch((error) => {
                console.error(error);
                let message = "Login Gagal.";
                
                if (error.code === 'auth/invalid-credential') {
                    message = "Email atau Password salah.";
                } else if (error.response) {
                    message = error.response.data.message || "Gagal verifikasi server.";
                }

                errorMsg.innerText = message;
                errorMsg.style.display = 'block';
                loginBtn.disabled = false;
                loginBtn.innerText = 'Masuk';
            });
    });
</script>

</body>
</html>