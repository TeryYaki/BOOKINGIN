<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookingin – Main Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-bg: #0f0f0f;
            --secondary-bg: #1a1a1a;
            --hover-bg: #2a2a2a;
            --text-color: #ffffff;
            --accent-color: #444444;
            --hero-gradient: linear-gradient(to bottom, rgba(0,0,0,0.4), rgba(0,0,0,0.9));
            --blue-primary: #3b82f6;
            --blue-hover: #2563eb;
            --red-primary: #ef4444;
            --red-hover: #dc2626;
            --gray-light: #888888;
            --shadow: 0 4px 12px rgba(0,0,0,0.5);
            --border-radius: 12px;
            --transition: all 0.3s ease;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: var(--primary-bg);
            color: var(--text-color);
            line-height: 1.6;
            overflow-x: hidden;
        }

        /* Navbar Styles */
        header.navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0,0,0,0.9);
            backdrop-filter: blur(10px);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: var(--shadow);
            border-bottom: 1px solid var(--accent-color);
        }
        .navbar .logo {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--text-color);
            letter-spacing: 2px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.5);
        }
        .navbar nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .navbar a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: var(--transition);
            padding: 0.5rem 1rem;
            border-radius: 8px;
        }
        .navbar a:hover { 
            color: var(--blue-primary); 
            background: rgba(59, 130, 246, 0.1);
        }

        /* User Profile */
        .user-menu {
            display: flex; 
            align-items: center; 
            gap: 15px;
            padding-left: 15px; 
            border-left: 1px solid var(--accent-color);
        }
        .user-info { 
            display: flex; 
            align-items: center; 
            gap: 10px; 
        }
        .user-avatar {
            width: 40px; 
            height: 40px; 
            border-radius: 50%;
            object-fit: cover; 
            border: 2px solid var(--blue-primary);
            transition: var(--transition);
        }
        .user-avatar:hover { border-color: var(--blue-hover); }
        .user-name { 
            font-weight: 600; 
            font-size: 1rem; 
            color: var(--text-color); 
            transition: var(--transition);
        }
        .user-name:hover { color: var(--blue-primary); }
        .btn-logout {
            background: var(--red-primary); 
            color: white; 
            border: none;
            padding: 8px 16px; 
            border-radius: 8px; 
            cursor: pointer;
            font-weight: 600; 
            transition: var(--transition);
            box-shadow: var(--shadow);
        }
        .btn-logout:hover { 
            background: var(--red-hover); 
            transform: translateY(-2px);
        }

        /* Hero Styles */
        .hero {
            margin-top: 80px; 
            height: 75vh;
            background-image: url('images/the-premiere-1.jpg');
            background-size: cover; 
            background-position: center;
            position: relative;
            display: flex;
            align-items: flex-end;
        }
        .hero::before {
            content: ""; 
            position: absolute; 
            inset: 0; 
            background: var(--hero-gradient);
        }
        .hero-overlay {
            position: relative; 
            bottom: 3rem; 
            left: 3rem; 
            z-index: 2;
            animation: fadeInUp 1s ease-out;
        }
        .hero-title {
            font-size: 4.5rem; 
            font-weight: 700; 
            text-shadow: 2px 2px 8px rgba(0,0,0,0.8);
            margin: 0;
            letter-spacing: 1px;
        }

        /* General Sections */
        main { padding: 0 2rem; }
        .section { 
            padding: 4rem 0; 
            max-width: 1200px; 
            margin: auto; 
        }
        .section-title {
            font-size: 2.5rem; 
            margin-bottom: 2rem; 
            width: fit-content;
            border-bottom: 3px solid var(--blue-primary);
            padding-bottom: 0.5rem;
            font-weight: 700;
        }

        /* Features Grid */
        .features {
            display: grid; 
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); 
            gap: 2.5rem;
        }
        .feature-card {
            background: var(--secondary-bg); 
            padding: 2rem; 
            border-radius: var(--border-radius);
            text-align: center; 
            transition: var(--transition);
            box-shadow: var(--shadow);
            border: 1px solid var(--accent-color);
        }
        .feature-card:hover {
            background: var(--hover-bg); 
            transform: translateY(-8px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.6);
        }
        .feature-card img {
            width: 100%; 
            height: 220px; 
            object-fit: cover; 
            border-radius: 10px;
            margin-bottom: 1.5rem;
        }
        .feature-card h3 {
            font-size: 1.5rem;
            margin-bottom: 1rem;
            font-weight: 600;
        }
        .feature-card p {
            color: var(--gray-light);
            font-size: 1rem;
        }

        /* Movie Section Styles */
        .movie-tabs {
            display: flex; 
            justify-content: center; 
            gap: 3rem;
            margin-bottom: 3rem; 
            border-bottom: 2px solid var(--accent-color);
            padding-bottom: 10px;
        }
        .movie-tabs .tab {
            background: none; 
            border: none; 
            font-size: 1.3rem; 
            font-weight: 600;
            color: var(--gray-light); 
            cursor: pointer; 
            padding: 0.75rem 1.5rem;
            transition: var(--transition); 
            border-bottom: 3px solid transparent;
            border-radius: 8px;
        }
        .movie-tabs .tab.active {
            border-bottom: 3px solid var(--blue-primary); 
            color: var(--text-color);
            background: rgba(59, 130, 246, 0.1);
        }
        .movie-tabs .tab:hover {
            color: var(--blue-primary);
        }

        .movie-carousel {
            position: relative; 
            display: flex; 
            align-items: center; 
            padding: 0 50px; 
        }
        .movie-list {
            display: flex; 
            gap: 2rem; 
            overflow-x: auto; 
            padding: 1.5rem 0; 
            scroll-behavior: smooth; 
            -ms-overflow-style: none; 
            scrollbar-width: none;
        }
        .movie-list::-webkit-scrollbar { display: none; }

        /* Container Poster */
        .movie-poster-container {
            position: relative; 
            width: 220px; 
            height: 330px; 
            border-radius: var(--border-radius); 
            overflow: hidden; 
            flex-shrink: 0;
            box-shadow: var(--shadow);
            transition: var(--transition); 
            cursor: pointer;
        }
        
        .movie-poster-container img {
            width: 100%; 
            height: 100%; 
            object-fit: cover; 
            display: block;
        }

        .movie-overlay {
            position: absolute; 
            top: 0; 
            left: 0; 
            width: 100%; 
            height: 100%;
            background: rgba(0, 0, 0, 0.8); 
            display: flex;
            justify-content: center; 
            align-items: center;
            opacity: 0; 
            transition: var(--transition); 
            z-index: 5;
        }
        .movie-poster-container:hover { 
            transform: scale(1.08); 
            box-shadow: 0 8px 25px rgba(0,0,0,0.7);
        }
        .movie-poster-container:hover .movie-overlay { opacity: 1; }

        .book-now-btn {
            background-color: var(--blue-primary); 
            color: white;
            padding: 0.875rem 1.75rem; 
            border: none; 
            border-radius: 8px;
            text-decoration: none; 
            font-weight: 600; 
            font-size: 1.1rem;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }
        .book-now-btn:hover { 
            background-color: var(--blue-hover); 
            transform: translateY(-2px);
        }

        .carousel-btn {
            background: var(--blue-primary); 
            border: none; 
            color: white;
            font-size: 1.8rem; 
            width: 55px; 
            height: 55px; 
            border-radius: 50%; 
            cursor: pointer; 
            position: absolute; 
            z-index: 10;
            box-shadow: var(--shadow); 
            transition: var(--transition);
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 0; 
        }
        .carousel-btn:hover { 
            background: var(--blue-hover); 
            transform: scale(1.1);
        }
        .carousel-btn.left { left: 10px; }
        .carousel-btn.right { right: 10px; }
        
        @media (max-width: 768px) {
            .hero-title { font-size: 3rem; }
            .movie-carousel { padding: 0 20px; }
            .carousel-btn.left { left: 5px; }
            .carousel-btn.right { right: 5px; }
            .user-menu { 
                flex-direction: column; 
                align-items: flex-start; 
                border-left: none; 
                padding-left: 0; 
                gap: 10px;
            }
            .movie-tabs { gap: 1.5rem; }
            .features { grid-template-columns: 1fr; }
        }

        .hidden { display: none; }

        footer {
            background: rgba(0,0,0,0.9); 
            padding: 2rem; 
            text-align: center; 
            color: var(--gray-light);
            border-top: 1px solid var(--accent-color);
        }

        /* Animations */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>

