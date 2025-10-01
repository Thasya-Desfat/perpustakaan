<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;
use App\Models\Favorite;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    public function dashboard()
    {
        $bukus = Buku::all();
        $peminjamans = Peminjaman::with('buku')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();
        $favorites = Favorite::where('user_id', Auth::id())->with('buku')->get();

        return view('siswa.dashboard', compact('peminjamans', 'bukus', 'favorites'));
    }

    public function riwayat()
    {
        $peminjamans = \App\Models\Peminjaman::with('buku')
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('siswa.riwayat', compact('peminjamans'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('profile_photo')) {
            // Hapus foto lama jika ada
            if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
                Storage::disk('public')->delete($user->profile_photo);
            }
            $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
        }

        // Pastikan $user adalah instance Eloquent User, jika tidak, ambil ulang dari model
        if (!($user instanceof \App\Models\User)) {
            $user = \App\Models\User::find($user->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if ($request->hasFile('profile_photo')) {
                $user->profile_photo = $request->file('profile_photo')->store('profile_photos', 'public');
            }
        }

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function toggleFavorite(Request $request, $id)
    {
        $user = Auth::user();
        $favorite = Favorite::where('user_id', $user->id)
            ->where('buku_id', $id)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return back()->with('success', 'Buku dihapus dari favorit');
        }

        Favorite::create([
            'user_id' => $user->id,
            'buku_id' => $id
        ]);

        return back()->with('success', 'Buku ditambahkan ke favorit');
    }

    public function getFavorites()
    {
        return Favorite::where('user_id', Auth::id())
            ->with('buku')
            ->get()
            ->pluck('buku');
    }
}
