<?php

namespace App\Http\Controllers;

use App\Models\Studio; // Pastikan Model diimport
use Illuminate\Http\Request;

class StudioController extends Controller
{
    // Ubah method create menjadi seperti ini:
    public function create()
    {
        // Ambil semua data studio urut dari yang terbaru
        $studios = Studio::latest()->get(); 
        return view('admin.Studios.create', compact('studios'));
    }

    public function store(Request $request)
    {
        // ... (Kode store Anda yang lama tetap sama) ...
        // Pastikan return-nya: return redirect()->route('studio.create')->with('success', '...');
        // Agar kembali ke halaman list setelah simpan.
        
        $validated = $request->validate([
            'name' => 'required',
            'city' => 'required',
            'total_rows' => 'required|integer',
            'total_cols' => 'required|integer',
        ]);

        Studio::create($validated);

        return redirect()->route('studio.create')->with('success', 'Studio berhasil ditambahkan!');
    }

    // Tambahkan method ini:
    public function destroy($id)
    {
        $studio = Studio::findOrFail($id);
        $studio->delete();

        return redirect()->route('studio.create')->with('success', 'Studio berhasil dihapus!');
    }
}