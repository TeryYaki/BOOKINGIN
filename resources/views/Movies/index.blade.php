<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Film - Bookingin</title>
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
        /* Global Styles dari Main Page */
        body {
            background-color: #0a0a0a;
            color: #ffffff;
            font-family: 'Roboto', sans-serif;
        }
        h1, h2, h3 { font-family: 'Montserrat', sans-serif; }

        /* Navbar Style */
        .navbar-glass {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s;
        }
        .nav-link::after {
            content: '';
            position: absolute; width: 0; height: 2px;
            bottom: -5px; left: 0;
            background: #3b82f6; transition: all 0.3s;
        }
        .nav-link:hover::after, .nav-link.active::after { width: 100%; }

        /* Custom Form Elements */
        .dark-input {
            background-color: #0a0a0a;
            border: 1px solid #333;
            color: white;
            transition: all 0.3s;
        }
        .dark-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }

        /* Movie Card Hover */
        .movie-card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .movie-card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }
    </style>
</head>
<body class="bg-primary min-h-screen flex flex-col">

    @include('components.navbar')

    <div class="pt-24 pb-12 flex-grow container mx-auto px-4 max-w-6xl">
        
        <div class="mb-10">
            <h1 class="text-4xl font-bold mb-6 text-white border-b border-gray-800 pb-4">
                Jelajahi Film
            </h1>

            <div class="bg-card p-6 rounded-2xl shadow-lg border border-gray-800">
                <form action="{{ route('movies.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                    
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-textMuted uppercase tracking-wider mb-2">Cari Judul</label>
                        <div class="relative">
                            <i class="fa-solid fa-search absolute left-4 top-3.5 text-gray-500"></i>
                            <input type="text" name="q" value="{{ request('q') }}" 
                                   placeholder="Avengers, Spiderman..." 
                                   class="dark-input w-full rounded-xl py-3 pl-10 pr-4">
                        </div>
                    </div>

                    <div class="w-full md:w-1/3">
                        <label class="block text-xs font-bold text-textMuted uppercase tracking-wider mb-2">Lokasi Bioskop</label>
                        <div class="relative">
                            <i class="fa-solid fa-location-dot absolute left-4 top-3.5 text-gray-500"></i>
                            <select name="location" class="dark-input w-full rounded-xl py-3 pl-10 pr-10 appearance-none cursor-pointer">
                                <option value="">Semua Kota</option>
                                @foreach($cities as $city)
                                    <option value="{{ $city }}" {{ request('location') == $city ? 'selected' : '' }}>
                                        {{ $city }}
                                    </option>
                                @endforeach
                            </select>
                            <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-gray-500 pointer-events-none"></i>
                        </div>
                    </div>

                    <div class="flex items-end">
                        <button type="submit" class="bg-brandBlue hover:bg-blue-600 text-white font-bold px-8 py-3 rounded-xl transition shadow-lg w-full md:w-auto">
                            Filter
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($movies->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($movies as $movie)
                    <div class="bg-card rounded-2xl overflow-hidden border border-gray-800 movie-card-hover flex flex-col h-full group">
                        <div class="relative aspect-[2/3] overflow-hidden bg-gray-900">
                            @if($movie->poster_path)
                                <img src="{{ asset($movie->poster_path) }}" alt="{{ $movie->title }}" 
                                     class="w-full h-full object-cover transition duration-500 group-hover:scale-110 group-hover:opacity-70">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-gray-600">
                                    <i class="fa-solid fa-image text-4xl"></i>
                                </div>
                            @endif

                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300">
                                <a href="{{ route('film', $movie->id) }}" class="bg-brandBlue text-white font-bold py-2 px-6 rounded-full shadow-lg transform translate-y-4 group-hover:translate-y-0 transition">
                                    Book Now
                                </a>
                            </div>
                        </div>
                        
                        <div class="p-4 flex flex-col flex-grow">
                            <h3 class="text-lg font-heading font-bold text-white mb-1 line-clamp-1 group-hover:text-blue-400 transition">
                                {{ $movie->title }}
                            </h3>
                            
                            <div class="flex items-center gap-2 text-xs text-textMuted mb-3">
                                <span class="bg-secondary px-2 py-0.5 rounded border border-gray-700">2D</span>
                                <span>{{ $movie->duration ?? '120m' }}</span>
                            </div>

                            <p class="text-sm text-gray-400 line-clamp-2 mb-4 flex-grow">
                                {{ $movie->description ?? 'Sinopsis belum tersedia.' }}
                            </p>
                            
                            <div class="border-t border-gray-800 pt-3 mt-auto">
                                <div class="flex items-start gap-2">
                                    <i class="fa-solid fa-map-marker-alt text-brandBlue text-xs mt-0.5"></i>
                                    <div class="text-xs text-gray-300">
                                        @php
                                            $locations = $movie->showtimes->map(fn($s) => $s->studio->city)->unique();
                                        @endphp

                                        @if($locations->isNotEmpty())
                                            {{ $locations->take(2)->implode(', ') }}
                                            @if($locations->count() > 2)
                                                <span class="text-gray-500">+{{ $locations->count() - 2 }} lainnya</span>
                                            @endif
                                        @else
                                            <span class="text-gray-600 italic">Belum ada jadwal</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{-- {{ $movies->links() }} --}} 
                </div>

        @else
            <div class="text-center py-20 bg-card rounded-2xl border border-gray-800 border-dashed">
                <div class="mb-4">
                    <i class="fa-solid fa-film text-6xl text-gray-700"></i>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Film Tidak Ditemukan</h3>
                <p class="text-gray-500">Coba cari dengan kata kunci lain atau ubah filter lokasi.</p>
                <a href="{{ route('movies.index') }}" class="inline-block mt-4 text-brandBlue hover:text-white transition">
                    Reset Filter
                </a>
            </div>
        @endif
    </div>

    <footer class="bg-[#050505] py-8 text-center border-t border-gray-900 mt-auto">
        <p class="text-sm text-textMuted">
            © 2025 Bookingin. Dibuat dengan <i class="fa-solid fa-heart text-brandRed mx-1"></i> untuk pecinta film.
        </p>
    </footer>

</body>
</html>