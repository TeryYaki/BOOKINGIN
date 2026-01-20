<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} – Bookingin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        /* --- STYLE SAMA SEPERTI SEBELUMNYA (Dipersingkat agar fokus ke perubahan) --- */
        :root { --primary-bg: #0a0a0a; --secondary-bg: #161616; --card-bg: #1f1f1f; --text-main: #ffffff; --text-muted: #a1a1a1; --brand-blue: #3b82f6; --brand-blue-dark: #2563eb; --brand-red: #ef4444; --gradient-main: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); --glass: rgba(22, 22, 22, 0.8); --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); }
        body { margin: 0; font-family: 'Roboto', sans-serif; background: var(--primary-bg); color: var(--text-main); overflow-x: hidden; }
        
        /* Navbar */
        header.navbar { display: flex; justify-content: space-between; align-items: center; background: rgba(10, 10, 10, 0.85); backdrop-filter: blur(12px); padding: 1rem 5%; position: fixed; top: 0; width: 100%; z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.05); box-sizing: border-box; }
        .navbar .logo { font-family: 'Montserrat', sans-serif; font-size: 1.8rem; font-weight: 800; background: var(--gradient-main); -webkit-background-clip: text; -webkit-text-fill-color: transparent; letter-spacing: 1px; }
        .navbar nav { display: flex; align-items: center; gap: 20px; }
        .nav-link { color: var(--text-muted); text-decoration: none; font-weight: 500; transition: var(--transition); }
        .nav-link:hover { color: var(--text-main); }
        .user-menu { display: flex; align-items: center; gap: 15px; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 20px; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; border: 2px solid var(--brand-blue); }
        .user-name { font-weight: 600; font-size: 0.95rem; color: white; text-decoration: none; }
        .btn-logout { background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 6px 14px; border-radius: 6px; cursor: pointer; transition: var(--transition); }
        .btn-logout:hover { border-color: var(--brand-red); color: var(--brand-red); }
        .btn-login { background: var(--brand-blue); padding: 8px 20px; border-radius: 50px; color: white !important; font-weight: 600; text-decoration: none; }

        /* Hero */
        .hero { position: relative; min-height: 85vh; background-size: cover; background-position: center top; display: flex; align-items: flex-end; padding-bottom: 80px; }
        .hero::before { content: ""; position: absolute; inset: 0; background: linear-gradient(to top, var(--primary-bg) 5%, rgba(10,10,10,0.9) 40%, rgba(10,10,10,0.4) 100%); }
        .hero-content { position: relative; z-index: 10; width: 100%; max-width: 1200px; margin: 0 auto; display: flex; gap: 50px; align-items: flex-end; padding: 0 2rem; }
        .poster-card { width: 260px; height: 390px; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.1); flex-shrink: 0; background: #000; position: relative; top: 40px; }
        .poster-card img { width: 100%; height: 100%; object-fit: cover; }
        .movie-info { flex: 1; padding-bottom: 20px; }
        .movie-info h1 { font-family: 'Montserrat', sans-serif; font-size: 3.5rem; font-weight: 800; margin: 0 0 20px 0; text-shadow: 0 10px 30px rgba(0,0,0,0.8); line-height: 1.1; }
        .meta-tags { display: flex; gap: 12px; margin-bottom: 25px; align-items: center; }
        .tag { background: rgba(255,255,255,0.1); padding: 6px 16px; border-radius: 50px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); font-size: 0.85rem; font-weight: 500; }
        .tag-status { font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
        .synopsis { font-size: 1.1rem; line-height: 1.8; color: #d1d1d1; max-width: 800px; margin-bottom: 30px; text-shadow: 0 2px 4px rgba(0,0,0,0.8); }

        /* Schedule Section */
        .schedule-section { background: var(--primary-bg); padding: 60px 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .schedule-box { max-width: 900px; margin: 0 auto; background: var(--secondary-bg); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
        .section-header { margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .section-title { font-size: 1.5rem; font-weight: 700; font-family: 'Montserrat', sans-serif; color: white; }
        .price-tag { color: var(--brand-blue); font-weight: 700; font-size: 1.2rem; }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; color: var(--text-muted); margin-bottom: 10px; font-size: 0.9rem; }
        .city-select { width: 100%; padding: 15px; background: var(--card-bg); color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; font-size: 1rem; cursor: pointer; appearance: none; transition: var(--transition); background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23007CB2%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E"); background-repeat: no-repeat; background-position: right 15px top 50%; background-size: 12px auto; }
        .city-select:focus { border-color: var(--brand-blue); outline: none; box-shadow: 0 0 0 3px rgba(59,130,246,0.2); }

        /* Date & Time Buttons */
        .selection-grid { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 10px; scrollbar-width: none; }
        .selection-grid::-webkit-scrollbar { display: none; }
        
        .select-btn { 
            padding: 12px 20px; background: transparent; border: 1px solid rgba(255,255,255,0.2); 
            color: white; border-radius: 10px; cursor: pointer; font-weight: 600; white-space: nowrap; transition: var(--transition);
            min-width: 80px; text-align: center;
        }
        .select-btn:hover, .select-btn.active { 
            background: var(--brand-blue); border-color: var(--brand-blue); 
            transform: translateY(-2px); box-shadow: 0 5px 15px rgba(59,130,246,0.3); 
        }
        
        /* Modal & Seats */
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px); justify-content: center; align-items: center; animation: fadeIn 0.3s; }
        .modal-content { background: #1a1a1a; padding: 40px; border-radius: 20px; width: 90%; max-width: 600px; border: 1px solid rgba(255,255,255,0.1); text-align: center; position: relative; box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7); }
        .close { position: absolute; top: 20px; right: 25px; font-size: 28px; cursor: pointer; color: var(--text-muted); transition: 0.2s; }
        .close:hover { color: white; }
        .screen-container { perspective: 500px; margin-bottom: 40px; margin-top: 20px; }
        .screen { background: linear-gradient(to bottom, #fff, rgba(255,255,255,0)); height: 60px; width: 80%; margin: 0 auto; transform: rotateX(-10deg); box-shadow: 0 25px 25px rgba(255,255,255,0.1); opacity: 0.8; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; letter-spacing: 5px; color: rgba(0,0,0,0.5); font-weight: bold; }
        .seats-grid { display: grid; grid-template-columns: repeat(8, 1fr); gap: 10px; justify-content: center; margin-bottom: 30px; max-width: 400px; margin-left: auto; margin-right: auto; }
        .seat { height: 35px; background: #333; border-radius: 8px 8px 4px 4px; cursor: pointer; position: relative; transition: 0.2s; border-bottom: 4px solid #222; display: flex; align-items: center; justify-content: center; font-size: 10px; color: rgba(255,255,255,0.3); }
        .seat:hover:not(.occupied) { background: #555; transform: scale(1.1); }
        .seat.selected { background: var(--brand-blue); border-bottom-color: var(--brand-blue-dark); color: white; box-shadow: 0 0 10px rgba(59,130,246,0.5); }
        .seat.occupied { background: #3f1818; border-bottom-color: #280d0d; cursor: not-allowed; }
        .seat.occupied::after { content: "X"; color: #ef4444; font-size: 14px; font-weight: bold; }
        .legend { display: flex; justify-content: center; gap: 20px; margin-bottom: 30px; }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 0.9rem; color: var(--text-muted); }
        .dot { width: 12px; height: 12px; border-radius: 4px; }
        .confirm-btn { width: 100%; padding: 15px; background: var(--gradient-main); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: 0.3s; box-shadow: 0 10px 25px rgba(59,130,246,0.3); }
        .confirm-btn:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(59,130,246,0.5); }
        @keyframes fadeIn { from { opacity: 0; transform: scale(0.95); } to { opacity: 1; transform: scale(1); } }
        @media (max-width: 768px) { .hero { display: block; padding-top: 100px; height: auto; } .hero-content { flex-direction: column; align-items: center; text-align: center; } .poster-card { width: 180px; height: 270px; top: 0; margin-bottom: 20px; } .movie-info h1 { font-size: 2.5rem; } .meta-tags { justify-content: center; flex-wrap: wrap; } .seats-grid { gap: 6px; } .seat { height: 28px; } }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">BOOKINGIN</div>
        <nav>
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="{{ route('movies') }}" class="nav-link" style="color:white">Movies</a>
            @guest <a href="{{ route('login') }}" class="btn-login">Masuk</a> @endguest
            @auth
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff" class="user-avatar" alt="Avatar">
                    <a href="{{ route('profile') }}" class="user-name">{{ Auth::user()->name }}</a>
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;"> @csrf <button type="submit" class="btn-logout" title="Logout"><i class="fa-solid fa-right-from-bracket"></i></button> </form>
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
                    <span class="tag">2D / Atmos</span>
                    <span class="tag tag-status" style="{{ $movie->status == 'upcoming' ? 'background: rgba(234, 179, 8, 0.2); color: #fbbf24; border-color: rgba(234, 179, 8, 0.3);' : 'background: rgba(34, 197, 94, 0.2); color: #4ade80; border-color: rgba(34, 197, 94, 0.3);' }}">
                        {{ $movie->status == 'now_showing' ? 'Now Showing' : 'Coming Soon' }}
                    </span>
                    <span class="tag"><i class="fa-regular fa-clock"></i> 120 Min</span>
                </div>
                <div class="synopsis">
                    {{ $movie->description ?? 'Sinopsis film belum tersedia. Silakan nikmati trailernya atau tunggu pembaruan informasi selanjutnya dari kami.' }}
                </div>
            </div>
        </div>
    </div>

    <div class="schedule-section">
        <div class="schedule-box">
            <div class="section-header">
                <div class="section-title">Jadwal Tayang</div>
                <div class="price-tag">IDR {{ number_format($movie->ticket_price, 0, ',', '.') }}</div>
            </div>
            
            @if($movie->status == 'now_showing')
                <div class="input-group">
                    <label>Pilih Bioskop</label>
                    <select id="regionSelect" class="city-select">
                        <option value="Jakarta">Jakarta - Grand Indonesia CGV</option>
                        <option value="Bandung">Bandung - Paris Van Java</option>
                        <option value="Surabaya">Surabaya - Tunjungan Plaza XXI</option>
                        <option value="Yogyakarta">Yogyakarta - Empire XXI</option>
                        <option value="Medan">Medan - Centre Point</option>
                    </select>
                </div>

                <div class="input-group">
                    <label>Pilih Tanggal</label>
                    <div class="selection-grid" id="dateContainer">
                        </div>
                </div>

                <div class="input-group">
                    <label>Pilih Waktu</label>
                    <div class="selection-grid">
                        <button class="select-btn time-btn" onclick="selectTime('13:00', this)">13:00 WIB</button>
                        <button class="select-btn time-btn" onclick="selectTime('15:30', this)">15:30 WIB</button>
                        <button class="select-btn time-btn" onclick="selectTime('18:00', this)">18:00 WIB</button>
                        <button class="select-btn time-btn" onclick="selectTime('20:30', this)">20:30 WIB</button>
                    </div>
                </div>

                <button class="confirm-btn" style="margin-top: 20px;" onclick="checkAndOpenModal()">Pilih Kursi</button>
            @else
                <div style="text-align: center; padding: 40px; color: var(--text-muted);">
                    <i class="fa-solid fa-film" style="font-size: 3rem; margin-bottom: 15px; display: block; opacity: 0.5;"></i>
                    <h3 style="margin-bottom: 10px; color: white;">Film Belum Tayang</h3>
                    <p>Tiket untuk film ini belum tersedia. Silakan cek kembali nanti.</p>
                </div>
            @endif
        </div>
    </div>

    <div id="seatModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3 style="margin-top:0; font-family:'Montserrat', sans-serif;">Pilih Kursi</h3>
            <p style="color:var(--text-muted); margin-bottom: 20px; font-size: 0.9rem;">
                <span id="dateDisplay"></span> • <span id="timeDisplay" style="color:var(--brand-blue); font-weight:bold;"></span>
            </p>
            <div class="screen-container"><div class="screen">SCREEN</div></div>
            <div class="seats-grid" id="seatsContainer"></div>
            <div class="legend">
                <div class="legend-item"><div class="dot" style="background:#333"></div> Kosong</div>
                <div class="legend-item"><div class="dot" style="background:var(--brand-blue)"></div> Dipilih</div>
                <div class="legend-item"><div class="dot" style="background:#3f1818"></div> Terisi</div>
            </div>
            <button class="confirm-btn" onclick="confirmBooking()">
                Konfirmasi & Bayar <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
            </button>
        </div>
    </div>

    <form id="bookingForm" action="{{ route('booking.process') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="movie_id" value="{{ $movie->id }}">
        <input type="hidden" name="seats" id="seatsInput">
        <input type="hidden" name="time" id="timeInput">
        <input type="hidden" name="date" id="dateInput"> <input type="hidden" name="region" id="regionInput"> 
    </form>

    <script>
        const modal = document.getElementById('seatModal');
        const container = document.getElementById('seatsContainer');
        const dateContainer = document.getElementById('dateContainer');
        
        let selectedSeats = [];
        let selectedTime = "";
        let selectedDate = "";

        // --- 1. GENERATE TANGGAL (Hari ini + 5 hari ke depan) ---
        const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
        const months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'];
        const today = new Date();

        for (let i = 0; i < 6; i++) {
            let d = new Date(today);
            d.setDate(today.getDate() + i);
            
            let dayName = i === 0 ? "Hari Ini" : (i === 1 ? "Besok" : days[d.getDay()]);
            let dateStr = `${d.getDate()} ${months[d.getMonth()]}`;
            let fullDate = d.toISOString().split('T')[0]; // Format YYYY-MM-DD

            let btn = document.createElement('button');
            btn.className = 'select-btn';
            if(i === 0) { // Auto select hari ini
                btn.classList.add('active');
                selectedDate = fullDate; 
            }
            
            btn.innerHTML = `<div style="font-size:0.8rem; opacity:0.7;">${dayName}</div><div style="font-size:1.1rem;">${d.getDate()}</div>`;
            
            btn.onclick = function() {
                // Reset class active
                document.querySelectorAll('#dateContainer .select-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                selectedDate = fullDate;
            };
            
            dateContainer.appendChild(btn);
        }

        // --- 2. PILIH WAKTU ---
        function selectTime(time, btn) {
            selectedTime = time;
            document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');
        }

        // --- 3. BUKA MODAL KURSI ---
        function checkAndOpenModal() {
            if (!selectedDate) { alert("Mohon pilih tanggal terlebih dahulu."); return; }
            if (!selectedTime) { alert("Mohon pilih waktu tayang terlebih dahulu."); return; }
            
            openModal();
        }

        function openModal() {
            document.getElementById('dateDisplay').innerText = selectedDate;
            document.getElementById('timeDisplay').innerText = selectedTime;
            
            container.innerHTML = ''; 
            selectedSeats = [];
            
            // Generate 40 Kursi
            for (let i = 1; i <= 40; i++) {
                let seat = document.createElement('div');
                seat.classList.add('seat');
                seat.innerText = i;
                
                // Simulasi kursi terisi (Random 15%)
                if (Math.random() < 0.15) seat.classList.add('occupied');
                
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

        // --- 4. SUBMIT FORM ---
        function confirmBooking() {
            if (selectedSeats.length === 0) {
                alert("Silakan pilih minimal 1 kursi!");
                return;
            }

            const region = document.getElementById('regionSelect').value;

            document.getElementById('seatsInput').value = selectedSeats.join(',');
            document.getElementById('timeInput').value = selectedTime;
            document.getElementById('dateInput').value = selectedDate; // Masukkan Tanggal
            document.getElementById('regionInput').value = region; 
            
            document.getElementById('bookingForm').submit();
        }

        window.onclick = function(event) {
            if (event.target == modal) closeModal();
        }
    </script>
</body>
</html>