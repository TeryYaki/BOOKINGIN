<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Ticket - Bookingin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body { margin: 0; font-family: 'Courier New', Courier, monospace; background: #222; display: flex; justify-content: center; align-items: center; min-height: 100vh; }
        .ticket-container { text-align: center; }
        .ticket { width: 320px; background: #fff; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); position: relative; }
        
        /* Header Tiket */
        .header { background: url('{{ asset($booking['poster']) }}') top/cover; height: 150px; position: relative; }
        .header::after { content:''; position: absolute; bottom:0; left:0; width:100%; height:50px; background: linear-gradient(to top, #fff, transparent); }
        
        .body { padding: 20px; color: #333; text-align: left; }
        .label { font-size: 10px; color: #888; text-transform: uppercase; margin-bottom: 2px; }
        .val { font-size: 14px; font-weight: bold; margin-bottom: 12px; display: block; }
        
        /* Garis Sobek */
        .rip { border-top: 2px dashed #bbb; margin: 10px -20px; position: relative; }
        .rip::before, .rip::after { content:''; width:20px; height:20px; background:#222; border-radius:50%; position:absolute; top:-12px; }
        .rip::before { left: -10px; } .rip::after { right: -10px; }

        .footer { text-align: center; padding-bottom: 20px; }
        .qr { width: 120px; height: 120px; margin: 0 auto; }
        
        .actions { margin-top: 20px; display: flex; gap: 10px; justify-content: center; }
        .btn { padding: 10px 20px; border-radius: 5px; text-decoration: none; font-weight: bold; font-family: Arial, sans-serif; font-size: 14px; color: white; border: none; cursor: pointer; transition: 0.2s; }
        .btn-home { background: #555; }
        .btn-home:hover { background: #777; }
        .btn-print { background: #3b82f6; }
        .btn-print:hover { background: #2563eb; }
    </style>
</head>
<body>
    <div class="ticket-container">
        <h2 style="color:white; font-family: Arial; margin-bottom: 20px;">Pembayaran Berhasil! <i class="fa-solid fa-circle-check" style="color:#22c55e;"></i></h2>
        
        <div class="ticket">
            <div class="header"></div>
            <div class="body">
                <h3 style="margin:0 0 15px 0; text-transform:uppercase; font-family: Arial;">{{ $booking['movie_title'] }}</h3>
                
                <div style="display: flex; justify-content: space-between;">
                    <div><span class="label">TANGGAL</span><span class="val">{{ date('d M Y') }}</span></div>
                    <div><span class="label">JAM</span><span class="val">{{ $booking['time'] }}</span></div>
                </div>

                <div style="display: flex; justify-content: space-between;">
                    <div><span class="label">KURSI</span><span class="val" style="font-size: 18px; color: #3b82f6;">{{ implode(',', $booking['seats']) }}</span></div>
                    <div><span class="label">STUDIO</span><span class="val">01</span></div>
                </div>

                <div class="rip"></div>

                <div class="footer">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ $booking['order_id'] }}" class="qr">
                    <p style="font-size:10px; margin-top:5px; font-family: Arial;">ID: {{ $booking['order_id'] }}</p>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="{{ route('home') }}" class="btn btn-home">Beranda</a>
            <button onclick="window.print()" class="btn btn-print"><i class="fa-solid fa-print"></i> Cetak Tiket</button>
        </div>
    </div>
</body>
</html>