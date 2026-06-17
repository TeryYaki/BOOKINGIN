<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $movie->title }} – Bookingin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#0a0a0a',
                        secondary: '#161616',
                        card: '#1f1f1f',
                        brandBlue: '#3b82f6',
                        brandRed: '#ef4444',
                        textMuted: '#a1a1a1'
                    },
                    fontFamily: {
                        sans: ['Roboto', 'sans-serif'],
                        heading: ['Montserrat', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        :root { --primary-bg: #0a0a0a; --secondary-bg: #161616; --card-bg: #1f1f1f; --text-main: #ffffff; --text-muted: #a1a1a1; --brand-blue: #3b82f6; --brand-blue-dark: #2563eb; --brand-red: #ef4444; --gradient-main: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        body { margin: 0; font-family: 'Roboto', sans-serif; background: var(--primary-bg); color: var(--text-main); overflow-x: hidden; }
        
        .hero { position: relative; min-height: 85vh; background-size: cover; background-position: center top; display: flex; align-items: flex-end; padding-bottom: 80px; }
        .hero::before { content: ""; position: absolute; inset: 0; background: linear-gradient(to top, var(--primary-bg) 5%, rgba(10,10,10,0.9) 40%, rgba(10,10,10,0.4) 100%); }
        .hero-content { position: relative; z-index: 10; width: 100%; max-width: 1200px; margin: 0 auto; display: flex; gap: 50px; align-items: flex-end; padding: 0 2rem; }
        .poster-card { width: 260px; height: 390px; border-radius: 12px; overflow: hidden; box-shadow: 0 20px 50px rgba(0,0,0,0.6); border: 1px solid rgba(255,255,255,0.1); flex-shrink: 0; background: #000; position: relative; top: 40px; }
        .poster-card img { width: 100%; height: 100%; object-fit: cover; }
        .movie-info { flex: 1; padding-bottom: 20px; }
        .movie-info h1 { font-family: 'Montserrat', sans-serif; font-size: 3.5rem; font-weight: 800; margin: 0 0 20px 0; text-shadow: 0 10px 30px rgba(0,0,0,0.8); line-height: 1.1; }
        .meta-tags { display: flex; gap: 12px; margin-bottom: 25px; align-items: center; flex-wrap: wrap; }
        .tag { background: rgba(255,255,255,0.1); padding: 6px 16px; border-radius: 50px; backdrop-filter: blur(10px); border: 1px solid rgba(255,255,255,0.1); font-size: 0.85rem; font-weight: 500; }
        .tag-status { font-weight: 700; text-transform: uppercase; }
        .synopsis { font-size: 1.1rem; line-height: 1.8; color: #d1d1d1; max-width: 800px; margin-bottom: 30px; }

        .schedule-section { background: var(--primary-bg); padding: 60px 20px; border-top: 1px solid rgba(255,255,255,0.05); }
        .schedule-box { max-width: 900px; margin: 0 auto; background: var(--secondary-bg); border: 1px solid rgba(255,255,255,0.05); border-radius: 16px; padding: 40px; box-shadow: 0 10px 40px rgba(0,0,0,0.3); }
        .section-header { margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; display: flex; justify-content: space-between; align-items: center; }
        .section-title { font-size: 1.5rem; font-weight: 700; font-family: 'Montserrat', sans-serif; }
        .price-tag { color: var(--brand-blue); font-weight: 700; font-size: 1.2rem; }
        
        .input-group { margin-bottom: 25px; }
        .input-group label { display: block; color: var(--text-muted); margin-bottom: 10px; font-size: 0.9rem; }
        .city-select { width: 100%; padding: 15px; background: var(--card-bg); color: white; border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; font-size: 1rem; cursor: pointer; }
        
        .selection-grid { display: flex; gap: 12px; overflow-x: auto; padding-bottom: 10px; flex-wrap: wrap; }
        .select-btn { padding: 12px 20px; background: transparent; border: 1px solid rgba(255,255,255,0.2); color: white; border-radius: 10px; cursor: pointer; font-weight: 600; white-space: nowrap; transition: 0.3s; min-width: 80px; text-align: center; }
        .select-btn:hover, .select-btn.active { background: var(--brand-blue); border-color: var(--brand-blue); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(59,130,246,0.3); }
        
        .modal { display: none; position: fixed; z-index: 2000; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.9); backdrop-filter: blur(5px); justify-content: center; align-items: center; }
        .modal-content { background: #1a1a1a; padding: 40px; border-radius: 20px; width: 90%; max-width: 600px; border: 1px solid rgba(255,255,255,0.1); text-align: center; position: relative; }
        .close { position: absolute; top: 20px; right: 25px; font-size: 28px; cursor: pointer; color: var(--text-muted); }
        .screen-container { perspective: 500px; margin-bottom: 40px; margin-top: 20px; }
        .screen { background: linear-gradient(to bottom, #fff, rgba(255,255,255,0)); height: 60px; width: 80%; margin: 0 auto; transform: rotateX(-10deg); box-shadow: 0 25px 25px rgba(255,255,255,0.1); opacity: 0.8; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: bold; color: rgba(0,0,0,0.5); letter-spacing: 5px; }
        
        .seats-grid { display: grid; gap: 10px; justify-content: center; margin-bottom: 30px; margin-left: auto; margin-right: auto; }
        .seat { height: 35px; width: 35px; background: #333; border-radius: 8px 8px 4px 4px; cursor: pointer; position: relative; border-bottom: 4px solid #222; display: flex; align-items: center; justify-content: center; font-size: 10px; color: rgba(255,255,255,0.3); }
        .seat:hover:not(.occupied) { background: #555; transform: scale(1.1); }
        .seat.selected { background: var(--brand-blue); border-bottom-color: var(--brand-blue-dark); color: white; }
        .seat.occupied { background: #2a2a2a !important; color: #555 !important; cursor: not-allowed !important; border-bottom: 4px solid #1a1a1a; }
        .seat.occupied::after { content: "X"; color: #ef4444; font-size: 18px; font-weight: 800; position: absolute; }

        .legend { display: flex; justify-content: center; gap: 20px; margin-bottom: 30px; }
        .legend-item { display: flex; align-items: center; gap: 8px; font-size: 0.9rem; color: var(--text-muted); }
        .dot { width: 12px; height: 12px; border-radius: 4px; }
        .confirm-btn { width: 100%; padding: 15px; background: var(--gradient-main); color: white; border: none; border-radius: 12px; font-weight: 700; font-size: 1.1rem; cursor: pointer; transition: 0.3s; }
        .confirm-btn:hover { transform: translateY(-2px); box-shadow: 0 15px 35px rgba(59,130,246,0.5); }
    </style>
</head>
<body>

@include('components.navbar')

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
                    
                    @if($movie->trailer_url)
                        <a href="{{ $movie->trailer_url }}" target="_blank" class="tag" style="text-decoration:none; color:white; background:var(--brand-red); border-color:var(--brand-red); display:inline-flex; align-items:center; gap:5px;">
                            <i class="fa-brands fa-youtube"></i> Tonton Trailer
                        </a>
                    @endif
                </div>
                <div class="synopsis">
                    {{ $movie->description ?? 'Sinopsis film belum tersedia.' }}
                </div>
            </div>
        </div>
    </div>

    <div class="schedule-section">
        <div class="schedule-box">
            <div class="section-header">
                <div class="section-title">Jadwal Tayang</div>
                <div class="price-tag" id="priceDisplay">Mulai IDR {{ number_format($movie->ticket_price ?? 45000, 0, ',', '.') }}</div>
            </div>
            
            @if($movie->status == 'now_showing')
                <div class="input-group">
                    <label>Pilih Lokasi</label>
                    <select id="regionSelect" class="city-select">
                    </select>
                </div>

                <div class="input-group">
                    <label>Pilih Tanggal</label>
                    <div class="selection-grid" id="dateContainer">
                    </div>
                </div>

                <div class="input-group">
                    <label>Pilih Waktu & Studio</label>
                    <div class="selection-grid" id="timeContainer">
                        <span style="color:var(--text-muted); font-style:italic; font-size:0.9rem;">Silakan pilih tanggal terlebih dahulu.</span>
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
                <span id="modalStudioName"></span> • <span id="modalTime" style="color:var(--brand-blue); font-weight:bold;"></span>
            </p>
            <div class="screen-container"><div class="screen">SCREEN</div></div>
            
            <div class="seats-grid" id="seatsContainer"></div>
            
            <div class="legend">
                <div class="legend-item"><div class="dot" style="background:#333"></div> Kosong</div>
                <div class="legend-item"><div class="dot" style="background:var(--brand-blue)"></div> Dipilih</div>
                <div class="legend-item"><div class="dot" style="background:#2a2a2a; border: 1px solid #555;"></div> Terisi</div>
            </div>
            <button class="confirm-btn" onclick="confirmBooking()">
                Konfirmasi & Bayar <i class="fa-solid fa-arrow-right" style="margin-left:8px;"></i>
            </button>
        </div>
    </div>

    <form id="bookingForm" action="{{ route('booking.process') }}" method="POST" style="display: none;">
        @csrf
        <input type="hidden" name="showtime_id" id="showtimeIdInput">
        <input type="hidden" name="seats" id="seatsInput">
    </form>

    <script>
        // --- 0. INISIALISASI DATA & DEBUGGING ---
        const rawShowtimes = @json($movie->showtimes->load('studio'));
        console.log("Data Jadwal dari Backend:", rawShowtimes);

        let selectedDate = "";
        let selectedShowtime = null;
        let selectedSeats = [];

        const regionSelect = document.getElementById('regionSelect');
        const dateContainer = document.getElementById('dateContainer');
        const timeContainer = document.getElementById('timeContainer');

        if (regionSelect) {
            
            // --- 1. SETUP PILIHAN KOTA ---
            const uniqueCities = [...new Set(
                rawShowtimes
                .filter(item => item.studio) 
                .map(item => item.studio.city || 'Kota Belum Diset')
            )];

            regionSelect.innerHTML = "";
            if(uniqueCities.length > 0) {
                uniqueCities.forEach(city => {
                    let opt = document.createElement('option');
                    opt.value = city;
                    opt.innerText = city;
                    regionSelect.appendChild(opt);
                });
                
                regionSelect.onchange = function() {
                    renderDateButtons();
                };
            } else {
                let opt = document.createElement('option');
                opt.innerText = "Belum ada lokasi";
                regionSelect.appendChild(opt);
            }

            // --- 2. GENERATE TANGGAL (Hanya yang ada jadwalnya) ---
            function renderDateButtons() {
                dateContainer.innerHTML = "";
                const selectedCity = regionSelect.value;

                // RESET status pilihan tanggal & waktu saat ganti kota / render awal
                selectedDate = ""; 
                selectedShowtime = null;
                timeContainer.innerHTML = '<span style="color:var(--text-muted); font-style:italic; font-size:0.9rem;">Silakan pilih tanggal terlebih dahulu.</span>';
                document.getElementById('priceDisplay').innerText = "Mulai IDR {{ number_format($movie->ticket_price ?? 45000, 0, ',', '.') }}";

                const availableDates = [...new Set(
                    rawShowtimes
                    .filter(s => s.studio && (s.studio.city || 'Kota Belum Diset') === selectedCity)
                    .map(s => s.date ? s.date.substring(0, 10) : "")
                    .filter(d => d !== "")
                )].sort(); 

                if (availableDates.length === 0) {
                    dateContainer.innerHTML = '<span style="color:var(--text-muted); font-size:0.9rem; padding:10px;">Tidak ada tanggal tersedia</span>';
                    timeContainer.innerHTML = '<span style="color:var(--text-muted); font-style:italic; font-size:0.9rem;">Tidak ada jadwal di lokasi ini.</span>';
                    return;
                }

                const days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                const today = new Date();
                let nowYear = today.getFullYear();
                let nowMonth = ("0" + (today.getMonth() + 1)).slice(-2);
                let nowDay = ("0" + today.getDate()).slice(-2);
                const todayStr = `${nowYear}-${nowMonth}-${nowDay}`;

                availableDates.forEach((dateStr) => {
                    if (dateStr < todayStr) return;

                    let d = new Date(dateStr);
                    let dayName = dateStr === todayStr ? "Hari Ini" : days[d.getDay()];

                    let btn = document.createElement('button');
                    btn.className = 'select-btn date-btn';
                    
                    btn.innerHTML = `<div style="font-size:0.8rem; opacity:0.7;">${dayName}</div><div style="font-size:1.1rem;">${d.getDate()}</div>`;
                    
                    btn.onclick = function() {
                        document.querySelectorAll('.date-btn').forEach(b => b.classList.remove('active'));
                        btn.classList.add('active');
                        selectedDate = dateStr;
                        renderTimeButtons(); // Jam BARU AKAN MERENDER setelah tombol tanggal di-klik manual
                    };
                    
                    dateContainer.appendChild(btn);
                });
            }

            // --- 3. RENDER TOMBOL WAKTU ---
            function renderTimeButtons() {
                const selectedCity = regionSelect.value;
                timeContainer.innerHTML = '';
                selectedShowtime = null; 

                // Proteksi jika fungsi dipanggil paksa padahal tanggal kosong
                if (!selectedDate) {
                    timeContainer.innerHTML = '<span style="color:var(--text-muted); font-style:italic; font-size:0.9rem;">Silakan pilih tanggal terlebih dahulu.</span>';
                    return;
                }

                const availableShowtimes = rawShowtimes.filter(s => {
                    if (!s.studio) return false;
                    const dbDate = s.date ? s.date.substring(0, 10) : "";
                    const studioCity = s.studio.city || 'Kota Belum Diset';
                    return dbDate === selectedDate && studioCity === selectedCity;
                });

                if (availableShowtimes.length === 0) {
                    timeContainer.innerHTML = '<span style="color:var(--text-muted); width:100%; text-align:center; padding:20px;">Tidak ada jam tayang tersedia pada tanggal ini.</span>';
                    return;
                }

                availableShowtimes.sort((a, b) => a.start_time.localeCompare(b.start_time));

                const now = new Date();
                let nowYear = now.getFullYear();
                let nowMonth = ("0" + (now.getMonth() + 1)).slice(-2);
                let nowDay = ("0" + now.getDate()).slice(-2);
                const todayStr = `${nowYear}-${nowMonth}-${nowDay}`;
                const isToday = selectedDate === todayStr;

                availableShowtimes.forEach(showtime => {
                    const timeString = showtime.start_time.substring(0, 5);
                    
                    let isDisabled = false;
                    if (isToday) {
                        const [h, m] = timeString.split(':').map(Number);
                        const showTimeDate = new Date();
                        showTimeDate.setHours(h, m, 0);
                        if (showTimeDate < now) isDisabled = true;
                    }

                    let btn = document.createElement('button');
                    btn.className = 'select-btn time-btn';
                    btn.style.minWidth = '140px';
                    
                    btn.innerHTML = `
                        <div style="font-size:1.2rem; font-weight:bold;">${timeString}</div>
                        <div style="font-size:0.75rem; opacity:0.8;">${showtime.studio.name}</div>
                    `;

                    if (isDisabled) {
                        btn.disabled = true;
                        btn.style.opacity = '0.3';
                        btn.style.cursor = 'not-allowed';
                        btn.style.background = '#333';
                        btn.title = "Waktu sudah lewat";
                    } else {
                        btn.onclick = function() {
                            document.querySelectorAll('.time-btn').forEach(b => b.classList.remove('active'));
                            btn.classList.add('active');
                            selectedShowtime = showtime;
                            document.getElementById('priceDisplay').innerText = "IDR " + new Intl.NumberFormat('id-ID').format(showtime.price);
                        };
                    }
                    timeContainer.appendChild(btn);
                });
            }

            // Mulai render pertama kali saat halaman dimuat
            if(uniqueCities.length > 0) {
                renderDateButtons();
            }
        }

        // --- 4. MODAL & SEATS ---
        const modal = document.getElementById('seatModal');
        const seatsContainer = document.getElementById('seatsContainer');
        let occupiedSeats = [];

        async function checkAndOpenModal() {
            @guest
                window.location.href = "{{ route('login') }}";
                return;
            @endguest

            if (!selectedShowtime) { 
                alert("Mohon pilih jam tayang dan studio terlebih dahulu."); 
                return; 
            }
            
            document.getElementById('modalStudioName').innerText = selectedShowtime.studio.name;
            document.getElementById('modalTime').innerText = selectedShowtime.start_time.substring(0,5) + " WIB";

            modal.style.display = 'flex';
            seatsContainer.innerHTML = '<p style="color:white;">Memuat kursi...</p>';

            await fetchOccupiedSeats(selectedShowtime.id);
            renderSeats();
        }

        async function fetchOccupiedSeats(showtimeId) {
            try {
                const url = `{{ url('/api/seats') }}?showtime_id=${showtimeId}`;
                const response = await fetch(url);
                if (!response.ok) throw new Error('API Error');
                
                occupiedSeats = await response.json(); 
                console.log("✅ DATA KURSI DARI DATABASE:", occupiedSeats); 
            } catch (error) {
                console.log("Info: API kursi belum tersedia/error, menganggap semua kursi kosong.");
                occupiedSeats = [];
            }
        }

        function renderSeats() {
            seatsContainer.innerHTML = '';
            selectedSeats = [];
            
            const rows = selectedShowtime.studio.total_rows;
            const cols = selectedShowtime.studio.total_cols;
            
            seatsContainer.style.gridTemplateColumns = `repeat(${cols}, 1fr)`;
            
            const occupiedSet = new Set(occupiedSeats.map(s => String(s).trim().toUpperCase()));

            let totalSeats = rows * cols;
            for (let i = 1; i <= totalSeats; i++) {
                let seat = document.createElement('div');
                seat.className = 'seat';
                
                let rowIndex = Math.ceil(i / cols) - 1; 
                let colIndex = (i - 1) % cols + 1;
                let rowChar = String.fromCharCode(65 + rowIndex);
                let seatLabel = rowChar + colIndex;

                seat.innerText = seatLabel; 
                seat.style.fontSize = '0.7rem'; 

                if (occupiedSet.has(seatLabel)) {
                    seat.classList.add('occupied');
                } else {
                    seat.onclick = function() {
                        seat.classList.toggle('selected');
                        if (seat.classList.contains('selected')) {
                            selectedSeats.push(seatLabel);
                        } else {
                            selectedSeats = selectedSeats.filter(s => s !== seatLabel);
                        }
                    }
                }
                seatsContainer.appendChild(seat);
            }
        }

        function closeModal() { modal.style.display = 'none'; }
        window.onclick = function(e) { if(e.target == modal) closeModal(); }

        function confirmBooking() {
            if (selectedSeats.length === 0) { alert("Pilih minimal 1 kursi!"); return; }
            document.getElementById('showtimeIdInput').value = selectedShowtime.id;
            document.getElementById('seatsInput').value = selectedSeats.join(',');
            document.getElementById('bookingForm').submit();
        }
    </script>
</body>
</html>