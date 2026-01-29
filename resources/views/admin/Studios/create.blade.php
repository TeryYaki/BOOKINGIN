<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Studio - Admin Dashboard</title>
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
        /* Hide scrollbar for table container */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="min-h-screen py-10 px-4">

    <div class="max-w-7xl mx-auto">
        
        <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center text-gray-400 hover:text-white mb-6 transition">
            <i class="fa-solid fa-arrow-left mr-2"></i> Kembali ke Dashboard
        </a>

        @if(session('success'))
            <div class="bg-green-900/50 border border-green-600 text-green-200 px-4 py-3 rounded relative mb-6 flex items-center shadow-lg">
                <i class="fa-solid fa-check-circle mr-2"></i>
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-1">
                <div class="glass-card w-full rounded-2xl shadow-2xl p-8 sticky top-10">
                    <div class="flex items-center justify-between mb-8 border-b border-gray-800 pb-4">
                        <div>
                            <h2 class="text-xl font-heading font-bold text-white">Tambah Studio</h2>
                            <p class="text-xs text-textMuted">Input data studio baru</p>
                        </div>
                        <div class="bg-brandBlue/10 p-2 rounded-full">
                            <i class="fa-solid fa-plus text-brandBlue text-lg"></i>
                        </div>
                    </div>

                    <form action="{{ route('studio.store') }}" method="POST" class="space-y-5">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Nama Studio</label>
                            <div class="relative">
                                <i class="fa-solid fa-film absolute left-4 top-3.5 text-gray-500"></i>
                                <input type="text" name="name" placeholder="Contoh: Studio 1" required 
                                       class="form-input w-full rounded-xl py-3 pl-11 pr-4 text-sm">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-400 mb-2">Kota / Lokasi</label>
                            <div class="relative">
                                <i class="fa-solid fa-location-dot absolute left-4 top-3.5 text-gray-500"></i>
                                <input type="text" name="city" placeholder="Contoh: Jakarta" required 
                                       class="form-input w-full rounded-xl py-3 pl-11 pr-4 text-sm">
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Jml. Baris</label>
                                <div class="relative">
                                    <input type="number" name="total_rows" placeholder="8" required 
                                           class="form-input w-full rounded-xl py-3 px-4 text-center text-sm">
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-400 mb-2">Jml. Kolom</label>
                                <div class="relative">
                                    <input type="number" name="total_cols" placeholder="10" required 
                                           class="form-input w-full rounded-xl py-3 px-4 text-center text-sm">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-bold py-3 rounded-xl shadow-lg transform hover:-translate-y-1 transition duration-200 mt-2">
                            <i class="fa-solid fa-save mr-2"></i> Simpan Studio
                        </button>
                    </form>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="glass-card w-full rounded-2xl shadow-2xl overflow-hidden">
                    <div class="p-6 border-b border-gray-800 flex justify-between items-center">
                        <h2 class="text-xl font-heading font-bold text-white">Daftar Studio</h2>
                        <span class="bg-gray-800 text-gray-300 text-xs px-2 py-1 rounded border border-gray-700">Total: {{ count($studios) }}</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-sm text-gray-400">
                            <thead class="bg-[#111] text-gray-200 uppercase text-xs">
                                <tr>
                                    <th class="px-6 py-4">Nama Studio</th>
                                    <th class="px-6 py-4">Lokasi</th>
                                    <th class="px-6 py-4 text-center">Kapasitas</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-800">
                                @forelse($studios as $studio)
                                <tr class="hover:bg-[#222] transition duration-200">
                                    <td class="px-6 py-4 font-semibold text-white">
                                        {{ $studio->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-2">
                                            <i class="fa-solid fa-map-marker-alt text-gray-600"></i> {{ $studio->city }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <span class="bg-blue-900/30 text-blue-400 border border-blue-800 px-2 py-1 rounded text-xs">
                                            {{ $studio->total_rows * $studio->total_cols }} Kursi
                                        </span>
                                        <div class="text-[10px] text-gray-600 mt-1">
                                            {{ $studio->total_rows }} Baris x {{ $studio->total_cols }} Kolom
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <form action="{{ route('studio.delete', $studio->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus studio {{ $studio->name }}? Data jadwal terkait juga mungkin akan terhapus.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-gray-500 hover:text-red-500 transition p-2 hover:bg-red-900/20 rounded-full" title="Hapus Studio">
                                                <i class="fa-solid fa-trash-can text-lg"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-10 text-center text-gray-500 italic">
                                        Belum ada data studio. Silakan tambahkan di form sebelah kiri.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>