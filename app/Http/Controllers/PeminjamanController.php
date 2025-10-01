<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Import the Log facade

class PeminjamanController extends Controller
{
    public function pinjam(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam|before_or_equal:' . now()->addDays(3)->format('Y-m-d\TH:i'),
        ]);

        // Pastikan user sudah login dan auth()->id() tidak null
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Ambil buku berdasarkan id
        $buku = \App\Models\Buku::findOrFail($id);

        // Validasi stok buku
        if ($buku->stok < 1) {
            return redirect()->back()->with('error', 'Stok buku tidak tersedia.');
        }

        // Format tanggal dengan benar
        $tanggal_pinjam = \Carbon\Carbon::parse($request->tanggal_pinjam)->format('Y-m-d H:i:s');
        $tanggal_kembali = \Carbon\Carbon::parse($request->tanggal_kembali)->format('Y-m-d H:i:s');

        // Buat peminjaman baru
        $peminjaman = new \App\Models\Peminjaman();
        $peminjaman->user_id = $userId;
        $peminjaman->buku_id = $buku->id;
        $peminjaman->status = 'menunggu konfirmasi';
        $peminjaman->tanggal_pinjam = $tanggal_pinjam;
        $peminjaman->tanggal_kembali = $tanggal_kembali;
        $peminjaman->save();

        // Redirect ke dashboard siswa agar tab riwayat langsung terlihat
        return redirect()->route('siswa.dashboard')->with('success', 'ok buku berhasil di pinjam, silahkan tunggu konfirmasi admin');
    }

    public function index()
    {
        $peminjamans = Peminjaman::with('user', 'buku')->orderBy('created_at', 'desc')->get();
        return view('admin.peminjaman.index', compact('peminjamans'));
    }

    public function konfirmasi($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $buku = $peminjaman->buku;

        // Check stock again before confirming
        if ($buku->stok < 1) {
            return back()->with('error', 'Maaf, stok buku tidak tersedia.');
        }

        // Update peminjaman status
        $peminjaman->status = 'dipinjam';
        $peminjaman->save();

        // Decrease book stock
        $buku->stok -= 1;
        $buku->save();

        return back()->with('success', 'ok dapet konfirmasi dari admin');
    }

    public function selesai($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        // Update peminjaman status
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // Increase book stock
        $buku = $peminjaman->buku;
        $buku->stok += 1;
        $buku->save();

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }

    public function selesaiSiswa($id)
    {
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'dipinjam')
            ->firstOrFail();
        
        // Update peminjaman status
        $peminjaman->status = 'dikembalikan';
        $peminjaman->save();

        // Increase book stock
        $buku = $peminjaman->buku;
        $buku->stok += 1;
        $buku->save();

        return back()->with('success', 'Buku berhasil dikembalikan.');
    }
}
