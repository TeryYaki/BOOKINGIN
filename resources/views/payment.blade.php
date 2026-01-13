<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran - Bookingin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Arial', sans-serif; background: #000; color: white; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .container { display: flex; gap: 30px; max-width: 900px; width: 100%; padding: 20px; flex-wrap: wrap; justify-content: center; }
        .card { background: #1b1b1b; border-radius: 15px; padding: 25px; width: 350px; border: 1px solid #333; box-shadow: 0 10px 30px rgba(0,0,0,0.5); }
        .poster { width: 80px; height: 120px; object-fit: cover; border-radius: 8px; float: left; margin-right: 15px; }
        .row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; clear: both; }
        .label { color: #888; }
        .value { font-weight: bold; }
        .total { border-top: 1px solid #444; margin-top: 15px; padding-top: 15px; color: #3b82f6; font-size: 20px; text-align: right; font-weight: bold; }
        
        /* QRIS Box */
        .qris-box { background: white; color: black; text-align: center; border-radius: 15px; padding: 20px; position: relative; }
        .qris-img { width: 200px; height: 200px; margin: 10px auto; display: block; }
        .btn-pay { display: block; width: 100%; padding: 15px; background: #22c55e; color: white; text-align: center; text-decoration: none; border-radius: 8px; font-weight: bold; margin-top: 20px; transition: 0.3s; }
        .btn-pay:hover { background: #16a34a; }
        .scan-line { width: 100%; height: 2px; background: red; position: absolute; top: 100px; left: 0; animation: scan 2s infinite; opacity: 0.5; }
        @keyframes scan { 0% { top: 80px; opacity: 0; } 50% { opacity: 1; } 100% { top: 280px; opacity: 0; } }
    </style>
</head>
<body>
<div class="container">
    <div class="card">
        <div style="margin-bottom: 20px; overflow: hidden;">
            <img src="{{ asset($booking['poster']) }}" class="poster">
            <h3 style="margin:0; color:#3b82f6;">{{ $booking['movie_title'] }}</h3>
            <p style="color:#aaa; font-size:12px; margin-top:5px;">{{ $booking['time'] }} WIB | Studio 1</p>
        </div>
        <div class="row"><span class="label">Order ID</span><span class="value">{{ $booking['order_id'] }}</span></div>
        <div class="row"><span class="label">Kursi</span><span class="value">{{ implode(', ', $booking['seats']) }}</span></div>
        <div class="row total">Rp {{ number_format($booking['total_price'], 0, ',', '.') }}</div>
    </div>

    <div class="card qris-box">
        <h3 style="margin-top:0;">Scan QRIS</h3>
        <p style="font-size:12px; color:#555;">Mandiri / BCA / GoPay / OVO</p>
        
        <div style="position:relative; overflow:hidden; display:inline-block;">
            <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=Bayar-{{ $booking['order_id'] }}" class="qris-img">
            <div class="scan-line"></div>
        </div>
        
        <a href="{{ route('payment.success') }}" class="btn-pay">
            <i class="fa-solid fa-check-circle"></i> Saya Sudah Bayar
        </a>
    </div>
</div>
</body>
</html>