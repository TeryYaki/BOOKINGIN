<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Film – Bookingin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* --- GLOBAL VARIABLES & RESET --- */
        body { margin: 0; font-family: 'Arial', sans-serif; background: #111; color: white; }
        
        /* --- NAVBAR (Sama Persis dengan Main/Profile) --- */
        .navbar { 
            display: flex; justify-content: space-between; align-items: center; 
            background: rgba(0,0,0,0.9); padding: 1rem 2rem; 
            position: fixed; width: 100%; top: 0; z-index: 100; 
            box-sizing: border-box; border-bottom: 1px solid #333; 
        }
        .navbar .logo { font-size: 1.5rem; font-weight: bold; letter-spacing: 2px; }
        .navbar nav { display: flex; align-items: center; gap: 20px; }
        .navbar a { color: white; text-decoration: none; font-weight: 500; transition: 0.3s; }
        .navbar a:hover { color: #3b82f6; }

        /* User Menu di Navbar */
        .user-menu { display: flex; align-items: center; gap: 15px; padding-left: 15px; border-left: 1px solid #333; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; border: 2px solid #3b82f6; }
        .user-name { font-weight: bold; font-size: 14px; color: white; text-decoration: none; }
        .user-name:hover { color: #3b82f6; text-decoration: underline; }
        
        .btn-logout { 
            background: #ef4444; color: white; border: none; padding: 6px 15px; 
            border-radius: 5px; cursor: pointer; font-weight: bold; transition: 0.3s; 
        }
        .btn-logout:hover { background: #dc2626; }
        .btn-login { 
            background: #3b82f6; padding: 8px 20px; border-radius: 5px; 
            color: white !important; font-weight: bold; 
        }

        /* --- CONTENT GRID --- */
        .container { max-width: 1200px; margin: 100px auto 50px auto; padding: 0 20px; }
        .page-title { 
            font-size: 2rem; border-bottom: 2px solid #333; padding-bottom: 15px; margin-bottom: 30px; 
            display: flex; align-items: center; gap: 15px;
        }
        
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            justify-items: center;
        }

        .movie-card {
            width: 200px; background: #1b1b1b; border-radius: 10px; overflow: hidden;
            transition: transform 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            position: relative; border: 1px solid #333;
        }
        .movie-card:hover { transform: translateY(-5px); border-color: #3b82f6; }

        .poster-box { width: 100%; height: 300px; position: relative; }
        .poster-box img { width: 100%; height: 100%; object-fit: fill; } /* Gambar Full */
        
        .movie-info { padding: 15px; text-align: center; }
        .movie-title { 
            font-weight: bold; margin-bottom: 5px; font-size: 1rem; 
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis; 
        }
        .movie-status { font-size: 0.8rem; color: #aaa; margin-bottom: 15px; }
        
        .btn-book {
            display: block; width: 100%; padding: 10px 0; background: #3b82f6; color: white;
            text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 0.9rem;
            transition: 0.2s;
        }
        .btn-book:hover { background: #2563eb; }
        .btn-disabled { background: #444; cursor: not-allowed; color: #888; }
        .btn-disabled:hover { background: #444; }
    </style>
</head>
<body>

    <header class="navbar">
        <div class="logo">BOOKINGIN</div>
        <nav>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('movies') }}" style="color:#3b82f6;">Movies</a>

            @guest
                <a href="{{ route('login') }}" class="btn-login">Masuk</a>
            @endguest

            @auth
                <div class="user-menu">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff" class="user-avatar" alt="Avatar">
                    
                    <a href="{{ route('profile') }}" class="user-name">
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

    <div class="container">
        <h1 class="page-title"><i class="fa-solid fa-film"></i> Semua Film</h1>
        
        <div class="movies-grid">
            @forelse($movies as $movie)
                <div class="movie-card">
                    <div class="poster-box">
                        <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}">
                    </div>
                    <div class="movie-info">
                        <div class="movie-title">{{ $movie->title }}</div>
                        <div class="movie-status">
                            @if($movie->status == 'now_showing')
                                <span style="color:#22c55e;">● Sedang Tayang</span>
                            @else
                                <span style="color:#eab308;">● Segera Tayang</span>
                            @endif
                        </div>
                        
                        @if($movie->status == 'now_showing')
                            <a href="{{ route('film', $movie->id) }}" class="btn-book">Book Now</a>
                        @else
                            <a href="#" class="btn-book btn-disabled">Coming Soon</a>
                        @endif
                    </div>
                </div>
            @empty
                <p style="text-align:center; grid-column: 1/-1; padding: 50px; color: #777;">
                    Belum ada film yang tersedia saat ini.
                </p>
            @endforelse
        </div>
    </div>

</body>
</html>