<body>

<header class="navbar">
    <div class="logo">BOOKINGIN</div>
    <nav>
        <a href="{{ route('home') }}" style="color:#3b82f6;">Beranda</a>
        <a href="{{ route('movies') }}">Movies</a>

        {{-- LOGIKA: Jika Belum Login (Guest) --}}
        @guest
            <a href="{{ route('register') }}" aria-label="register" style="background:#e50914; padding:5px 15px; border-radius:5px;">Daftar</a>
            <a href="{{ route('login') }}" aria-label="login" style="background:#3b82f6; padding:5px 15px; border-radius:5px;">Login</a>
        @endguest

        {{-- LOGIKA: Jika Sudah Login (Auth) --}}
        @auth
            <div class="user-menu">
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128" 
                         alt="User Profile" 
                         class="user-avatar">
                    <a href="{{ route('profile') }}" class="user-name" style="color: white; text-decoration: none; font-weight: bold;">
                        {{ Auth::user()->name }}
                    </a>
                </div>
                
                <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                    @csrf
                    <button type="submit" class="btn-logout">Keluar</button>
                </form>
            </div>
        @endauth
    </nav>
</header>

<div class="hero">
    <div class="hero-overlay">
        <h1 class="hero-title">BOOKINGIN</h1>
    </div>
