@extends('layouts.app')

@section('title', 'Riwayat Peminjaman Buku')

@section('content')
<div class="container">
    <h2>Riwayat Peminjaman Buku</h2>
    <a href="{{ route('siswa.dashboard') }}" class="btn btn-secondary" style="margin-bottom:15px;">Kembali ke Dashboard</a>
    {{-- Tambahkan notifikasi --}}
    @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger" style="margin-bottom: 20px;">
            {{ session('error') }}
        </div>
    @endif
    <table border="1" cellpadding="8" cellspacing="0" style="width:100%;background:#fff;">
        <thead>
            <tr>
                <th>Judul Buku</th>
                <th>Status</th>
                <th>Waktu</th>
                <th>Tgl Pinjam</th>
                <th>Tgl Kembali</th>
            </tr>
        </thead>
        <tbody>
            @forelse($peminjamans as $peminjaman)
            <tr>
                <td>{{ $peminjaman->buku->judul }}</td>
                <td>
                    @if($peminjaman->status == 'menunggu konfirmasi')
                        <span style="background: #fff8e1; color: #f59e0b; padding: 4px 10px; border-radius: 8px;">{{ ucfirst($peminjaman->status) }}</span>
                    @elseif($peminjaman->status == 'dipinjam')
                        <span style="background: #e3f2fd; color: #1e3c72; padding: 4px 10px; border-radius: 8px;">{{ ucfirst($peminjaman->status) }}</span>
                    @else
                        <span style="background: #e8f5e9; color: #22c55e; padding: 4px 10px; border-radius: 8px;">{{ ucfirst($peminjaman->status) }}</span>
                    @endif
                </td>
                <td>{{ $peminjaman->created_at->format('d M Y H:i') }}</td>
                <td>
                    {{ $peminjaman->tanggal_pinjam ? date('d M Y H:i', strtotime($peminjaman->tanggal_pinjam)) : '-' }}
                </td>
                <td>
                    {{ $peminjaman->tanggal_kembali ? date('d M Y H:i', strtotime($peminjaman->tanggal_kembali)) : '-' }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5">Belum ada peminjaman buku.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection

{{-- Halaman ini sudah tidak digunakan. Riwayat peminjaman ada di dashboard siswa. --}}
