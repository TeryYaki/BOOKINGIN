<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Jadwal Massal - Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;700;800&family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
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
            border-color: #22c55e;
            outline: none;
            box-shadow: 0 0 0 2px rgba(34, 197, 94, 0.3);
        }
        ::-webkit-calendar-picker-indicator {
            filter: invert(1);
            cursor: pointer;
        }
    </style>
</head>
<body class="min-h-screen py-10 px-4 flex flex-col items-center">

    <div class="w-full max-w-5xl animate-fade-in-up" x-data="{ 
        schedules: [],
        gen: { movie_id: '', studio_id: '', start_date: '', end_date: '', price: 45000, times: ['12:00', '15:00', '18:00', '21:00'] },
        
        addGenTime() { this.gen.times.push('') },
        removeGenTime(index) { this.gen.times.splice(index, 1) },
        
        generateSchedules() {
            if (!this.gen.movie_id || !this.gen.studio_id || !this.gen.start_date || !this.gen.end_date) {
                alert('Mohon lengkapi Data Generator (Film, Studio, dan Tanggal) terlebih dahulu!');
                return;
            }

            let start = new Date(this.gen.start_date);
            let end = new Date(this.gen.end_date);

            while (start <= end) {
                let y = start.getFullYear();
                let m = String(start.getMonth() + 1).padStart(2, '0');
                let d = String(start.getDate()).padStart(2, '0');
                let dateStr = `${y}-${m}-${d}`;

                this.gen.times.forEach(time => {
                    if (time) {
                        this.schedules.push({
                            movie_id: this.gen.movie_id,
                            studio_id: this.gen.studio_id,
                            date: dateStr,
                            start_time: time,
                            price: this.gen.price
                        });
                    }
                });
                start.setDate(start.getDate() + 1);
            }
        }
    }">
        
        <div class="flex items-center justify-between mb-8 pb-4">
            <div>
                <h2 class="text-3xl font-heading font-bold text-white">Atur Jadwal Massal</h2>
                <p class="text-sm text-textMuted mt-1">Generate dan kelola jadwal tayang secara efisien</p>
            </div>
            <div class="bg-green-500/10 p-4 rounded-full border border-green-500/20">
                <i class="fa-solid fa-calendar-days text-green-500 text-2xl"></i>
            </div>
        </div>

        <div class="glass-card rounded-2xl shadow-xl p-6 mb-8 border border-green-900/30">
            <h3 class="text-lg font-bold text-green-400 mb-4 font-heading flex items-center">
                <i class="fa-solid fa-wand-magic-sparkles mr-2"></i> Generator Otomatis
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-4">
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Pilih Film</label>
                    <select x-model="gen.movie_id" class="form-input w-full rounded-xl py-2 px-3 text-sm cursor-pointer">
                        <option value="" disabled selected>-- Pilih Film --</option>
                        @foreach($movies as $movie)
                            <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Pilih Studio</label>
                    <select x-model="gen.studio_id" class="form-input w-full rounded-xl py-2 px-3 text-sm cursor-pointer">
                        <option value="" disabled selected>-- Pilih Studio --</option>
                        @foreach($studios as $studio)
                            <option value="{{ $studio->id }}">{{ $studio->name }} - {{ $studio->city }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Dari Tanggal</label>
                    <input type="date" x-model="gen.start_date" class="form-input w-full rounded-xl py-2 px-3 text-sm">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-400 mb-1">Sampai Tanggal</label>
                    <input type="date" x-model="gen.end_date" class="form-input w-full rounded-xl py-2 px-3 text-sm">
                </div>
            </div>

            <div class="mb-5 bg-[#161616] p-4 rounded-xl border border-gray-800">
                <label class="block text-xs font-medium text-gray-400 mb-2">Jam Tayang (Slot Waktu per Hari)</label>
                <div class="flex flex-wrap gap-3 items-center">
                    <template x-for="(time, tIndex) in gen.times" :key="tIndex">
                        <div class="flex items-center bg-primary border border-gray-700 rounded-lg overflow-hidden">
                            <input type="time" x-model="gen.times[tIndex]" class="bg-transparent text-sm py-1.5 px-2 focus:outline-none text-white">
                            <button type="button" @click="removeGenTime(tIndex)" class="bg-red-500/10 hover:bg-red-500/20 text-red-500 px-3 py-1.5 transition">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                    </template>
                    <button type="button" @click="addGenTime()" class="border border-dashed border-gray-600 text-gray-400 hover:text-white hover:border-gray-400 px-3 py-1.5 rounded-lg text-sm transition">
                        <i class="fa-solid fa-plus mr-1"></i> Jam
                    </button>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center pt-4 border-t border-gray-800 gap-4">
                <div class="flex items-center w-full sm:w-auto">
                    <label class="text-xs font-medium text-gray-400 mr-3 whitespace-nowrap">Harga Tiket:</label>
                    <div class="relative w-full sm:w-40">
                        <span class="absolute left-3 top-1.5 text-gray-500 text-sm">Rp</span>
                        <input type="number" x-model="gen.price" class="form-input w-full rounded-lg py-1.5 pl-8 pr-3 text-sm">
                    </div>
                </div>
                <button type="button" @click="generateSchedules()" class="w-full sm:w-auto bg-gray-800 hover:bg-gray-700 text-white font-medium text-sm py-2 px-6 rounded-xl border border-gray-700 transition shadow-lg">
                    <i class="fa-solid fa-bolt text-yellow-400 mr-2"></i> Generate ke Daftar
                </button>
            </div>
        </div>

        <form action="{{ route('showtime.store') }}" method="POST">
            @csrf
            
            <div x-show="schedules.length === 0" class="glass-card rounded-2xl p-12 text-center border-dashed border-gray-700">
                <i class="fa-regular fa-folder-open text-4xl text-gray-600 mb-4"></i>
                <p class="text-gray-400">Belum ada jadwal yang di-generate. Gunakan panel di atas atau tambah baris manual.</p>
            </div>

            <div class="space-y-4">
                <template x-for="(row, index) in schedules" :key="index">
                    <div class="glass-card p-5 rounded-2xl relative border border-gray-800 hover:border-gray-600 transition group">
                        
                        <div class="absolute top-4 right-4 flex gap-2 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 transition-opacity z-10">
                            <button type="button" @click="schedules.push({ ...row })" class="bg-gray-800 hover:bg-gray-700 w-8 h-8 rounded-lg flex items-center justify-center text-green-400 transition" title="Duplikat">
                                <i class="fa-solid fa-copy text-xs"></i>
                            </button>
                            <button type="button" @click="schedules.splice(index, 1)" class="bg-gray-800 hover:bg-red-900/50 w-8 h-8 rounded-lg flex items-center justify-center text-red-400 transition" title="Hapus">
                                <i class="fa-solid fa-trash text-xs"></i>
                            </button>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Film</label>
                                <select :name="'schedules['+index+'][movie_id]'" x-model="row.movie_id" required class="form-input w-full rounded-xl py-2 px-3 text-sm cursor-pointer">
                                    <option value="" disabled>-- Pilih Film --</option>
                                    @foreach($movies as $movie)
                                        <option value="{{ $movie->id }}">{{ $movie->title }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Studio</label>
                                <select :name="'schedules['+index+'][studio_id]'" x-model="row.studio_id" required class="form-input w-full rounded-xl py-2 px-3 text-sm cursor-pointer">
                                    <option value="" disabled>-- Pilih Studio --</option>
                                    @foreach($studios as $studio)
                                        <option value="{{ $studio->id }}">{{ $studio->name }} - {{ $studio->city }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-1 gap-4 md:col-span-1">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal</label>
                                    <input type="date" :name="'schedules['+index+'][date]'" x-model="row.date" required class="form-input w-full rounded-xl py-2 px-3 text-sm">
                                </div>
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-2 gap-4 md:col-span-2">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Jam Mulai</label>
                                    <input type="time" :name="'schedules['+index+'][start_time]'" x-model="row.start_time" required class="form-input w-full rounded-xl py-2 px-3 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Harga (Rp)</label>
                                    <input type="number" :name="'schedules['+index+'][price]'" x-model="row.price" required class="form-input w-full rounded-xl py-2 px-3 text-sm">
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 mt-8 pt-6 border-t border-gray-800">
                <a href="{{ route('admin.dashboard') }}" class="w-full sm:w-1/4 text-center py-3 rounded-xl border border-gray-700 hover:bg-white/5 transition text-gray-400 font-semibold text-sm">
                    <i class="fa-solid fa-arrow-left mr-2"></i> Kembali
                </a>
                <button type="button" @click="schedules.push({ movie_id: '', studio_id: '', date: '', start_time: '', price: 45000 })" class="w-full sm:w-1/3 text-center py-3 rounded-xl border border-dashed border-gray-600 hover:bg-white/5 transition text-gray-300 font-medium text-sm">
                    <i class="fa-solid fa-plus mr-2"></i> Tambah Baris Manual
                </button>
                <button type="submit" x-show="schedules.length > 0" class="w-full sm:flex-grow bg-gradient-to-r from-green-600 to-green-500 hover:from-green-500 hover:to-green-400 text-white font-bold py-3 rounded-xl shadow-lg shadow-green-900/20 transform hover:-translate-y-1 transition duration-200 text-sm">
                    <i class="fa-solid fa-save mr-2"></i> Simpan <span x-text="schedules.length"></span> Jadwal ke Database
                </button>
            </div>

        </form>
    </div>

</body>
</html>