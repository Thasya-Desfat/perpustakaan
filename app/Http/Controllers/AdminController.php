<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function dashboard()
    {
        // Ambil data buku
        $bukus = Buku::all();
        
        // Ambil data peminjaman dan urutkan berdasarkan yang terbaru
        $peminjamans = Peminjaman::with(['user', 'buku'])
                                ->orderBy('created_at', 'desc')
                                ->get();
        
        // Ambil data siswa (user dengan role 'siswa')
        $siswas = User::where('role', 'siswa')
                     ->orderBy('created_at', 'desc')
                     ->get();

        return view('admin.dashboard', compact('bukus', 'peminjamans', 'siswas'));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Ensure $user is an Eloquent model instance
        $user = \App\Models\User::find(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_photo')) {
            if ($user->profile_photo) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($user->profile_photo);
            }
            $path = $request->file('profile_photo')->store('profile-photos', 'public');
            $user->profile_photo = $path;
        }

        $user->save();

        return redirect()->route('admin.dashboard')->with('success', 'Profil berhasil diperbarui');
    }

    public function createBuku()
    {
        return view('admin.buku.create');
    }

    public function storeBuku(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'sinopsis' => 'required|string',
            'tahun_terbit' => 'required|digits:4|integer|min:1900|max:2100',
            'kategori' => 'required|in:fiksi,non fiksi,buku mata pelajaran',
            'penulis' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('buku_images', 'public');
        }

        Buku::create($validated);

        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function editBuku(Buku $buku)
    {
        return view('admin.buku.edit', compact('buku'));
    }

    public function updateBuku(Request $request, Buku $buku)
    {
        // Validation and update logic
    }

    public function destroyBuku(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Buku berhasil dihapus');
    }
}