</div>

<main>

<section class="section movie-section">
    <h2 class="section-title" style="margin:auto; text-align:center; margin-bottom: 3rem;">Choose Your Movie</h2>

    <div class="movie-tabs">
        <button class="tab active" onclick="showTab('now')">Now Showing</button>
        <button class="tab" onclick="showTab('upcoming')">Upcoming</button>
    </div>

    <div class="movie-carousel" id="nowShowing">
        <button class="carousel-btn left" onclick="scrollMovies('movieList', -1)">&#10094;</button>
  
        <div class="movie-list" id="movieList">
            @forelse($nowShowing as $movie)
                <div class="movie-poster-container">
                    <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}">
                    <div class="movie-overlay">
                        <a href="{{ route('film', $movie->id) }}" class="book-now-btn">Book Now</a>
                    </div>
                </div>
            @empty
                <div style="padding: 20px; color: white;">Belum ada film yang tayang.</div>
            @endforelse
        </div>

        <button class="carousel-btn right" onclick="scrollMovies('movieList', 1)">&#10095;</button>
    </div>

    <div class="movie-carousel hidden" id="upcomingMovies">
        <button class="carousel-btn left" onclick="scrollMovies('upcomingMovieList', -1)">&#10094;</button>

        <div class="movie-list" id="upcomingMovieList">
            @forelse($upcoming as $movie)
                <div class="movie-poster-container">
                    <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}">
                    <div class="movie-overlay">
                        <span class="book-now-btn" style="background: #555; cursor: default;">Coming Soon</span>
                    </div>
                </div>
            @empty
                <div style="padding: 20px; color: white;">Belum ada film upcoming.</div>
            @endforelse
        </div>

        <button class="carousel-btn right" onclick="scrollMovies('upcomingMovieList', 1)">&#10095;</button>
    </div>

</section>

<section class="section description">
    <h2 class="section-title">Pemesanan Tiket yang Lebih Mudah</h2>
    <p style="font-size: 1.2rem; color: var(--gray-light); max-width: 800px; margin: auto;">
        Bookingin memudahkan Anda untuk memesan tiket film favorit dengan cepat, praktis, dan tanpa ribet.
        Nikmati pengalaman memilih film, menentukan kursi, hingga pembayaran langsung dalam satu platform.
    </p>
</section>

<section class="section">
    <h2 class="section-title">About BOOKINGIN</h2>

    <div class="features">
        <div class="feature-card">
            <img src="images/Phone.jpg" alt="Fitur Pemesanan Cepat">
            <h3>Pemesanan Cepat & Praktis</h3>
            <p>Pilih film, pilih kursi, pesan tiket hanya dalam hitungan detik.</p>
        </div>

        <div class="feature-card">
            <img src="images/Seat.png" alt="Fitur Pilihan Kursi">
            <h3>Pilihan Kursi Fleksibel</h3>
            <p>Pilih sendiri kursi terbaik langsung dari layout bioskop.</p>
        </div>

        <div class="feature-card">
            <img src="images/Payment.jpg" alt="Fitur Pembayaran Aman">
            <h3>Pembayaran Aman & Beragam</h3>
            <p>Tersedia e-wallet, bank transfer, debit, dan QRIS.</p>
        </div>
    </div>
</section>

</main>

<footer>
    <p>© 2025 Bookingin. Semua hak cipta dilindungi. | Dibuat untuk kemudahan pemesanan tiket Anda.</p>
</footer>

<script>
function showTab(type) {
    const tabs = document.querySelectorAll(".tab");
    tabs.forEach(btn => btn.classList.remove("active"));
    
    if (type === "now") {
        tabs[0].classList.add("active");
        document