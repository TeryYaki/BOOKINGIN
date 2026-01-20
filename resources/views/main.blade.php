<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bookingin – Main Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-bg: #0a0a0a;
            --secondary-bg: #161616;
            --card-bg: #1f1f1f;
            --text-main: #ffffff;
            --text-muted: #a1a1a1;
            
            --brand-blue: #3b82f6;
            --brand-blue-dark: #2563eb;
            --brand-red: #ef4444;
            
            --gradient-main: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            --hero-overlay: linear-gradient(to bottom, rgba(10,10,10,0.3) 0%, rgba(10,10,10,0.8) 60%, #0a0a0a 100%);
            
            --glass: rgba(22, 22, 22, 0.8);
            --shadow: 0 10px 30px rgba(0,0,0,0.5);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: var(--primary-bg);
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3 { font-family: 'Montserrat', sans-serif; }

        /* --- NAVBAR MODERN --- */
        header.navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(12px);
            padding: 1rem 5%;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            transition: var(--transition);
        }

        .navbar .logo {
            font-size: 1.8rem;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: 1px;
            background: var(--gradient-main);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .navbar nav { display: flex; align-items: center; gap: 20px; }

        .nav-link {
            color: var(--text-muted);
            text-decoration: none;
            font-weight: 500;
            font-size: 0.95rem;
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover, .nav-link.active { color: var(--text-main); }
        
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0; height: 2px;
            bottom: -5px; left: 0;
            background: var(--brand-blue);
            transition: var(--transition);
        }
        .nav-link:hover::after { width: 100%; }

        /* Auth Buttons */
        .btn-auth {
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 0.9rem;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
        }
        .btn-login { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.1); }
        .btn-login:hover { background: white; color: black; }
        .btn-register { background: var(--brand-blue); color: white; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
        .btn-register:hover { background: var(--brand-blue-dark); transform: translateY(-2px); }

        /* User Profile */
        .user-menu { display: flex; align-items: center; gap: 15px; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 20px; }
        .user-info { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; border: 2px solid var(--brand-blue); }
        .user-name { font-weight: 600; font-size: 0.95rem; color: white; }
        
        .btn-logout {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid rgba(255,255,255,0.1);
            padding: 6px 14px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.8rem;
            transition: var(--transition);
        }
        .btn-logout:hover { border-color: var(--brand-red); color: var(--brand-red); }

        /* --- HERO SECTION --- */
        .hero {
            height: 85vh;
            background: url('images/the-premiere-1.jpg') no-repeat center center/cover;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 3rem;
        }
        .hero::after { content: ""; position: absolute; inset: 0; background: var(--hero-overlay); }
        
        .hero-content {
            position: relative;
            z-index: 10;
            text-align: center;
            animation: fadeInUp 1s ease-out;
        }
        .hero-title {
            font-size: 5rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin-bottom: 1rem;
            text-shadow: 0 10px 30px rgba(0,0,0,0.8);
        }
        .hero-subtitle {
            font-size: 1.2rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto;
        }

        /* --- SECTIONS --- */
        .container { max-width: 1300px; margin: 0 auto; padding: 0 2rem; }
        .section { padding: 4rem 0; }
        
        .section-header {
            text-align: center;
            margin-bottom: 3rem;
        }
        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            display: inline-block;
            position: relative;
        }
        .section-title::after {
            content: ''; display: block; width: 60px; height: 4px; 
            background: var(--brand-blue); margin: 10px auto 0; border-radius: 2px;
        }

        /* --- TABS --- */
        .movie-tabs {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 2.5rem;
            background: var(--secondary-bg);
            padding: 5px;
            border-radius: 50px;
            width: fit-content;
            margin-left: auto; margin-right: auto;
            border: 1px solid rgba(255,255,255,0.05);
        }
        .tab {
            background: none; border: none;
            color: var(--text-muted);
            padding: 10px 25px;
            border-radius: 30px;
            font-weight: 600;
            cursor: pointer;
            transition: var(--transition);
        }
        .tab.active { background: var(--brand-blue); color: white; box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4); }
        .tab:hover:not(.active) { color: white; }

        /* --- CAROUSEL --- */
        .carousel-wrapper { position: relative; padding: 0 60px; }
        .movie-list {
            display: flex;
            gap: 25px;
            overflow-x: auto;
            scroll-behavior: smooth;
            padding: 20px 5px;
            scrollbar-width: none; /* Hide scrollbar Firefox */
        }
        .movie-list::-webkit-scrollbar { display: none; }

        /* --- MOVIE CARD --- */
        .movie-card {
            flex: 0 0 240px;
            height: 360px;
            position: relative;
            border-radius: 16px;
            overflow: hidden;
            transition: var(--transition);
            box-shadow: 0 5px 15px rgba(0,0,0,0.3);
            cursor: pointer;
            background: #000;
        }
        .movie-card img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.5s ease; }
        .movie-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0,0,0,0.6); }
        .movie-card:hover img { transform: scale(1.1); opacity: 0.6; }

        .movie-overlay {
            position: absolute; inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9), transparent);
            display: flex; flex-direction: column;
            justify-content: flex-end; align-items: center;
            padding: 20px;
            opacity: 0; transition: var(--transition);
        }
        .movie-card:hover .movie-overlay { opacity: 1; }

        .book-btn {
            background: var(--brand-blue);
            color: white;
            padding: 12px 30px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            box-shadow: 0 0 20px rgba(59, 130, 246, 0.5);
            transition: var(--transition);
        }
        .book-btn:hover { background: white; color: var(--brand-blue); transform: scale(1.05); }

        /* Carousel Nav Buttons */
        .nav-btn {
            position: absolute; top: 50%; transform: translateY(-50%);
            width: 50px; height: 50px;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(5px);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 50%;
            color: white; font-size: 1.2rem;
            cursor: pointer; z-index: 10;
            transition: var(--transition);
            display: flex; justify-content: center; align-items: center;
        }
        .nav-btn:hover { background: var(--brand-blue); border-color: var(--brand-blue); transform: translateY(-50%) scale(1.1); }
        .nav-btn.left { left: 0; }
        .nav-btn.right { right: 0; }

        /* --- FEATURES --- */
        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }
        .feature-item {
            background: var(--secondary-bg);
            border: 1px solid rgba(255,255,255,0.05);
            border-radius: 16px;
            padding: 2rem;
            text-align: center;
            transition: var(--transition);
        }
        .feature-item:hover { 
            transform: translateY(-5px); 
            background: var(--card-bg); 
            border-color: rgba(59, 130, 246, 0.3);
        }
        .feature-icon {
            width: 70px; height: 70px;
            margin: 0 auto 1.5rem;
            background: rgba(59, 130, 246, 0.1);
            border-radius: 50%;
            display: flex; justify-content: center; align-items: center;
            color: var(--brand-blue);
            font-size: 1.8rem;
        }
        .feature-item h3 { margin-bottom: 0.8rem; color: white; }
        .feature-item p { color: var(--text-muted); font-size: 0.95rem; }

        /* --- FOOTER --- */
        footer {
            background: #050505;
            padding: 3rem 0;
            text-align: center;
            border-top: 1px solid rgba(255,255,255,0.05);
            margin-top: 4rem;
        }

        /* Utils */
        .hidden { display: none !important; }
        @keyframes fadeInUp { from { opacity: 0; transform: translateY(40px); } to { opacity: 1; transform: translateY(0); } }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .hero-title { font-size: 3rem; }
            .carousel-wrapper { padding: 0; }
            .navbar { padding: 1rem; }
            .navbar nav { gap: 10px; }
            .nav-link { display: none; } /* Hide links on mobile for simplicity or use hamburger */
            .logo { font-size: 1.5rem; }
        }
    </style>
