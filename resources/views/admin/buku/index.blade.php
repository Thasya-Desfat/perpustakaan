@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
{{-- Navbar --}}
<div class="navbar" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 15px 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
    <div class="navbar-content" style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="navbar-brand" style="color: white; font-size: 24px; font-weight: 600;">📚 Perpustakaan Digital</div>
        </div>
        <div class="navbar-nav" style="display: flex; align-items: center; gap: 20px;">
            <a href="{{ route('admin.dashboard') }}" 
               style="background: rgba(255,255,255,0.1); color: white; border: none; 
                      padding: 8px 20px; border-radius: 50px; text-decoration: none;
                      display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;" 
               onmouseover="this.style.background='rgba(255,255,255,0.2)'" 
               onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                <span style="font-size: 18px;">🏠</span> Kembali ke Dashboard
            </a>
        </div>
    </div>
</div>

<div style="padding: 30px;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            {{-- Header Section --}}
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                <div style="display: flex; align-items: center; gap: 15px;">
                    <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                        <span style="font-size: 24px;">📚</span>
                    </div>
                    <div>
                        <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Daftar Buku</h3>
                        <p style="color: #64748b; margin: 5px 0 0 0;">Kelola koleksi buku perpustakaan</p>
                    </div>
                </div>
                <a href="{{ route('admin.buku.create') }}" 
                   style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; text-decoration: none;
                          padding: 10px 20px; border-radius: 10px; display: flex; align-items: center; gap: 8px;
                          font-weight: 500; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(30,60,114,0.2);"
                   onmouseover="this.style.transform='translateY(-2px)'"
                   onmouseout="this.style.transform='translateY(0)'">
                    <span style="font-size: 20px;">✨</span> Tambah Buku
                </a>
            </div>

            {{-- Table --}}
            <div style="background: #f8fafc; border-radius: 12px; padding: 5px; overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e2e8f0;">
                            <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Judul</th>
                            <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Sinopsis</th>
                            <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Tahun Terbit</th>
                            <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Kategori</th>
                            <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Penulis</th>
                            <th style="padding: 15px; text-align: center; color: #1e3c72; font-weight: 600;">Stok</th>
                            <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Gambar</th>
                            <th style="padding: 15px; text-align: center; color: #1e3c72; font-weight: 600;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bukus as $buku)
                        <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.3s ease;"
                            onmouseover="this.style.background='#f1f5f9'"
                            onmouseout="this.style.background='transparent'">
                            <td style="padding: 15px;">{{ $buku->judul }}</td>
                            <td style="padding: 15px;">{{ Str::limit($buku->sinopsis, 50) }}</td>
                            <td style="padding: 15px;">{{ $buku->tahun_terbit }}</td>
                            <td style="padding: 15px;">
                                <span style="background: #e3f2fd; color: #1e3c72; padding: 5px 10px; border-radius: 50px; font-size: 14px;">
                                    {{ $buku->kategori }}
                                </span>
                            </td>
                            <td style="padding: 15px;">{{ $buku->penulis }}</td>
                            <td style="padding: 15px; text-align: center;">
                                <span style="background: {{ $buku->stok > 0 ? '#e8f5e9' : '#fee2e2' }}; 
                                           color: {{ $buku->stok > 0 ? '#22c55e' : '#ef4444' }}; 
                                           padding: 5px 15px; border-radius: 50px; font-weight: 500;">
                                    {{ $buku->stok }}
                                </span>
                            </td>
                            <td style="padding: 15px;">
                                @if($buku->image)
                                    <img src="{{ asset('storage/'.$buku->image) }}" alt="Cover" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <span style="color: #64748b;">-</span>
                                @endif
                            </td>
                            <td style="padding: 15px; text-align: center;">
                                <div style="display: flex; gap: 8px; justify-content: center;">
                                    <a href="{{ route('admin.buku.edit', $buku->id) }}"
                                       style="background: #f59e0b; color: white; padding: 8px; border-radius: 8px; 
                                              text-decoration: none; display: flex; align-items: center; justify-content: center;
                                              transition: all 0.3s ease;"
                                       onmouseover="this.style.transform='translateY(-2px)'"
                                       onmouseout="this.style.transform='translateY(0)'">
                                        <span style="font-size: 16px;">✏️</span>
                                    </a>
                                    <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Yakin ingin menghapus?')"
                                                style="background: #ef4444; color: white; padding: 8px; border-radius: 8px;
                                                       border: none; cursor: pointer; display: flex; align-items: center;
                                                       justify-content: center; transition: all 0.3s ease;"
                                                onmouseover="this.style.transform='translateY(-2px)'"
                                                onmouseout="this.style.transform='translateY(0)'">
                                            <span style="font-size: 16px;">🗑️</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
