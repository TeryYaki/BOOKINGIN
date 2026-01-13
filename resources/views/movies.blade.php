<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movies – Bookingin</title>

    <style>
        :root {
            --primary-bg: #111;
            --secondary-bg: #1b1b1b;
            --hover-bg: #262626;
            --text-color: white;
            --accent-color: #444;
            --blue: #3b82f6;
            --blue-dark: #2563eb;
        }

        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background: var(--primary-bg);
            color: var(--text-color);
        }

        /* NAVBAR */
        header.navbar {
            background: black;
            padding: 0.6rem 2rem;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 100;
            box-shadow: 0 2px 5px rgba(0,0,0,0.5);
        }

        .navbar-content {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar .logo {
            font-size: 1.2rem;
            font-weight: bold;
            letter-spacing: 2px;
        }

        .navbar nav {
            display: flex;
            gap: 2rem;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            font-weight: 500;
            transition: color .3s ease, transform .2s ease;
            font-size: 0.9rem;
        }

        .navbar a:hover {
            color: var(--blue);
            transform: translateY(-1px);
        }

        .navbar .right {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .search-bar input {
            padding: 0.5rem 0.8rem;
            width: 180px;
            border-radius: 8px;
            border: 1px solid var(--accent-color);
            background: var(--secondary-bg);
            color: white;
            font-size: 0.85rem;
            transition: border-color 0.3s ease;
            height: 36px;
        }

        .search-bar input:focus {
            outline: none;
            border-color: var(--blue);
        }

        /* ============================
           🔥 TOMBOL PREMIUM (FINAL)
           ============================ */
        .btn-primary,
        .btn-outline {
            padding: 0.4rem 1.1rem;
            font-size: 0.85rem;
            border-radius: 8px;
            font-weight: 600;
            letter-spacing: 0.3px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: 0.25s ease;
            height: 36px;
        }

        /* DAFTAR (solid) */
        .btn-primary {
            background: var(--blue);
            border: 1px solid var(--blue);
            color: white;
            box-shadow: 0 2px 5px rgba(59,130,246,0.35);
        }

        .btn-primary:hover {
            background: var(--blue-dark);
            border-color: var(--blue-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(59,130,246,0.45);
        }

        /* LOGIN (outline) */
        .btn-outline {
            background: transparent;
            border: 1.5px solid var(--blue);
            color: var(--blue);
        }

        .btn-outline:hover {
            background: var(--blue);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 10px rgba(59,130,246,0.45);
        }

        /* Responsive navbar */
        @media (max-width: 768px) {
            .navbar-content {
                flex-direction: column;
                gap: 1rem;
            }

            .navbar .right {
                flex-wrap: wrap;
                justify-content: center;
            }

            .btn-primary, .btn-outline {
                flex: 1;
                text-align: center;
            }
        }

        /* Tabs */
        .tabs {
            display: flex;
            justify-content: center;
            gap: 2.5rem;
            margin-top: 65px;
            padding-bottom: 1rem;
            border-bottom: 1px solid var(--accent-color);
        }

        .tabs span {
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 600;
            color: #888;
            padding: 0.5rem 1rem;
            transition: .3s;
        }

        .tabs span.active {
            border-bottom: 3px solid var(--blue);
            color: white;
        }

        /* Movies */
        .movie-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: auto;
        }

        .movie-card {
            background: var(--secondary-bg);
            border-radius: 10px;
            overflow: hidden;
            transition: .3s;
        }

        .movie-card:hover {
            transform: scale(1.03);
            background: var(--hover-bg);
        }

        .poster {
            position: relative;
            width: 100%;
            height: 350px;
        }

        .poster img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .book-btn {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            padding: 10px 20px;
            background: var(--blue);
            color: white;
            font-size: 14px;
            border-radius: 8px;
            font-weight: bold;
            opacity: 0;
            transition: 0.3s;
            pointer-events: none;
        }

        .poster:hover .book-btn {
            opacity: 1;
            pointer-events: auto;
            background: var(--blue-dark);
        }

        .movie-info {
            padding: 1rem;
        }

        .genre {
            font-size: 12px;
            opacity: 0.7;
            color: #888;
        }

        .movie-info h3 {
            margin: 0.5rem 0;
            font-size: 18px;
        }

        footer {
            background: black;
            padding: 1.5rem;
            text-align: center;
            color: #888;
        }

        .hidden { display: none; }
    </style>
</head>

<body>

<header class="navbar">
    <div class="navbar-content">

        <div class="logo">BOOKINGIN</div>

        <nav>
            <a href="/">Beranda</a>
            <a href="/movies">Movies</a>
        </nav>

        <div class="right">
            <div class="search-bar">
                <input type="text" placeholder="Cari film...">
            </div>
            <a class="btn-outline" href="{{ route('login') }}">Login</a>
            <a class="btn-primary" href="{{ route('register') }}">Daftar</a>
        </div>

    </div>
</header>

<div class="tabs">
    <span class="active" onclick="showTab('now')">NOW SHOWING</span>
    <span onclick="showTab('upcoming')">UPCOMING</span>
</div>

<div class="movie-grid" id="nowShowing">
    <!-- Film Now Showing -->
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/or06FN3Dka5tukK1e9sl16pB3iy.jpg" alt="Avengers: Endgame">
            <a href="{{ route('film') }}" class="book-btn">Book Now</a>
        </div>
        <div class="movie-info">
            <div class="genre">Action, Adventure, Sci-Fi</div>
            <h3>Avengers: Endgame</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/udDclJoHjfjb8Ekgsd4FDteOkCU.jpg" alt="Joker">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Crime, Drama, Thriller</div>
            <h3>Joker</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/h6Wi81XNXCjTAcdstiCLRykN3Pa.jpg" alt="Frozen II">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Animation, Adventure, Family</div>
            <h3>Frozen II</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/7IiTTgloJzvGI1TAYymCfbfl3vT.jpg" alt="Parasite">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Animation, Action, Adventure</div>
            <h3>Parasite</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/4q2NNj4S5dG2RLF9CpXsej7yXl.jpg" alt="Spider Man: Far From Home">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Animation, Adventure, Drama</div>
            <h3>Spider Man: Far From Home</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/3kcEGnYBHDeqmdYf8ZRbKdfmlUy.jpg" alt="Fifty Shades of Grey>
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Comedy, Thriller, Drama</div>
            <h3>Fifty Shades of Grey</h3>
        </div>
    </div>
</div>

<div class="movie-grid hidden" id="upcomingMovies">
    <!-- Film Upcoming -->
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/kyeqWdyUXW608qlYkRqosgbbJyK.jpg" alt="Avatar: The Way of Water">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Action, Adventure, Fantasy</div>
            <h3>Avatar: The Way of Water</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/d5NXSklXo0qyIYkgV94XAgMIckC.jpg" alt="Dune">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Action, Drama, Sci-Fi</div>
            <h3>Dune</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/1g0dhYtq4irTY1GPXvft6k4YLjm.jpg" alt="Black Panther: Wakanda Forever">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Action, Adventure, Drama</div>
            <h3>Black Panther: Wakanda Forever</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/8Gxv8gSFCU0XGDykEGv7zR1n2z.jpg" alt="Guardians of the Galaxy Vol. 3">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Action, Adventure, Comedy</div>
            <h3>Guardians of the Galaxy Vol. 3</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/6oom5QYQ2yQTMJIbnvbkBL9cHo6.jpg" alt="The Batman">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Crime, Drama, Action</div>
            <h3>The Batman</h3>
        </div>
    </div>
    <div class="movie-card">
        <div class="poster">
            <img src="https://image.tmdb.org/t/p/w500/7q448EVOnuE3gVAx24krzO7SNXM.jpg" alt="Doctor Strange in the Multiverse of Madness">
            <button class="book-btn">Book Now</button>
        </div>
        <div class="movie-info">
            <div class="genre">Action, Adventure, Fantasy</div>
            <h3>Doctor Strange in the Multiverse of Madness</h3>
        </div>
    </div>
</div>

<footer>
    <p>© 2025 Bookingin. Semua hak cipta dilindungi.</p>
</footer>

<script>
function showTab(type) {
    document.querySelectorAll(".tabs span").forEach(t => t.classList.remove("active"));
    document.querySelectorAll(".movie-grid").forEach(g => g.classList.add("hidden"));

    if (type === "now") {
        document.querySelector(".tabs span:nth-child(1)").classList.add("active");
        document.getElementById("nowShowing").classList.remove("hidden");
    } else {
        document.querySelector(".tabs span:nth-child(2)").classList.add("active");
        document.getElementById("upcomingMovies").classList.remove("hidden");
    }
}
</script>

</body>
</html>
