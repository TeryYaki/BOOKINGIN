<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bookingin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
    </style>
</head>
<body class="bg-[#111] text-gray-200 font-sans min-h-screen">

    <nav class="bg-black border-b border-gray-800 sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <span class="text-2xl font-bold tracking-widest text-white">
                        BOOKINGIN <span class="text-blue-500 text-xs align-top">ADMIN</span>
                    </span>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2 text-sm text-gray-400">
                        <img src="https://ui-avatars.com/api/?name=Admin&background=3b82f6&color=fff" class="h-8 w-8 rounded-full border border-gray-600">
                        <span>Administrator</span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="bg-red-600 hover:bg-red-700 text-white px-3 py-1.5 rounded text-sm transition font-medium">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Keluar
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto py-10 px-4 sm:px-6 lg:px-8">
        
        @if(session('success'))
            <div class="bg-green-900/50 border border-green-600 text-green-200 px-4 py-3 rounded relative mb-6 flex items-center shadow-lg">
                <i class="fa-solid fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-[#1b1b1b] p-6 rounded-xl shadow-lg border-l-4 border-green-500 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Total Pendapatan</p>
                    <h3 class="text-3xl font-bold text-white mt-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <i class="fa-solid fa-money-bill-wave absolute right-4 bottom-4 text-green-500/10 text-6xl"></i>
            </div>

            <div class="bg-[#1b1b1b] p-6 rounded-xl shadow-lg border-l-4 border-blue-500 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Tiket Terjual</p>
                    <h3 class="text-3xl font-bold text-white mt-1">{{ $totalTickets }} <span class="text-sm font-normal text-gray-500">Transaksi</span></h3>
                </div>
                <i class="fa-solid fa-ticket absolute right-4 bottom-4 text-blue-500/10 text-6xl"></i>
            </div>

            <div class="bg-[#1b1b1b] p-6 rounded-xl shadow-lg border-l-4 border-purple-500 relative overflow-hidden">
                <div class="relative z-10">
                    <p class="text-gray-400 text-sm font-medium uppercase tracking-wider">Film Aktif</p>
                    <h3 class="text-3xl font-bold text-white mt-1">{{ $totalMovies }} <span class="text-sm font-normal text-gray-500">Judul</span></h3>
                </div>
                <i class="fa-solid fa-film absolute right-4 bottom-4 text-purple-500/10 text-6xl"></i>
            </div>
        </div>

        <div class="bg-[#1b1b1b] rounded-xl shadow-xl border border-gray-800 overflow-hidden mb-10">
            <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                <h2 class="text-xl font-bold text-white">
                    <i class="fa-solid fa-receipt mr-2 text-blue-500"></i> Laporan Transaksi Terbaru
                </h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm text-gray-400">
                    <thead class="bg-black text-gray-200 uppercase text-xs">
                        <tr>
                            <th class="px-6 py-4">Pelanggan</th>
                            <th class="px-6 py-4">Film</th>
                            <th class="px-6 py-4 text-center">Kursi</th>
                            <th class="px-6 py-4">Total Harga</th>
                            <th class="px-6 py-4">Tanggal Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-[#222] transition">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-blue-900/50 flex items-center justify-center text-blue-400 text-xs font-bold border border-blue-800">
                                    {{ substr($trx->user_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-white">{{ $trx->user_name }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $trx->region }}</div> </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-white">
                                {{ $trx->movie_title }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="bg-gray-800 px-2 py-1 rounded text-xs border border-gray-700">{{ $trx->seats }}</span>
                            </td>
                            <td class="px-6 py-4 text-green-400 font-mono font-bold">
                                Rp {{ number_format($trx->total_price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-4 text-xs text-gray-500">
                                {{ $trx->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                <i class="fa-regular fa-folder-open text-2xl mb-2 block opacity-50"></i>
                                Belum ada transaksi masuk dari Firebase.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($recentTransactions->hasPages())
            <div class="p-4 border-t border-gray-800">
                {{ $recentTransactions->links() }}
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="bg-[#1b1b1b] p-6 rounded-xl shadow-xl border border-gray-800 sticky top-24">
                    <h2 class="text-xl font-bold mb-6 text-white border-b border-gray-700 pb-2">
                        <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i> Tambah Film
                    </h2>
                    
                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Judul Film</label>
                            <input type="text" name="title" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 transition outline-none" placeholder="Contoh: Avengers: Endgame" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Status Tayang</label>
                            <select name="status" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                <option value="now_showing">🟢 Now Showing (Sedang Tayang)</option>
                                <option value="upcoming">🟡 Upcoming (Akan Datang)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi (Opsional)</label>
                            <textarea name="description" rows="3" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="Sinopsis singkat..."></textarea>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Poster Film</label>
                            <div class="relative border-2 border-dashed border-gray-700 bg-[#222] rounded-lg p-4 text-center hover:border-blue-500 transition group">
                                <input type="file" name="poster" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" required onchange="previewImage(event)">
                                <div class="space-y-1" id="upload-placeholder">
                                    <i class="fa-solid fa-cloud-arrow-up text-3xl text-gray-500 group-hover:text-blue-500 transition"></i>
                                    <p class="text-xs text-gray-400">Klik atau tarik gambar ke sini</p>
                                </div>
                                <img id="img-preview" class="hidden max-h-32 mx-auto rounded shadow-lg">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-blue-500/30 transition duration-300 flex justify-center items-center gap-2">
                            <i class="fa-solid fa-save"></i> Simpan Film
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[#1b1b1b] rounded-xl shadow-xl border border-gray-800 overflow-hidden">
                    <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white">
                            <i class="fa-solid fa-list mr-2 text-blue-500"></i> Daftar Film
                        </h2>
                        <span class="bg-blue-900/30 text-blue-400 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-800">
                            Total: {{ $movies->count() }} Film
                        </span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-400">
                            <thead class="bg-black text-gray-200 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4">Poster</th>
                                    <th class="px-6 py-4">Info Film</th>
                                    <th class="px-6 py-4 text-center">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse($movies as $movie)
                                <tr class="hover:bg-[#222] transition duration-200">
                                    <td class="px-6 py-4">
                                        <div class="h-20 w-14 rounded overflow-hidden shadow-md border border-gray-700 relative group">
                                            <img src="{{ asset($movie->poster_path) }}" alt="poster" class="h-full w-full object-cover group-hover:scale-110 transition duration-500">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white text-base mb-1">{{ $movie->title }}</div>
                                        <div class="text-xs text-gray-500 line-clamp-2">{{ $movie->description ?? '-' }}</div>
                                        <div class="text-[10px] text-gray-600 mt-1">Uploaded: {{ $movie->created_at->diffForHumans() }}</div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($movie->status == 'now_showing')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-green-900/30 text-green-400 border border-green-800">
                                                Showing
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-yellow-900/30 text-yellow-400 border border-yellow-800">
                                                Upcoming
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('admin.delete', $movie->id) }}" method="POST" onsubmit="return confirm('Hapus film ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-500 transition duration-300 p-2 rounded-full hover:bg-red-900/20" title="Hapus Film">
                                                <i class="fa-solid fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                        <i class="fa-regular fa-folder-open text-4xl mb-3 block opacity-50"></i>
                                        Belum ada data.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <footer class="mt-12 border-t border-gray-800 pt-6 text-center text-gray-600 text-sm">
            &copy; 2025 Bookingin Admin Panel. All rights reserved.
        </footer>
    </div>

    <script>
        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function(){
                const output = document.getElementById('img-preview');
                const placeholder = document.getElementById('upload-placeholder');
                output.src = reader.result;
                output.classList.remove('hidden');
                placeholder.classList.add('hidden');
            };
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
</body>
</html>