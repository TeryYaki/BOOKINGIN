<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Film Bioskop</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">

    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold mb-6 text-gray-800">Sedang Tayang</h1>

        <div class="bg-white p-6 rounded-lg shadow mb-8">
            <form action="{{ route('movies.index') }}" method="GET" class="flex flex-col md:flex-row gap-4">
                
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Cari Judul</label>
                    <input type="text" name="q" value="{{ request('q') }}" 
                           placeholder="Contoh: Avengers..." 
                           class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>

                <div class="w-full md:w-1/3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kota</label>
                    <select name="location" class="w-full border border-gray-300 rounded px-3 py-2 bg-white">
                        <option value="">Semua Kota</option>
                        @foreach($cities as $city)
                            <option value="{{ $city }}" {{ request('location') == $city ? 'selected' : '' }}>
                                {{ $city }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 w-full md:w-auto">
                        Filter
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($movies as $movie)
                <div class="bg-white rounded-lg shadow overflow-hidden hover:shadow-lg transition">
                    <div class="h-48 bg-gray-300 flex items-center justify-center">
                        <span class="text-gray-500">Poster Film</span>
                    </div>
                    
                    <div class="p-4">
                        <h3 class="text-xl font-bold mb-2">{{ $movie->title }}</h3>
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            {{ $movie->description ?? 'Tidak ada deskripsi.' }}
                        </p>
                        
                        <div class="border-t pt-2 mt-2">
                            <span class="text-xs font-semibold text-gray-500 uppercase">Tersedia di:</span>
                            <div class="text-sm text-blue-600 mt-1">
                                {{ $movie->showtimes->map(fn($s) => $s->studio->city)->unique()->implode(', ') }}
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-10 text-gray-500">
                    Film tidak ditemukan untuk pencarian ini.
                </div>
            @endforelse
        </div>
    </div>

</body>
</html>