<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avengers: Endgame – Bookingin</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #000;
            color: white;
        }

        /* ================= NAVBAR ================== */
        .navbar {
            width: 100%;
            padding: 15px 40px;
            background: rgba(0, 0, 0, 0.65);
            backdrop-filter: blur(6px);
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: fixed;
            top: 0;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .navbar-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .navbar .logo {
            font-size: 22px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .navbar nav a {
            color: white;
            text-decoration: none;
            margin-left: 25px;
            font-size: 15px;
            transition: 0.2s;
        }

        .navbar nav a:hover {
            color: #3b82f6;
        }

        .right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-bar input {
            padding: 6px 10px;
            border-radius: 6px;
            border: none;
            outline: none;
        }

        .btn-outline {
            padding: 7px 14px;
            border-radius: 6px;
            border: 1px solid white;
            color: white;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-outline:hover {
            background: white;
            color: black;
        }

        .btn-primary {
            padding: 7px 14px;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            transition: 0.2s;
        }

        .btn-primary:hover {
            background: #1d4ed8;
        }

        /* ================= HERO ================== */
        .hero {
            height: 60vh;
            background-image: url('/images/Avengers2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            position: relative;
            margin-top: 80px;
            /* Overlay untuk membuat teks lebih terbaca dan background lebih rapi */
            background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 50%, transparent 100%), url('/images/Avengers2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .hero-content {
            position: absolute;
            bottom: 40px;
            left: 40px;
            max-width: 800px;
            z-index: 10; /* Pastikan teks di atas overlay */
        }

        .hero h1 {
            font-size: 48px;
            font-weight: bold;
            margin: 0;
        }

        .hero .meta {
            margin-top: 10px;
            opacity: 0.9;
            font-size: 18px;
        }

        .hero .synopsis {
            margin-top: 15px;
            font-size: 16px;
            line-height: 1.5;
            opacity: 0.9;
            max-width: 700px;
        }

        /* ================= CONTENT ================== */
        .content-wrapper {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            /* Tambahkan background gambar di belakang tab jadwal tayang dan tulisan */
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.5) 0%, rgba(0, 0, 0, 0.7) 100%), url('/images/Avengers2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed; /* Agar gambar tetap saat scroll */
            padding: 0 20px; /* Tambahkan padding agar tidak terlalu mepet */
        }

        .content-box {
            width: 100%;
            background: rgba(255, 255, 255, 0.9); /* Buat semi-transparan agar gambar terlihat di belakang */
            color: #222;
            border-radius: 20px;
            padding: 30px;
            margin-top: -40px;
            margin-bottom: 60px;
            backdrop-filter: blur(5px); /* Efek blur untuk membuatnya lebih elegan */
        }

        .section-title {
            font-size: 26px;
            font-weight: bold;
            margin-bottom: 25px;
        }

        .format-text {
            font-size: 20px;
            font-weight: bold;
        }

        .price {
            margin-left: 10px;
            color: #0051ff;
            font-weight: bold;
        }

        /* ================= TIMES ================== */
        .times-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 20px;
        }

        .time-btn {
            padding: 10px 18px;
            border: 2px solid #0044ff;
            border-radius: 8px;
            color: #0044ff;
            font-weight: bold;
            cursor: pointer;
            transition: 0.2s;
        }

        .time-btn:hover {
            background: #0044ff;
            color: white;
        }

        /* ================= SEAT SELECTION MODAL ================== */
        .modal {
            display: none;
            position: fixed;
            z-index: 2000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: white;
            color: #222;
            padding: 30px;
            border-radius: 10px;
            width: 90%;
            max-width: 800px;
            max-height: 80vh;
            overflow-y: auto;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover {
            color: black;
        }

        .screen {
            text-align: center;
            margin-bottom: 20px;
            font-weight: bold;
            color: #333;
        }

        .seats {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .row {
            display: flex;
            margin-bottom: 10px;
        }

        .seat {
            width: 30px;
            height: 30px;
            margin: 2px;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 12px;
            background: #f0f0f0;
        }

        .seat.available:hover {
            background: #3b82f6;
            color: white;
        }

        .seat.selected {
            background: #2563eb;
            color: white;
        }

        .seat.occupied {
            background: #ccc;
            cursor: not-allowed;
        }

        .legend {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            gap: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .legend-seat {
            width: 20px;
            height: 20px;
            border-radius: 3px;
        }

        .confirm-btn {
            display: block;
            margin: 20px auto;
            padding: 10px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .confirm-btn:hover {
            background: #1d4ed8;
        }
    </style>
</head>

<body>

    <!-- ================= NAVBAR ================= -->
    <header class="navbar">
        <div class="navbar-container">
            <div class="logo">BOOKINGIN</div>
            <nav>
                <a href="/">Beranda</a>
                <a href="/movies">Movies</a>
            </nav>
            <div class="right">
                <div class="search-bar">
                    <input type="text" placeholder="Cari film...">
                </div>
                <a class="btn-outline" href="/login">Login</a>
                <a class="btn-primary" href="/register">Daftar</a>
            </div>
        </div>
    </header>

    <!-- ================= HERO ================= -->
    <div class="hero">
        <div class="hero-content">
            <h1>Avengers: Endgame</h1>
            <div class="meta">
                Action, Adventure, Drama • 3h 1m • PG-13 • English
            </div>
            <div class="synopsis">
                Setelah peristiwa menghancurkan di Avengers: Infinity War, alam semesta hancur.
                Dengan bantuan sekutu yang tersisa, para Avengers berkumpul sekali lagi untuk
                membalikkan tindakan Thanos dan memulihkan ketertiban di alam semesta.
            </div>
        </div>
    </div>

    <!-- ================= CONTENT WRAPPER ================= -->
    <div class="content-wrapper">
        <div class="content-box">
            <div class="section-title">Jadwal Tayang</div>
            <div class="format-text">
                REGULAR 2D
                <span class="price">Rp 52.000</span>
            </div>
            <div class="times-grid">
                <div class="time-btn" data-time="09:30">09:30</div>
                <div class="time-btn" data-time="12:30">12:30</div>
                <div class="time-btn" data-time="15:30">15:30</div>
                <div class="time-btn" data-time="18:30">18:30</div>
                <div class="time-btn" data-time="21:30">21:30</div>
            </div>
        </div>
    </div>

    <!-- ================= SEAT SELECTION MODAL ================= -->
    <div id="seatModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Pilih Kursi - <span id="selectedTime"></span></h2>
            <div class="screen">LAYAR</div>
            <div class="seats" id="seatsContainer">
                <!-- Seats will be generated here -->
            </div>
            <div class="legend">
                <div class="legend-item">
                    <div class="legend-seat" style="background: #f0f0f0;"></div>
                    <span>Tersedia</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat" style="background: #2563eb;"></div>
                    <span>Dipilih</span>
                </div>
                <div class="legend-item">
                    <div class="legend-seat" style="background: #ccc;"></div>
                    <span>Tidak Tersedia</span>
                </div>
            </div>
            <button class="confirm-btn" id="confirmBtn">Konfirmasi Pemesanan</button>
        </div>
    </div>

    <script>
        // Modal elements
        const modal = document.getElementById('seatModal');
        const closeBtn = document.querySelector('.close');
        const confirmBtn = document.getElementById('confirmBtn');
        const selectedTimeSpan = document.getElementById('selectedTime');
        const seatsContainer = document.getElementById('seatsContainer');

        // Seat layout: 10 rows (A-J), 10 seats per row
        const rows = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J'];
        const seatsPerRow = 10;
        let selectedSeats = [];

        // Generate seats
        function generateSeats() {
            seatsContainer.innerHTML = '';
            rows.forEach(row => {
                const rowDiv = document.createElement('div');
                rowDiv.className = 'row';
                for (let i = 1; i <= seatsPerRow; i++) {
                    const seatDiv = document.createElement('div');
                    seatDiv.className = 'seat available';
                    seatDiv.textContent = row + i;
                    seatDiv.dataset.seat = row + i;
                    // Randomly mark some seats as occupied
                    if (Math.random() < 0.3) {
                        seatDiv.classList.remove('available');
                        seatDiv.classList.add('occupied');
                    }
                    seatDiv.addEventListener('click', toggleSeat);
                    rowDiv.appendChild(seatDiv);
                }
                seatsContainer.appendChild(rowDiv);
            });
        }

        // Toggle seat selection
        function toggleSeat(e) {
            const seat = e.target;
            if (seat.classList.contains('occupied')) return;
            seat.classList.toggle('selected');
            const seatId = seat.dataset.seat;
            if (seat.classList.contains('selected')) {
                selectedSeats.push(seatId);
            } else {
                selectedSeats = selectedSeats.filter(s => s !== seatId);
            }
        }

        // Open modal when time button is clicked
        document.querySelectorAll('.time-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const time = this.dataset.time;
                selectedTimeSpan.textContent = time;
                selectedSeats = [];
                generateSeats();
                modal.style.display = 'flex';
            });
        });

        // Close modal
        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // Close modal when clicking outside
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });

        // Confirm booking
        confirmBtn.addEventListener('click', () => {
            if (selectedSeats.length === 0) {
                alert('Pilih setidaknya satu kursi.');
                return;
            }
            alert(`Pemesanan berhasil untuk kursi: ${selectedSeats.join(', ')} pada jam ${selectedTimeSpan.textContent}`);
            modal.style.display = 'none';
            // Here you can add logic to process the booking
        });
    </script>

</body>
</html>
