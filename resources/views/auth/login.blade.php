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
        
        /* Overlay untuk efek blur pada background */
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
            background: rgba(255, 255, 255, 0.7); /* Lebih transparan dari sebelumnya (dari 0.95 ke 0.7) */
            width: 360px;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            backdrop-filter: blur(10px); /* Efek blur tambahan pada card */
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
        
        input:focus {
            outline: none;
            border-color: #222;
            box-shadow: 0 0 5px rgba(34, 34, 34, 0.3);
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
        
        .link {
            text-align: center;
            margin-top: 15px;
        }
        
        .link a {
            text-decoration: none;
            color: #222;
            font-weight: bold;
        }
        
        .link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Login</h2>

    <form method="POST" action="/login"> <!-- Mengubah action ke endpoint login yang lebih realistis -->
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Masuk</button>

        <div class="link">
            Belum punya akun? <a href="/register">Daftar</a>
        </div>
    </form>
</div>

</body>
</html>