</head>

<body>

    <header class="navbar">
        <div class="logo">BOOKINGIN</div>
        <nav>
            <a href="{{ route('home') }}" class="nav-link active">Beranda</a>
            <a href="{{ route('movies') }}" class="nav-link">Movies</a>

            @guest
                <a href="{{ route('register') }}" class="btn-auth btn-register">Daftar</a>
                <a href="{{ route('login') }}" class="btn-auth btn-login">Login</a>
            @endguest

            @auth
                <div class="user-menu">
                    <a href="{{ route('profile') }}" class="user-info">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&size=128" 
                             alt="Profile" class="user-avatar">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" class="btn-logout" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </header>

    <div class="hero">
        <div class="hero-content">
            <h1 class="hero-title">BOOKINGIN</h1>
            <p class="hero-subtitle">Nikmati pengalaman menonton terbaik dengan pemesanan tiket yang cepat, mudah, dan terpercaya.</p>
        </div>
    </div>

    <main class="container">

        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Pilih Film Anda</h2>
            </div>

            <div class="movie-tabs">
                <button class="tab active" onclick="showTab('now')">Sedang Tayang</button>
                <button class="tab" onclick="showTab('upcoming')">Akan Datang</button>
            </div>

            <div id="nowShowing" class="carousel-wrapper">
                <button class="nav-btn left" onclick="scrollMovies('movieList', -1)">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>
          
                <div class="movie-list" id="movieList">
                    @forelse($nowShowing as $movie)
                        <div class="movie-card">
                            <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}" loading="lazy">
                            <div class="movie-overlay">
                                <h3 style="color:white; margin-bottom:10px; text-align:center;">{{ $movie->title }}</h3>
                                <a href="{{ route('film', $movie->id) }}" class="book-btn">Book Now</a>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 20px; color: var(--text-muted); width:100%; text-align:center;">
                            Belum ada film yang sedang tayang.
                        </div>
                    @endforelse
                </div>

                <button class="nav-btn right" onclick="scrollMovies('movieList', 1)">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>

            <div id="upcomingMovies" class="carousel-wrapper hidden">
                <button class="nav-btn left" onclick="scrollMovies('upcomingMovieList', -1)">
                    <i class="fa-solid fa-chevron-left"></i>
                </button>

                <div class="movie-list" id="upcomingMovieList">
                    @forelse($upcoming as $movie)
                        <div class="movie-card">
                            <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}" loading="lazy">
                            <div class="movie-overlay">
                                <span class="book-btn" style="background: #333; cursor: default; border:1px solid #555;">Coming Soon</span>
                            </div>
                        </div>
                    @empty
                        <div style="padding: 20px; color: var(--text-muted); width:100%; text-align:center;">
                            Belum ada film upcoming.
                        </div>
                    @endforelse
                </div>

                <button class="nav-btn right" onclick="scrollMovies('upcomingMovieList', 1)">
                    <i class="fa-solid fa-chevron-right"></i>
                </button>
            </div>
        </section>

        <section class="section" style="background: linear-gradient(to right, #0f0f0f, #1a1a1a); border-radius: 20px; padding: 4rem;">
            <div style="display:flex; flex-wrap:wrap; align-items:center; gap: 40px;">
                <div style="flex:1;">
                    <h2 class="section-title" style="margin-bottom: 1.5rem; text-align:left;">Cara Baru Nonton Bioskop</h2>
                    <p style="color: var(--text-muted); font-size: 1.1rem; margin-bottom: 2rem;">
                        Lupakan antrean panjang. Dengan <strong>Bookingin</strong>, kursi favorit Anda hanya berjarak satu klik. 
                        Kami menyediakan integrasi langsung dengan bioskop terkemuka untuk memastikan kenyamanan Anda.
                    </p>
                    <a href="{{ route('movies') }}" style="color: var(--brand-blue); text-decoration:none; font-weight:700; display:flex; align-items:center; gap:10px;">
                        Lihat Semua Film <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
                </div>
        </section>

        <section class="section">
            <div class="section-header">
                <h2 class="section-title">Kenapa Bookingin?</h2>
            </div>

            <div class="features-grid">
                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-bolt"></i></div>
                    <h3>Cepat & Instan</h3>
                    <p>Proses pemesanan yang dioptimalkan agar Anda mendapatkan tiket kurang dari 1 menit.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-couch"></i></div>
                    <h3>Pilih Kursi Sendiri</h3>
                    <p>Visualisasi denah kursi yang akurat memudahkan Anda memilih spot menonton terbaik.</p>
                </div>

                <div class="feature-item">
                    <div class="feature-icon"><i class="fa-solid fa-shield-halved"></i></div>
                    <h3>Transaksi Aman</h3>
                    <p>Didukung oleh gateway pembayaran terpercaya dengan enkripsi keamanan tingkat tinggi.</p>
                </div>
            </div>
        </section>

    </main>

    <footer>
        <p style="color: var(--text-muted); font-size: 0.9rem;">
            © 2025 Bookingin. Dibuat dengan <i class="fa-solid fa-heart" style="color: var(--brand-red);"></i> untuk pecinta film.
        </p>
    </footer>

    <script>
        // Tab Functionality
        function showTab(type) {
            const nowShowing = document.getElementById('nowShowing');
            const upcoming = document.getElementById('upcomingMovies');
            const tabs = document.querySelectorAll('.tab');
            
            // Reset Active State
            tabs.forEach(t => t.classList.remove('active'));

            if (type === 'now') {
                nowShowing.classList.remove('hidden');
                upcoming.classList.add('hidden');
                tabs[0].classList.add('active');
            } else {
                nowShowing.classList.add('hidden');
                upcoming.classList.remove('hidden');
                tabs[1].classList.add('active');
            }
        }

        // Carousel Scroll Functionality
        function scrollMovies(containerId, direction) {
            const container = document.getElementById(containerId);
            const scrollAmount = 300; // Jarak scroll
            
            if (direction === 1) {
                container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
            } else {
                container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });
            }
        }
    </script>
</body>
</html>