<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Jadwal - Admin Dashboard</title>
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
        body { background-color: #0a0a0a; color: #ffffff; font-family: 'Roboto', sans-serif; }
        .glass-card {
            background: rgba(31, 31, 31, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
        .form-input {
            background-color: #161616;
            border: 1px solid #333;
            color: white;
            transition: all 0.3s;
        }
        .form-input:focus {
            border-color: #3b82f6;
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
        /* Custom date/time picker icon color fix */
        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center py-10 px-4">

    <div class="glass-card w-full max-w-lg rounded-2xl shadow-2xl p-8 animate-fade-in-up">
        
        <div class="flex items-center justify-between mb-8 border-b border-gray-800 pb-4">
            <div>
                <h2 class="text-2xl font-heading font-bold text-white">Atur Jadwal</h2>
                <p class="text-sm text-textMuted">Tentukan waktu tayang film</p>
            </div>
            <div class="bg-green-500/10 p-3 rounded-full">
                <i class="fa-solid fa-clock text-green-500 text-xl"></i>
            </div>
        </div>

        <form action="{{ route('showtime.store') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Film</label>
                <div class="relative">
                    <i class="fa-solid fa-film absolute left-4 top-3.5 text-gray-500"></i>
                    <select name="movie_id" required class="form-input w-full rounded-xl py-3 pl-11 pr-10 appearance-none cursor-pointer">
                        <option value="" disabled selected>-- Pilih Judul Film --</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-gray-500 pointer-events-none"></i>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Pilih Studio</label>
                <div class="relative">
                    <i class="fa-solid fa-video absolute left-4 top-3.5 text-gray-500"></i>
                    <select name="studio_id" required class="form-input w-full rounded-xl py-3 pl-11 pr-10 appearance-none cursor-pointer">
                        <option value="" disabled selected>-- Pilih Lokasi Studio --</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}">{{ $studio->name }} - {{ $studio->city }}</option>
                        @endforeach
                    </select>
                    <i class="fa-solid fa-chevron-down absolute right-4 top-3.5 text-gray-500 pointer-events-none"></i>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Tanggal</label>
                    <div class="relative">
                        <input type="date" name="date" required 
                               class="form-input w-full rounded-xl py-3 px-4 text-sm">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Jam Mulai</label>
                    <div class="relative">
                        <input type="time" name="start_time" required 
                               class="form-input w-full rounded-xl py-3 px-4 text-sm">
                    </div>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-400 mb-2">Harga Tiket (Rp)</label>
                <div class="relative">
                    <i class="fa-solid fa-tag absolute left-4 top-3.5 text-gray-500"></i>
                    <input type="number" name="price" value="45000" required 
                           class="form-input w-full rounded-xl py-3 pl-11 pr-4" placeholder="45000">
                </div>
            </div>

            <div class="flex items-center gap-4 pt-4">
                <a href="{{ route('admin.dashboard') }}" class="w-1/3 text-center py-3 rounded-xl border border-gray-700 hover:bg-white/5 transition text-gray-400 font-semibold">
                    Batal
                </a>
                <button type="submit" class="w-2/3 bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-3 rounded-xl shadow-lg transform hover:-translate-y-1 transition duration-200">
                    <i class="fa-solid fa-save mr-2"></i> Simpan Jadwal
                </button>
            </div>

        </form>
    </div>

</body>
</html>