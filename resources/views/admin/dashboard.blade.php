<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Bookingin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 4px; }
        ::-webkit-scrollbar-thumb:hover { background: #555; }
        .animate-bounce-short { animation: bounce 1s 1; }
        @keyframes bounce {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-5px); }
        }
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
            <div class="bg-green-900/50 border border-green-600 text-green-200 px-4 py-3 rounded relative mb-6 flex items-center shadow-lg animate-bounce-short">
                <i class="fa-solid fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-10">
            <a href="{{ route('studio.create') }}" class="bg-[#1b1b1b] p-6 rounded-xl shadow-lg border border-gray-800 hover:border-blue-500 transition group flex items-center justify-between cursor-pointer">
                <div>
                    <h3 class="text-lg font-bold text-white group-hover:text-blue-500 transition"><i class="fa-solid fa-couch mr-2"></i> Manajemen Studio</h3>
                    <p class="text-sm text-gray-500 mt-1">Tambah studio baru dan atur layout kursi</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-blue-900/30 flex items-center justify-center text-blue-500 group-hover:bg-blue-600 group-hover:text-white transition">
                    <i class="fa-solid fa-arrow-right"></i>
                </div>
            </a>

            <a href="{{ route('showtime.create') }}" class="bg-[#1b1b1b] p-6 rounded-xl shadow-lg border border-gray-800 hover:border-green-500 transition group flex items-center justify-between cursor-pointer">
                <div>
                    <h3 class="text-lg font-bold text-white group-hover:text-green-500 transition"><i class="fa-regular fa-calendar-check mr-2"></i> Atur Jadwal Tayang</h3>
                    <p class="text-sm text-gray-500 mt-1">Set jadwal film ke studio tertentu</p>
                </div>
                <div class="h-10 w-10 rounded-full bg-green-900/30 flex items-center justify-center text-green-500 group-hover:bg-green-600 group-hover:text-white transition">
                    <i class="fa-solid fa-plus"></i>
                </div>
            </a>
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
                            <th class="px-6 py-4">Waktu Order</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800">
                        @forelse($recentTransactions as $trx)
                        <tr class="hover:bg-[#222] transition">
                            <td class="px-6 py-4 flex items-center gap-3">
                                <div class="h-8 w-8 rounded-full bg-blue-900/50 flex items-center justify-center text-blue-400 text-xs font-bold border border-blue-800">
                                    {{ substr($trx->user_name ?? 'U', 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-medium text-white">{{ $trx->user_name ?? 'User' }}</div>
                                    <div class="text-[10px] text-gray-500">{{ $trx->order_id }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 font-semibold text-white">{{ $trx->movie_title }}</td>
                            <td class="px-6 py-4 text-center"><span class="bg-gray-800 px-2 py-1 rounded text-xs border border-gray-700">{{ $trx->seats }}</span></td>
                            <td class="px-6 py-4 text-green-400 font-mono font-bold">Rp {{ number_format($trx->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-xs text-gray-500">{{ $trx->created_at->format('d/m/Y H:i') }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="px-6 py-8 text-center text-gray-500">Belum ada transaksi.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(method_exists($recentTransactions, 'links'))
            <div class="p-4 border-t border-gray-800">{{ $recentTransactions->links() }}</div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8" x-data="{ showEditModal: false, editData: {} }">
            
            <div class="lg:col-span-1">
                <div class="bg-[#1b1b1b] p-6 rounded-xl shadow-xl border border-gray-800 sticky top-24">
                    <h2 class="text-xl font-bold mb-6 text-white border-b border-gray-700 pb-2">
                        <i class="fa-solid fa-plus-circle mr-2 text-blue-500"></i> Tambah Film
                    </h2>
                    
                    <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Judul Film</label>
                            <input type="text" name="title" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 outline-none" required>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Harga Tiket (IDR)</label>
                            <input type="number" name="ticket_price" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="45000" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Link Trailer (YouTube)</label>
                            <input type="url" name="trailer_url" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 outline-none" placeholder="https://www.youtube.com/watch?v=...">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Status Tayang</label>
                            <select name="status" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 cursor-pointer">
                                <option value="now_showing">🟢 Now Showing</option>
                                <option value="upcoming">🟡 Upcoming</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi</label>
                            <textarea name="description" rows="3" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white focus:ring-2 focus:ring-blue-500 outline-none"></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-1">Poster Film</label>
                            <input type="file" name="poster" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" required>
                        </div>
                        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg shadow-lg hover:shadow-blue-500/30 transition duration-300">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Film
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[#1b1b1b] rounded-xl shadow-xl border border-gray-800 overflow-hidden">
                    <div class="p-6 border-b border-gray-700 flex justify-between items-center">
                        <h2 class="text-xl font-bold text-white"><i class="fa-solid fa-list mr-2 text-blue-500"></i> Daftar Film</h2>
                        <span class="bg-blue-900/30 text-blue-400 text-xs font-semibold px-2.5 py-0.5 rounded border border-blue-800">Total: {{ $movies->count() }}</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-400">
                            <thead class="bg-black text-gray-200 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4">Poster</th>
                                    <th class="px-6 py-4">Info Film</th>
                                    <th class="px-6 py-4 text-center">Harga</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse($movies as $movie)
                                <tr class="hover:bg-[#222] transition duration-200">
                                    <td class="px-6 py-4">
                                        <div class="h-20 w-14 rounded overflow-hidden border border-gray-700">
                                            <img src="{{ asset($movie->poster_path) }}" class="h-full w-full object-cover">
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="font-bold text-white text-base mb-1">{{ $movie->title }}</div>
                                        <div class="text-[10px] text-gray-500 mb-1 line-clamp-1">{{ $movie->description }}</div>
                                        @if($movie->status == 'now_showing')
                                            <span class="text-xs text-green-400 border border-green-800 bg-green-900/30 px-2 py-0.5 rounded">Showing</span>
                                        @else
                                            <span class="text-xs text-yellow-400 border border-yellow-800 bg-yellow-900/30 px-2 py-0.5 rounded">Upcoming</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center text-white font-mono">
                                        Rp {{ number_format($movie->ticket_price, 0, ',', '.') }}
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center gap-2">
                                            <button @click="showEditModal = true; editData = { 
                                                id: {{ $movie->id }}, 
                                                title: '{{ addslashes($movie->title) }}', 
                                                price: {{ $movie->ticket_price }}, 
                                                status: '{{ $movie->status }}', 
                                                desc: '{{ addslashes($movie->description) }}',
                                                trailer: '{{ $movie->trailer_url }}' 
                                            }" 
                                                class="text-gray-400 hover:text-blue-500 transition p-2 hover:bg-blue-900/20 rounded-full" title="Edit">
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </button>

                                            <form action="{{ route('admin.delete', $movie->id) }}" method="POST" onsubmit="return confirm('Hapus film ini?');">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="text-gray-400 hover:text-red-500 transition p-2 hover:bg-red-900/20 rounded-full" title="Hapus">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr><td colspan="4" class="px-6 py-10 text-center text-gray-500">Belum ada data.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div x-show="showEditModal" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                    <div x-show="showEditModal" class="fixed inset-0 bg-black bg-opacity-80 transition-opacity" @click="showEditModal = false"></div>

                    <div class="inline-block align-bottom bg-[#1b1b1b] border border-gray-700 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                        <form :action="'/admin/movie/' + editData.id" method="POST" enctype="multipart/form-data" class="p-6">
                            @csrf 
                            <input type="hidden" name="_method" value="PUT">
                            
                            <h3 class="text-lg font-medium leading-6 text-white mb-4"><i class="fa-solid fa-edit text-blue-500 mr-2"></i> Edit Film</h3>
                            
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Judul Film</label>
                                    <input type="text" name="title" x-model="editData.title" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Harga Tiket (IDR)</label>
                                    <input type="number" name="ticket_price" x-model="editData.price" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Link Trailer</label>
                                    <input type="url" name="trailer_url" x-model="editData.trailer" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white outline-none focus:border-blue-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                                    <select name="status" x-model="editData.status" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white outline-none focus:border-blue-500">
                                        <option value="now_showing">🟢 Now Showing</option>
                                        <option value="upcoming">🟡 Upcoming</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Deskripsi</label>
                                    <textarea name="description" x-model="editData.desc" rows="3" class="w-full bg-[#222] border border-gray-700 rounded-lg p-2.5 text-white outline-none focus:border-blue-500"></textarea>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-400 mb-1">Ganti Poster (Opsional)</label>
                                    <input type="file" name="poster" class="block w-full text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-gray-700 file:text-white hover:file:bg-gray-600">
                                </div>
                            </div>

                            <div class="mt-6 flex justify-end gap-3">
                                <button type="button" @click="showEditModal = false" class="bg-gray-700 hover:bg-gray-600 text-white px-4 py-2 rounded-lg transition">Batal</button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        <footer class="mt-12 border-t border-gray-800 pt-6 text-center text-gray-600 text-sm">
            &copy; 2025 Bookingin Admin Panel. All rights reserved.
        </footer>
    </div>
</body>
</html>