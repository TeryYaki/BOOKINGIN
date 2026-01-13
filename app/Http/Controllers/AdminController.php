<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Movie; // PENTING

class AdminController extends Controller {
    public function dashboard() {
        $movies = Movie::latest()->get();
        return view('admin.dashboard', compact('movies'));
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required',
            'poster' => 'required|image',
            'status' => 'required'
        ]);
        $imageName = time().'.'.$request->poster->extension();
        $request->poster->move(public_path('images/movies'), $imageName);

        Movie::create([
            'title' => $request->title,
            'description' => $request->description,
            'poster_path' => 'images/movies/'.$imageName,
            'status' => $request->status
        ]);
        return redirect()->back();
    }

    public function destroy($id) {
        Movie::destroy($id);
        return redirect()->back();
    }
}