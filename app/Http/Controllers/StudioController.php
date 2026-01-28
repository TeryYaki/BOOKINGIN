<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Studio;

class StudioController extends Controller
{
    // Tampilkan Form Tambah Studio
    public function create()
    {
        return view('admin.studios.create');
    }

    // Simpan ke Database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'city' => 'required',
            'total_rows' => 'required|integer|min:1',
            'total_cols' => 'required|integer|min:1',
        ]);

        Studio::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Studio berhasil dibuat!');
    }
}