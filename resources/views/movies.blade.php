<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Film – Bookingin</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@600;700;800&family=Roboto:wght@400;500&display=swap" rel="stylesheet">
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
            --glass: rgba(22, 22, 22, 0.8);
            --shadow: 0 10px 30px rgba(0,0,0,0.5);
            --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Roboto', sans-serif;
            background: url('images/the-premiere-1.jpg') no-repeat center center fixed;
            background-size: cover;
            color: var(--text-main);
            min-height: 100vh;
            display: flex; flex-direction: column;
        }

        /* Overlay Gelap Background */
        body::before {
            content: ''; position: fixed; inset: 0;
            background: rgba(10, 10, 10, 0.92);
            z-index: -1;
        }

        /* --- NAVBAR MODERN (Sama dengan Main Page) --- */
        header.navbar {
            display: flex; justify-content: space-between; align-items: center;
            background: rgba(10, 10, 10, 0.85); backdrop-filter: blur(12px);
            padding: 1rem 5%; position: fixed; top: 0; width: 100%;
            z-index: 1000; border-bottom: 1px solid rgba(255,255,255,0.05);
        }

        .navbar .logo {
            font-family: 'Montserrat', sans-serif; font-size: 1.8rem; font-weight: 800;
            background: var(--gradient-main); -webkit-background-clip: text; -webkit-text-fill-color: transparent;
            letter-spacing: 1px;
        }

        .navbar nav { display: flex; align-items: center; gap: 20px; }

        .nav-link {
            color: var(--text-muted); text-decoration: none; font-weight: 500; font-size: 0.95rem;
            transition: var(--transition); position: relative;
        }
        .nav-link:hover, .nav-link.active { color: var(--text-main); }
        .nav-link.active::after {
            content: ''; position: absolute; width: 100%; height: 2px;
            bottom: -5px; left: 0; background: var(--brand-blue);
        }

        /* Auth Buttons */
        .btn-auth { padding: 8px 20px; border-radius: 50px; font-size: 0.9rem; font-weight: 600; text-decoration: none; transition: var(--transition); }
        .btn-login { background: rgba(255,255,255,0.1); color: white; border: 1px solid rgba(255,255,255,0.1); }
        .btn-login:hover { background: white; color: black; }

        /* User Menu */
        .user-menu { display: flex; align-items: center; gap: 15px; border-left: 1px solid rgba(255,255,255,0.1); padding-left: 20px; }
        .user-info { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; border: 2px solid var(--brand-blue); }
        .user-name { font-weight: 600; font-size: 0.95rem; color: white; }
        .btn-logout { background: transparent; color: var(--text-muted); border: 1px solid rgba(255,255,255,0.1); padding: 6px 14px; border-radius: 6px; cursor: pointer; transition: var(--transition); }
        .btn-logout:hover { border-color: var(--brand-red); color: var(--brand-red); }

        /* --- CONTENT CONTAINER --- */
        .container {
            max-width: 1200px; margin: 120px auto 50px auto; padding: 0 2rem; flex: 1;
        }

        .page-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 40px; padding-bottom: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        .page-title { font-family: 'Montserrat', sans-serif; font-size: 2rem; font-weight: 700; display: flex; align-items: center; gap: 15px; }
        .page-title i { color: var(--brand-blue); }

        /* --- MOVIE GRID --- */
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 30px;
        }

        .movie-card {
            background: var(--card-bg);
            border-radius: 16px; overflow: hidden;
            box-shadow: 0 10px 20px rgba(0,0,0,0.3);
            transition: var(--transition);
            border: 1px solid rgba(255,255,255,0.05);
            display: flex; flex-direction: column;
        }

        .movie-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.5);
            border-color: rgba(59, 130, 246, 0.3);
        }

        .poster-box {
            position: relative; width: 100%; aspect-ratio: 2/3; overflow: hidden;
        }
        .poster-box img {
            width: 100%; height: 100%; object-fit: cover;
            transition: transform 0.5s ease;
        }
        .movie-card:hover .poster-box img { transform: scale(1.05); }

        /* Badge Status */
        .status-badge {
            position: absolute; top: 10px; right: 10px;
            padding: 5px 12px; border-radius: 20px;
            font-size: 0.75rem; font-weight: 700; text-transform: uppercase;
            backdrop-filter: blur(5px); box-shadow: 0 4px 10px rgba(0,0,0,0.3);
        }
        .status-now { background: rgba(34, 197, 94, 0.9); color: white; }
        .status-soon { background: rgba(234, 179, 8, 0.9); color: black; }

        .movie-info { padding: 20px; display: flex; flex-direction: column; flex: 1; }
        .movie-title {
            font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 700;
            margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }
        .movie-meta { font-size: 0.85rem; color: var(--text-muted); margin-bottom: 20px; }

        /* Buttons */
        .btn-action {
            margin-top: auto; display: block; width: 100%; padding: 12px;
            text-align: center; border-radius: 10px; font-weight: 600; text-decoration: none;
            transition: var(--transition);
        }
        
        .btn-book {
            background: var(--brand-blue); color: white;
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.3);
        }
        .btn-book:hover {
            background: var(--brand-blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(59, 130, 246, 0.5);
        }

        .btn-disabled {
            background: rgba(255,255,255,0.1); color: var(--text-muted);
            cursor: default; pointer-events: none;
        }

        /* Footer */
        footer {
            text-align: center; padding: 2rem; color: var(--text-muted); font-size: 0.9rem;
            border-top: 1px solid rgba(255,255,255,0.05); margin-top: 50px;
        }

        /* Mobile */
        @media (max-width: 768px) {
            .navbar { padding: 1rem; }
            .nav-link { display: none; } /* Simplicity for mobile */
            .movies-grid { grid-template-columns: repeat(2, 1fr); gap: 15px; }
            .container { padding: 0 1rem; }
            .page-title { font-size: 1.5rem; }
        }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">BOOKINGIN</div>
        <nav>
            <a href="{{ route('home') }}" class="nav-link">Beranda</a>
            <a href="{{ route('movies') }}" class="nav-link active">Movies</a>

            @guest
                <a href="{{ route('login') }}" class="btn-auth btn-login">Login</a>
            @endguest

            @auth
                <div class="user-menu">
                    <a href="{{ route('profile') }}" class="user-info">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff" class="user-avatar" alt="Avatar">
                        <span class="user-name">{{ Auth::user()->name }}</span>
                    </a>
                    
                    <form action="{{ route('logout') }}" method="POST" style="margin:0;">
                        @csrf
                        <button type="submit" class="btn-logout" title="Logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                        </button>
                    </form>
                </div>
            @endauth
        </nav>
    </header>

    <div class="container">
        <div class="page-header">
            <h1 class="page-title"><i class="fa-solid fa-clapperboard"></i> Daftar Film</h1>
            <span style="color: var(--text-muted);">Total: {{ $movies->count() }} Film</span>
        </div>
        
        <div class="movies-grid">
            @forelse($movies as $movie)
                <div class="movie-card">
                    <div class="poster-box">
                        <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}" loading="lazy">
                        
                        @if($movie->status == 'now_showing')
                            <div class="status-badge status-now">Now Showing</div>
                        @else
                            <div class="status-badge status-soon">Upcoming</div>
                        @endif
                    </div>

                    <div class="movie-info">
                        <div class="movie-title" title="{{ $movie->title }}">{{ $movie->title }}</div>
                        <div class="movie-meta">
                            {{ $movie->status == 'now_showing' ? 'Siap ditonton' : 'Segera hadir' }}
                        </div>
                        
                        @if($movie->status == 'now_showing')
                            <a href="{{ route('film', $movie->id) }}" class="btn-action btn-book">
                                Book Now
                            </a>
                        @else
                            <span class="btn-action btn-disabled">
                                Coming Soon
                            </span>
                        @endif
                    </div>
                </div>
            @empty
                <div style="grid-column: 1/-1; text-align: center; padding: 60px; color: var(--text-muted); background: var(--card-bg); border-radius: 16px;">
                    <i class="fa-regular fa-folder-open" style="font-size: 3rem; margin-bottom: 15px; display: block;"></i>
                    <p>Belum ada film yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

    <footer>
        <p>© 2025 Bookingin. Dibuat dengan <i class="fa-solid fa-heart" style="color: var(--brand-red);"></i> untuk pecinta film.</p>
    </footer>

</body>
</html>