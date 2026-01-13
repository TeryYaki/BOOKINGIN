<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookingin – Main Page</title>

    <style>
        :root {
            --primary-bg: #111;
            --secondary-bg: #1b1b1b;
            --hover-bg: #262626;
            --text-color: white;
            --accent-color: #444;
            --hero-gradient: linear-gradient(to bottom, rgba(0,0,0,0.3), rgba(0,0,0,0.8));
            --blue-primary: #3b82f6;
            --blue-hover: #2563eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: var(--primary-bg);
            color: var(--text-color);
            line-height: 1.6;
        }

        /* Navbar Styles */
        header.navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: black;
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }
        .navbar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--text-color);
            letter-spacing: 2px;
        }
        .navbar nav {
            display: flex;
            align-items: center; /* Agar sejajar vertikal */
            gap: 1.5rem;
        }
        .navbar a {
            color: var(--text-color);
            text-decoration: none;
            font-weight: 500;
            transition: .3s;
        }
        .navbar a:hover {
            color: var(--blue-primary);
        }

        /* --- TAMBAHAN STYLE UNTUK USER PROFILE --- */
        .user-menu {
            display: flex;
            align-items: center;
            gap: 15px;
            padding-left: 15px;
            border-left: 1px solid #333; /* Garis pemisah tipis */
        }
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .user-avatar {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--blue-primary);
        }
        .user-name {
            font-weight: bold;
            font-size: 0.95rem;
            color: white;
        }
        .btn-logout {
            background: #ef4444; /* Warna Merah */
            color: white;
            border: none;
            padding: 6px 15px;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
            transition: 0.3s;
        }
        .btn-logout:hover {
            background: #dc2626;
        }

        /* Hero Styles */
        .hero {
            margin-top: 70px;
            height: 70vh;
            background-image: url('images/the-premiere-1.jpg');
            background-size: cover;
            background-position: center;
            position: relative;
        }
        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background: var(--hero-gradient);
        }
        .hero-overlay {
            position: absolute;
            bottom: 2rem;
            left: 2rem;
            z-index: 2;
        }
        .hero-title {
            font-size: 4rem;
            font-weight: bold;
            text-shadow: 2px 2px 4px black;
        }

        /* General Sections */
        main {
            padding: 0 2rem;
        }
        .section {
            padding: 3rem 0;
            max-width: 1200px;
            margin: auto;
        }
        .section-title {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            width: fit-content;
            border-bottom: 2px solid var(--accent-color);
        }

        /* Features Grid */
        .features {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }
        .feature-card {
            background: var(--secondary-bg);
            padding: 1.5rem;
            border-radius: 12px;
            text-align: center;
            transition: .3s;
        }
        .feature-card:hover {
            background: var(--hover-bg);
            transform: translateY(-6px);
        }
        .feature-card img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Movie Section Styles */
        .movie-tabs {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            margin-bottom: 2.5rem;
            border-bottom: 1px solid var(--accent-color);
            padding-bottom: 5px;
        }
        .movie-tabs .tab {
            background: none;
            border: none;
            font-size: 1.2rem;
            font-weight: 600;
            color: #888;
            cursor: pointer;
            padding: .5rem 1rem;
            transition: .3s;
            border-bottom: 3px solid transparent;
        }
        .movie-tabs .tab.active {
            border-bottom: 3px solid var(--blue-primary);
            color: white;
        }

        .movie-carousel {
            position: relative;
            display: flex;
            align-items: center;
            padding: 0 40px; 
        }
        .movie-list {
            display: flex;
            gap: 1.5rem; 
            overflow-x: auto;
            padding: 1rem 0; 
            scroll-behavior: smooth;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .movie-list::-webkit-scrollbar {
            display: none;
        }

        .movie-poster-container {
            position: relative;
            width: 200px; 
            height: 300px; 
            border-radius: 10px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            transition: transform .3s;
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
            background: rgba(0, 0, 0, 0.7);
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0; 
            transition: opacity 0.3s ease;
            z-index: 5;
        }
        .movie-poster-container:hover {
            transform: scale(1.05); 
        }
        .movie-poster-container:hover .movie-overlay {
            opacity: 1; 
        }

        .book-now-btn {
            background-color: var(--blue-primary);
            color: white;
            padding: 0.75rem 1.5rem;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
            font-size: 1rem;
            transition: background-color 0.2s;
        }
        .book-now-btn:hover {
            background-color: var(--blue-hover);
        }

        .carousel-btn {
            background: var(--blue-primary);
            border: none;
            color: white;
            font-size: 1.5rem;
            width: 50px; 
            height: 50px; 
            border-radius: 50%; 
            cursor: pointer;
            position: absolute;
            z-index: 10;
            box-shadow: 0 2px 5px rgba(0,0,0,0.5);
            transition: .2s;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0; 
        }
        .carousel-btn:hover {
            background: var(--blue-hover);
        }
        .carousel-btn.left { left: 0; }
        .carousel-btn.right { right: 0; }
        
        @media (max-width: 768px) {
            .movie-carousel { padding: 0 10px; }
            .carousel-btn.left { left: 0px; }
            .carousel-btn.right { right: 0px; }
            .user-menu { flex-direction: column; align-items: flex-start; border-left: none; padding-left: 0; }
        }

        .hidden { display: none; }

        footer {
            background: black;
            padding: 1.5rem;
            text-align: center;
            color: #888;
        }
    </style>
</head>

<body>

<header class="navbar">
    <div class="logo">BOOKINGIN</div>
    <nav>
        <a href="{{ url('/') }}" aria-label="Beranda">Beranda</a>
        <a href="{{ route('movies') }}" aria-label="Movies">Movies</a>

        {{-- LOGIKA: Jika Belum Login (Guest) --}}
        @guest
            <a href="{{ route('register') }}" aria-label="register">Daftar</a>
            <a href="{{ route('login') }}" aria-label="login">Login</a>
        @endguest

        {{-- LOGIKA: Jika Sudah Login (Auth) --}}
        @auth
            <div class="user-menu">
                <div class="user-info">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128" 
                         alt="User Profile" 
                         class="user-avatar">
                    <span class="user-name">{{ Auth::user()->name }}</span>
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
            {{-- FILM 1-10 (Now Showing) --}}
            <div class="movie-poster-container">
                <img src="images/poster6.jpg" alt="Poster Film 1">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster2.jpg" alt="Poster Film 2">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster3.jpg" alt="Poster Film 3">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster4.jpg" alt="Poster Film 4">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster5.jpg" alt="Poster Film 5">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster1.jpg" alt="Poster Film 6">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster7.jpg" alt="Poster Film 7">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster8.jpg" alt="Poster Film 8">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster9.jpg" alt="Poster Film 9">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster10.jpg" alt="Poster Film 10">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
        </div>

        <button class="carousel-btn right" onclick="scrollMovies('movieList', 1)">&#10095;</button>
    </div>

    <div class="movie-carousel hidden" id="upcomingMovies">
        <button class="carousel-btn left" onclick="scrollMovies('upcomingMovieList', -1)">&#10094;</button>

        <div class="movie-list" id="upcomingMovieList">
            {{-- FILM 11-15 (Upcoming) --}}
            <div class="movie-poster-container">
                <img src="images/poster11.jpg" alt="Poster Film 11">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster12.jpg" alt="Poster Film 12">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster13.jpg" alt="Poster Film 13">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster14.jpg" alt="Poster Film 14">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
            <div class="movie-poster-container">
                <img src="images/poster15.jpg" alt="Poster Film 15">
                <div class="movie-overlay"><a href="#" class="book-now-btn">Book Now</a></div>
            </div>
        </div>

        <button class="carousel-btn right" onclick="scrollMovies('upcomingMovieList', 1)">&#10095;</button>
    </div>

</section>

<section class="section description">
    <h2 class="section-title">Pemesanan Tiket yang Lebih Mudah</h2>
    <p>
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
        document.getElementById("nowShowing").classList.remove("hidden");
        document.getElementById("upcomingMovies").classList.add("hidden");
    } else {
        tabs[1].classList.add("active");
        document.getElementById("upcomingMovies").classList.remove("hidden");
        document.getElementById("nowShowing").classList.add("hidden");
    }
}

function scrollMovies(listId, direction) {
    const list = document.getElementById(listId);
    const scrollAmount = 648 * direction;
    list.scrollBy({ left: scrollAmount, behavior: "smooth" });
}
</script>

</body>
</html>