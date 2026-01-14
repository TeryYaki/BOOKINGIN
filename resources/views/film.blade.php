<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} – Bookingin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #000;
            color: white;
            overflow-x: hidden;
        }

        /* --- NAVBAR --- */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.9);
            padding: 1rem 2rem;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.5);
            box-sizing: border-box;
        }
        .navbar .logo { font-size: 1.5rem; font-weight: bold; color: white; letter-spacing: 2px; }
        .navbar nav { display: flex; align-items: center; gap: 1.5rem; }
        .navbar a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; }
        .navbar a:hover { color: #3b82f6; }

        /* User Menu */
        .user-menu { display: flex; align-items: center; gap: 15px; padding-left: 15px; border-left: 1px solid #333; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; border: 2px solid #3b82f6; }
        .btn-logout { background: #ef4444; color: white; border: none; padding: 6px 15px; border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; }
        .btn-logout:hover { background: #dc2626; }
        .btn-login { background: #3b82f6; padding: 8px 20px; border-radius: 5px; color: white !important; font-weight: bold; }

        /* --- HERO SECTION --- */
        .hero { position: relative; height: 80vh; background-size: cover; background-position: center top; display: flex; align-items: flex-end; padding-bottom: 60px; }
        .hero::before { content: ""; position: absolute; inset: 0; background: linear-gradient(to top, #000 10%, rgba(0,0,0,0.85) 50%, rgba(0,0,0,0.6) 100%); }

        .hero-content { position: relative; z-index: 10; width: 100%; max-width: 1100px; margin: 0 auto; display: flex; gap: 40px; align-items: flex-end; padding: 0 20px; }

        .poster-card { width: 220px; height: 330px; border-radius: 10px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5); border: 3px solid white; flex-shrink: 0; background: #000; }
        .poster-card img { width: 100%; height: 100%; object-fit: fill; }

        .movie-info { flex: 1; }
        .movie-info h1 { font-size: 48px; font-weight: bold; margin: 0 0 15px 0; text-shadow: 2px 2px 10px black; line-height: 1.1; }
        .meta-tags { display: flex; gap: 10px; margin-bottom: 20px; color: #ddd; font-size: 14px; }
        .tag { background: rgba(255,255,255,0.2); padding: 5px 12px; border-radius: 4px; backdrop-filter: blur(5px); }
        .synopsis { font-size: 16px; line-height: 1.6; color: #ccc; max-width: 700px; }

        /* --- JADWAL --- */
        .schedule-section { background: #000; padding: 40px 20px; }
        .schedule-box { max-width: 900px; margin: 0 auto; background: #1b1b1b; border: 1px solid #333; border-radius: 12px; padding: 30px; }
        .section-title { font-size: 20px; font-weight: bold; border-bottom: 1px solid #333; padding-bottom: 15px; margin-bottom: 20px; color: #3b82f6; }
        
        /* Dropdown Kota Style */
        .city-select { width: 100%; max-width: 400px; padding: 12px; background: #333; color: white; border: 1px solid #555; border-radius: 6px; font-size: 16px; margin-bottom: 20px; cursor: pointer; }
        .city-select:focus { outline: none; border-color: #3b82f6; }

        .time-btn { padding: 10px 25px; background: transparent; border: 1px solid #555; color: white; border-radius: 6px; cursor: pointer; font-weight: bold; transition: 0.3s; margin-right: 10px; margin-bottom: 10px; }
        .time-btn:hover { background: #3b82f6; border-color: #3b82f6; transform: translateY(-2px); }

        /* --- MODAL KURSI --- */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); justify-content: center; align-items: center; }
        .modal-content { background: #1a1a1a; padding: 30px; border-radius: 12px; width: 90%; max-width: 500px; border: 1px solid #333; text-align: center; }
        .screen { background: linear-gradient(to bottom, #3b82f6, transparent); height: 40px; width: 80%; margin: 0 auto 30px; border-radius: 50% 50% 0 0 / 20px 20px 0 0; opacity: 0.6; font-size: 10px; display: flex; align-items: center; justify-content: center; letter-spacing: 3px; }
        .seats-grid { display: grid; grid-template-columns: repeat(8, 1fr); gap: 8px; justify-content: center; margin-bottom: 20px; }
        .seat { height: 30px; background: #333; border-radius: 4px; cursor: pointer; border-top: 2px solid #555; transition: 0.2s; display: flex; align-items: center; justify-content: center; font-size: 10px; }
        .seat:hover { background: #555; }
        .seat.selected { background: #3b82f6; border-color: #60a5fa; }
        .seat.occupied { background: #ef4444; border-color: #991b1b; opacity: 0.3; cursor: not-allowed; }
        
        .confirm-btn { width: 100%; padding: 12px; background: #3b82f6; color: white; border: none; border-radius: 6px; font-weight: bold; cursor: pointer; margin-top: 20px; }
        .confirm-btn:hover { background: #2563eb; }
        .close { float: right; font-size: 24px; cursor: pointer; margin-top: -10px; }

        @media (max-width: 768px) {
            .hero { height: auto; padding-top: 100px; padding-bottom: 40px; display: block; }
            .hero-content { flex-direction: column; align-items: center; text-align: center; }
            .poster-card { margin-bottom: 20px; width: 160px; height: 240px; }
            .movie-info h1 { font-size: 32px; }
            .meta-tags { justify-content: center; }
            .navbar nav { gap: 10px; }
            .user-menu { border-left: none; padding-left: 0; }
            .user-name { display: none; }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">BOOKINGIN</div>
        <nav>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('movies') }}">Movies</a>

            @guest
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            @endguest

            @auth
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff" class="user-avatar" alt="Avatar">
                    <a href="{{ route('profile') }}" class="user-name" style="color: white; text-decoration: none;">
                        {{ Auth::user()->name }}
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-logout">Keluar</button>
                    </form>
                </div>
            @endauth
        </nav>
    </header>

    <div class="hero" style="background-image: url('{{ asset($movie->poster_path) }}');">
        <div class="hero-content">
            <div class="poster-card">
                <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}">
            </div>

            <div class="movie-info">
                <h1>{{ $movie->title }}</h1>
                <div class="meta-tags">
                    <span class="tag">2D</span>
                    <span class="tag" style="{{ $movie->status == 'upcoming' ? 'background: #eab308; color: black;' : 'background: #22c55e; color: white;' }}">
                        {{ $movie->status == 'now_showing' ? 'SEDANG TAYANG' : 'SEGERA TAYANG' }}
                    </span>
                    <span class="tag"><i class="fa-regular fa-clock"></i> 120 Menit</span>
                </div>
                <div class="synopsis">
                    {{ $movie->description ?? 'Sinopsis belum tersedia untuk film ini. Silakan tonton trailernya atau cek info lebih lanjut nanti.' }}
                </div>
            </div>
        </div>
    </div>

    <div class="schedule-section">
        <div class="schedule-box">
            <div class="section-title">Jadwal Tayang (Regular 2D) - Rp 45.000</div>
            
            @if($movie->status == 'now_showing')
                <div style="margin-bottom: 20px;">
                    <label style="color:#aaa; display:block; margin-bottom:10px; font-weight:bold;">Pilih Lokasi Bioskop:</label>
                    <select id="regionSelect" class="city-select">
                        <option value="Jakarta">Jakarta - Grand Indonesia</option>
                        <option value="Bandung">Bandung - Trans Studio</option>
                        <option value="Surabaya">Surabaya - Tunjungan Plaza</option>
                        <option value="Yogyakarta">Yogyakarta - Ambarrukmo</option>
                        <option value="Medan">Medan - Centre Point</option>
                    </select>
                </div>

                <div>
                    <label style="color:#aaa; display:block; margin-bottom:10px; font-weight:bold;">Pilih Jam Tayang:</label>
                    <button class="time-btn" onclick="openModal('13:00')">13:00</button>
                    <button class="time-btn" onclick="openModal('15:30')">15:30</button>
                    <button class="time-btn" onclick="openModal('18:00')">18:00</button>
                    <button class="time-btn" onclick="openModal('20:30')">20:30</button>
                </div>
            @else
                <p style="color: #888; font-style: italic; padding: 20px; text-align: center;">
                    <i class="fa-solid fa-calendar-xmark" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                    Maaf, tiket belum tersedia. Film ini akan segera tayang.
                </p>
            @endif
        </div>
    </div>

   <div id="seatModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 style="margin-top:0">Pilih Kursi <span id="timeDisplay" style="color:#3b82f6"></span></h3>
            
            <div class="screen">LAYAR BIOSKOP</div>
            
            <div class="seats-grid" id="seatsContainer">
                </div>

            <div style="display:flex; justify-content:center; gap:15px; font-size:12px; color:#888; margin-top:15px;">
                <span style="display:flex; align-items:center; gap:5px;"><div style="width:12px; height:12px; background:#333;"></div> Kosong</span>
                <span style="display:flex; align-items:center; gap:5px;"><div style="width:12px; height:12px; background:#3b82f6;"></div> Dipilih</span>
                <span style="display:flex; align-items:center; gap:5px;"><div style="width:12px; height:12px; background:#ef4444;"></div> Terisi</span>
            </div>

            <button class="confirm-btn" onclick="confirmBooking()">Lanjut ke Pembayaran</button>
        </div>
    </div>

    <form id="bookingForm" action="{{ route('booking.process') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        <input type="hidden" name="seats" id="seatsInput">
        <input type="hidden" name="time" id="timeInput">
        <input type="hidden" name="region" id="regionInput"> </form>

    <script>
        const modal = document.getElementById('seatModal');
        const container = document.getElementById('seatsContainer');
        let selectedSeats = [];
        let selectedTime = "";

        // Buka Modal
        function openModal(time) {
            selectedTime = time;
            document.getElementById('timeDisplay').innerText = time;
            container.innerHTML = ''; 
            selectedSeats = [];
            
            // Generate 40 Kursi
            for (let i = 1; i <= 40; i++) {
                let seat = document.createElement('div');
                seat.classList.add('seat');
                seat.innerText = i;
                
                // Simulasi kursi terisi
                if (Math.random() < 0.2) seat.classList.add('occupied');
                
                seat.onclick = function() {
                    if (seat.classList.contains('occupied')) return;
                    seat.classList.toggle('selected');
                    
                    if (seat.classList.contains('selected')) {
                        selectedSeats.push(i);
                    } else {
                        selectedSeats = selectedSeats.filter(s => s !== i);
                    }
                };
                container.appendChild(seat);
            }
            modal.style.display = 'flex';
        }

        function closeModal() {
            modal.style.display = 'none';
        }

        // FUNGSI UTAMA: Kirim data ke Form -> Submit
        function confirmBooking() {
            if (selectedSeats.length === 0) {
                alert("Silakan pilih minimal 1 kursi!");
                return;
            }

            // Ambil data Region dari Dropdown UI
            const region = document.getElementById('regionSelect').value;

            // Isi input tersembunyi
            document.getElementById('seatsInput').value = selectedSeats.join(',');
            document.getElementById('timeInput').value = selectedTime;
            document.getElementById('regionInput').value = region; // Masukkan ke form hidden
            
            // Kirim form
            document.getElementById('bookingForm').submit();
        }

        window.onclick = function(event) {
            if (event.target == modal) closeModal();
        }
    </script>
</body>
</html>