<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berhasil - Bookingin</title>
    <style>
        body { background: #000; color: white; font-family: Arial, sans-serif; display: flex; justify-content: center; align-items: center; height: 100vh; text-align: center; }
        .box { background: #1b1b1b; padding: 40px; border-radius: 15px; border: 1px solid #333; max-width: 400px; }
        .icon { font-size: 60px; color: #22c55e; margin-bottom: 20px; }
        .btn { background: #3b82f6; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; margin-top: 20px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="box">
        <div class="icon">✔</div>
        <h1>Pembayaran Berhasil!</h1>
        <p>Tiket elektronik telah dikirim ke email Anda.</p>
        <a href="{{ route('home') }}" class="btn">Kembali ke Beranda</a>
    </div>
</body>
</html>