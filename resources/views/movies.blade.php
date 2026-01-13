<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Film – Bookingin</title>
    <style>
        body { margin: 0; font-family: Arial, sans-serif; background: #111; color: white; }
        
        /* Navbar (Sama dengan Main) */
        .navbar { display: flex; justify-content: space-between; align-items: center; background: black; padding: 1rem 2rem; position: fixed; width: 100%; top: 0; z-index: 100; box-sizing: border-box; }
        .navbar a { color: white; text-decoration: none; font-weight: bold; margin-left: 20px; }
        .navbar a:hover { color: #3b82f6; }

        /* Grid Film */
        .container { max-width: 1200px; margin: 100px auto 50px auto; padding: 0 20px; }
        .page-title { font-size: 2rem; border-bottom: 2px solid #333; padding-bottom: 10px; margin-bottom: 30px; }
        
        .movies-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 30px;
            justify-items: center;
        }

        .movie-card {
            width: 200px; background: #1b1b1b; border-radius: 10px; overflow: hidden;
            transition: transform 0.3s; box-shadow: 0 4px 10px rgba(0,0,0,0.5);
            position: relative;
        }
        .movie-card:hover { transform: translateY(-5px); }

        .poster-box { width: 100%; height: 300px; position: relative; }
        .poster-box img { width: 100%; height: 100%; object-fit: fill; } /* Gambar Full */
        
        .movie-info { padding: 15px; text-align: center; }
        .movie-title { font-weight: bold; margin-bottom: 5px; font-size: 1rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .movie-status { font-size: 0.8rem; color: #aaa; margin-bottom: 10px; }
        
        .btn-book {
            display: block; width: 100%; padding: 10px 0; background: #3b82f6; color: white;
            text-decoration: none; border-radius: 5px; font-weight: bold; font-size: 0.9rem;
        }
        .btn-book:hover { background: #2563eb; }
        .btn-disabled { background: #555; cursor: default; }

        /* User Profile */
        .user-menu { display: flex; align-items: center; gap: 10px; }
        .user-avatar { width: 30px; height: 30px; border-radius: 50%; border: 1px solid #3b82f6; }
    </style>
</head>
<body>

    <nav class="navbar">
        <div style="font-size:1.5rem; font-weight:bold;">BOOKINGIN</div>
        <div>
            <a href="{{ route('home') }}">Beranda</a>
            <a href="{{ route('movies') }}" style="color:#3b82f6;">Movies</a>
            
            @auth
                <span style="margin-left:20px; color:#ddd;">Halo, {{ Auth::user()->name }}</span>
            @else
                <a href="{{ route('login') }}" style="background:#e50914; padding:5px 15px; border-radius:5px;">Masuk</a>
            @endauth
        </div>
    </nav>

    <div class="container">
        <h1 class="page-title">Semua Film</h1>
        
        <div class="movies-grid">
            @forelse($movies as $movie)
                <div class="movie-card">
                    <div class="poster-box">
                        <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}">
                    </div>
                    <div class="movie-info">
                        <div class="movie-title">{{ $movie->title }}</div>
                        <div class="movie-status">
                            {{ $movie->status == 'now_showing' ? 'Sedang Tayang' : 'Segera Tayang' }}
                        </div>
                        
                        @if($movie->status == 'now_showing')
                            <a href="{{ route('film', $movie->id) }}" class="btn-book">Book Now</a>
                        @else
                            <a href="#" class="btn-book btn-disabled">Coming Soon</a>
                        @endif
                    </div>
                </div>
            @empty
                <p style="text-align:center; col-span:4;">Belum ada film yang tersedia.</p>
            @endforelse
        </div>
    </div>

</body>
</html>