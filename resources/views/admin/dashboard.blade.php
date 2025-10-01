@extends('layouts.app')

@section('title', 'Dashboard Admin - Perpustakaan Sekolah')

@section('content')
{{-- Navbar --}}
<div class="navbar" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); padding: 15px 30px; box-shadow: 0 2px 15px rgba(0,0,0,0.1);">
    <div class="navbar-content" style="display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 20px;">
            <div class="navbar-brand" style="color: white; font-size: 24px; font-weight: 600;">📚 Perpustakaan Digital</div>
            <a href="{{ route('home') }}" 
               style="background: rgba(255,255,255,0.1); color: white; border: none; 
                      padding: 8px 20px; border-radius: 50px; text-decoration: none;
                      display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;" 
               onmouseover="this.style.background='rgba(255,255,255,0.2)'" 
               onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                <span style="font-size: 18px;">🏠</span> Home
            </a>
        </div>
        <div class="navbar-nav" style="display: flex; align-items: center; gap: 20px;">
            <div style="display: flex; align-items: center; background: rgba(255,255,255,0.1); padding: 8px 15px; border-radius: 50px;">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto Profil" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" alt="Foto Profil" style="width: 35px; height: 35px; border-radius: 50%; object-fit: cover; border: 2px solid white;">
                @endif
                <span style="color: white; margin-left: 10px;">{{ Auth::user()->name }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" style="background: rgba(255,255,255,0.1); color: white; border: none; padding: 8px 20px; border-radius: 50px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;" onmouseover="this.style.background='rgba(255,255,255,0.2)'" onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    <span style="font-size: 18px;">🚪</span> Logout
                </button>
            </form>
        </div>
    </div>
</div>

<div style="display: flex; min-height: 85vh; background: #f8fafc; padding: 20px;">
    {{-- Sidebar --}}
    <div style="width: 280px; background: white; padding: 25px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        <h3 style="color: #1e3c72; margin-bottom: 25px; font-size: 20px; font-weight: 600;">Menu Navigasi</h3>
        <ul style="list-style: none; padding: 0; margin: 0;">
            <li style="margin-bottom: 15px;">
                <button onclick="showTab('buku')" class="menu-btn" style="width: 100%; text-align: left; padding: 12px 20px; border-radius: 10px; border: none; background: #f8fafc; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">📚</span>
                    <div>
                        <div style="font-weight: 600; color: #1e3c72;">Manajemen Buku</div>
                        <div style="font-size: 12px; color: #64748b;">Kelola data perpustakaan</div>
                    </div>
                </button>
            </li>
            <li style="margin-bottom: 15px;">
                <button onclick="showTab('peminjaman')" class="menu-btn" style="width: 100%; text-align: left; padding: 12px 20px; border-radius: 10px; border: none; background: #f8fafc; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">📋</span>
                    <div>
                        <div style="font-weight: 600; color: #1e3c72;">Data Peminjaman</div>
                        <div style="font-size: 12px; color: #64748b;">Kelola peminjaman buku</div>
                    </div>
                </button>
            </li>
            <li style="margin-bottom: 15px;">
                <button onclick="showTab('siswa')" class="menu-btn" style="width: 100%; text-align: left; padding: 12px 20px; border-radius: 10px; border: none; background: #f8fafc; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">👥</span>
                    <div>
                        <div style="font-weight: 600; color: #1e3c72;">Manajemen Siswa</div>
                        <div style="font-size: 12px; color: #64748b;">Kelola data siswa</div>
                    </div>
                </button>
            </li>
            <li style="margin-bottom: 15px;">
                <button onclick="showTab('rekap')" class="menu-btn" style="width: 100%; text-align: left; padding: 12px 20px; border-radius: 10px; border: none; background: #f8fafc; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">📊</span>
                    <div>
                        <div style="font-weight: 600; color: #1e3c72;">Rekap</div>
                        <div style="font-size: 12px; color: #64748b;">Statistik & Grafik</div>
                    </div>
                </button>
            </li>
            <li>
                <button onclick="showTab('profil')" class="menu-btn" style="width: 100%; text-align: left; padding: 12px 20px; border-radius: 10px; border: none; background: #f8fafc; cursor: pointer; transition: all 0.3s ease; display: flex; align-items: center; gap: 12px;">
                    <span style="font-size: 20px;">👤</span>
                    <div>
                        <div style="font-weight: 600; color: #1e3c72;">Profil Admin</div>
                        <div style="font-size: 12px; color: #64748b;">Pengaturan akun</div>
                    </div>
                </button>
            </li>
        </ul>
    </div>

    {{-- Main Content --}}
    <div style="flex: 1; margin-left: 25px;">
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            <!-- Welcome Banner -->
            <div style="background: linear-gradient(135deg, #1e3c72, #2a5298); border-radius: 20px; padding: 30px; margin-bottom: 30px; position: relative; overflow: hidden;">
                <!-- Decorative Elements -->
                <div style="position: absolute; top: -30px; right: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.1); border-radius: 50%;"></div>
                <div style="position: absolute; bottom: -20px; left: -20px; width: 100px; height: 100px; background: rgba(255,255,255,0.05); border-radius: 50%;"></div>
                
                <!-- Welcome Message -->
                <div style="position: relative; z-index: 2; display: flex; align-items: center; gap: 20px;">
                    <div style="background: rgba(255,255,255,0.2); padding: 20px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        <span style="font-size: 40px;">👋</span>
                    </div>
                    <div>
                        <h2 style="color: white; font-size: 28px; font-weight: 700; margin: 0 0 10px 0; 
                                   text-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                            Selamat Datang, {{ Auth::user()->name }}
                        </h2>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 50px; 
                                       color: white; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                <span style="font-size: 16px;">👑</span>
                                Administrator
                            </span>
                            <span style="background: rgba(255,255,255,0.2); padding: 8px 15px; border-radius: 50px; 
                                       color: white; font-size: 14px; display: flex; align-items: center; gap: 5px;">
                                <span style="font-size: 16px;">📚</span>
                                Perpustakaan Digital
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Content --}}
            <div id="tab-buku" class="tab-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600;">📚 Manajemen Buku</h3>
                    <a href="{{ route('admin.buku.create') }}" 
                       style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; text-decoration: none;
                              padding: 10px 20px; border-radius: 10px; display: flex; align-items: center; gap: 8px;
                              font-weight: 600; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(30,60,114,0.2);"
                       onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform='translateY(0)'">
                        <span>✨</span> Tambah Buku Baru
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
                    @foreach($bukus as $buku)
                    <div class="card" style="border: none; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                        @if($buku->image)
                            <img src="{{ asset('storage/'.$buku->image) }}" style="width:100%;height:180px;object-fit:cover;">
                        @endif
                        <div style="padding: 15px;">
                            <h4 style="color: #1e3c72; font-size: 18px; font-weight: 500; margin: 0 0 10px 0;">{{ $buku->judul }}</h4>
                            <p style="margin: 0 0 10px 0;"><b>Penulis:</b> {{ $buku->penulis }}</p>
                            <p style="margin: 0 0 10px 0;"><b>Kategori:</b> {{ $buku->kategori }}</p>
                            <p style="margin: 0 0 10px 0;"><b>Tahun:</b> {{ $buku->tahun_terbit }}</p>
                            <p style="margin: 0 0 10px 0;">{{ $buku->sinopsis }}</p>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.buku.edit', $buku->id) }}" class="btn btn-warning" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 10px; border-radius: 10px; background: #f59e0b; color: white; text-decoration: none; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(249,158,11,0.2);"
                                   onmouseover="this.style.transform='translateY(-2px)'"
                                   onmouseout="this.style.transform='translateY(0)'">
                                    <span style="font-size: 16px;">✏️</span> Edit
                                </a>
                                <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" style="flex: 1; display: flex; align-items: center; justify-content: center; padding: 10px; border-radius: 10px; background: #ef4444; color: white; border: none; cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(239,68,68,0.2);"
                                            onmouseover="this.style.transform='translateY(-2px)'"
                                            onmouseout="this.style.transform='translateY(0)'">
                                        <span style="font-size: 16px;">🗑️</span> Hapus
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Tab Peminjaman --}}
            <div id="tab-peminjaman" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">📋</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Daftar Peminjaman</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Kelola dan pantau aktivitas peminjaman buku</p>
                        </div>
                    </div>

                    <div style="background: #f8fafc; border-radius: 12px; padding: 5px; margin-bottom: 20px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>📚</span> Buku
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>👤</span> Peminjam
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>🔄</span> Status
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>📆</span> Tgl Pinjam
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>⏳</span> Tgl Kembali
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>⚡</span> Aksi
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($peminjamans as $peminjaman)
                                <tr style="border-bottom: 1px solid #e2e8f0; transition: all 0.3s ease;"
                                    onmouseover="this.style.background='#f1f5f9'"
                                    onmouseout="this.style.background='transparent'">
                                    <td style="padding: 15px;">
                                        <div style="display: flex; align-items: center; gap: 12px;">
                                            <div style="width: 40px; height: 40px; background: #e3f2fd; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                                                <span style="font-size: 20px;">📖</span>
                                            </div>
                                            <div>
                                                <div style="color: #1e3c72; font-weight: 500;">{{ $peminjaman->buku->judul }}</div>
                                                <div style="color: #64748b; font-size: 12px;">Kode: #{{ $peminjaman->buku->id }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td style="padding: 15px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span style="background: #f8fafc; padding: 8px 12px; border-radius: 8px; color: #1e3c72; font-size: 15px;">
                                                {{ $peminjaman->user->name }}
                                            </span>
                                        </div>
                                    </td>
                                    <td style="padding: 15px;">
                                        <span style="padding: 6px 12px; border-radius: 50px; font-size: 13px; font-weight: 500;
                                            @if($peminjaman->status == 'menunggu konfirmasi')
                                                background: #fff8e1; color: #f59e0b;
                                            @elseif($peminjaman->status == 'dipinjam')
                                                background: #e3f2fd; color: #1e3c72;
                                            @else
                                                background: #e8f5e9; color: #22c55e;
                                            @endif">
                                            {{ ucfirst($peminjaman->status) }}
                                        </span>
                                    </td>
                                    <td style="padding: 15px;">
                                        <div style="color: #64748b;">
                                            {{ $peminjaman->tanggal_pinjam ? \Carbon\Carbon::parse($peminjaman->tanggal_pinjam)->format('d M Y H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td style="padding: 15px;">
                                        <div style="color: #64748b;">
                                            {{ $peminjaman->tanggal_kembali ? \Carbon\Carbon::parse($peminjaman->tanggal_kembali)->format('d M Y H:i') : '-' }}
                                        </div>
                                    </td>
                                    <td style="padding: 15px;">
                                        @if($peminjaman->status == 'menunggu konfirmasi')
                                            <form action="{{ route('admin.peminjaman.konfirmasi', $peminjaman->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" 
                                                        style="background: #22c55e; color: white; border: none; padding: 8px 16px;
                                                               border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500;
                                                               display: flex; align-items: center; gap: 6px; transition: all 0.3s ease;"
                                                        onmouseover="this.style.transform='translateY(-2px)'"
                                                        onmouseout="this.style.transform='translateY(0)'">
                                                    <span>✅</span> Konfirmasi
                                                </button>
                                            </form>
                                        @elseif($peminjaman->status == 'dipinjam')
                                            <form action="{{ route('admin.peminjaman.selesai', $peminjaman->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" 
                                                        style="background: #f59e0b; color: white; border: none; padding: 8px 16px;
                                                               border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500;
                                                               display: flex; align-items: center; gap: 6px; transition: all 0.3s ease;"
                                                        onmouseover="this.style.transform='translateY(-2px)'"
                                                        onmouseout="this.style.transform='translateY(0)'">
                                                    <span>📦</span> Selesai
                                                </button>
                                            </form>
                                        @else
                                            <span style="color: #64748b; font-size: 13px;">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                @if(count($peminjamans) == 0)
                                <tr>
                                    <td colspan="6" style="padding: 30px; text-align: center;">
                                        <div style="color: #64748b;">
                                            <div style="font-size: 48px; margin-bottom: 10px;">📚</div>
                                            <div style="font-weight: 500; margin-bottom: 5px;">Belum Ada Peminjaman</div>
                                            <div style="font-size: 14px;">Belum ada data peminjaman buku</div>
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Tab Siswa --}}
            <div id="tab-siswa" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">👥</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Daftar Siswa</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Total siswa terdaftar: <b>{{ isset($siswas) ? count($siswas) : 0 }}</b></p>
                        </div>
                    </div>

                    @if(isset($siswas) && count($siswas) > 0)
                    <div style="background: #f8fafc; border-radius: 12px; padding: 5px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">#</th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Nama</th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Email</th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600;">Tanggal Daftar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($siswas as $i => $siswa)
                                <tr style="border-bottom: 1px solid #e2e8f0;">
                                    <td style="padding: 15px;">{{ $i+1 }}</td>
                                    <td style="padding: 15px; display: flex; align-items: center; gap: 10px;">
                                        @if($siswa->profile_photo)
                                            <img src="{{ asset('storage/' . $siswa->profile_photo) }}" alt="Foto" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($siswa->name) }}" alt="Foto" style="width:32px;height:32px;border-radius:50%;object-fit:cover;">
                                        @endif
                                        <span style="color: #1e3c72; font-weight: 500;">{{ $siswa->name }}</span>
                                    </td>
                                    <td style="padding: 15px; color: #64748b;">{{ $siswa->email }}</td>
                                    <td style="padding: 15px; color: #64748b;">{{ $siswa->created_at->format('d M Y') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div style="padding: 30px; text-align: center; color: #64748b;">
                        <div style="font-size: 48px; margin-bottom: 10px;">👥</div>
                        <div style="font-weight: 500; margin-bottom: 5px;">Belum Ada Siswa</div>
                        <div style="font-size: 14px;">Belum ada siswa yang terdaftar di sistem.</div>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Tab Rekap --}}
            <div id="tab-rekap" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 30px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">📊</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Rekap Peminjaman</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Statistik peminjaman buku dalam bentuk grafik</p>
                        </div>
                    </div>
                    <div style="display: flex; flex-wrap: wrap; gap: 40px;">
                        <div style="flex:1; min-width:320px;">
                            <h4 style="color:#1e3c72; font-size:18px; margin-bottom:10px;">Peminjaman per Hari (7 Hari Terakhir)</h4>
                            <canvas id="chartLine"></canvas>
                        </div>
                        <div style="flex:1; min-width:320px;">
                            <h4 style="color:#1e3c72; font-size:18px; margin-bottom:10px;">Distribusi Status Peminjaman</h4>
                            <canvas id="chartPie"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tab Profil --}}
            <div id="tab-profil" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 30px;">
                    <!-- Profile Header -->
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                        <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">👤</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Profil Admin</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Kelola informasi akun administrator</p>
                        </div>
                    </div>

                    <form action="{{ route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        
                        <!-- Profile Photo Section -->
                        <div style="text-align: center; margin-bottom: 30px;">
                            <div style="position: relative; display: inline-block;">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto Profil" 
                                         style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; 
                                                border: 4px solid white; box-shadow: 0 4px 15px rgba(30,60,114,0.15);">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=e3f2fd&color=1e3c72&size=150" 
                                         alt="Foto Profil" style="width: 150px; height: 150px; border-radius: 50%; 
                                                object-fit: cover; border: 4px solid white; 
                                                box-shadow: 0 4px 15px rgba(30,60,114,0.15);">
                                @endif
                                
                                <label for="profile_photo" style="position: absolute; bottom: 5px; right: 5px; 
                                       background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; width: 45px; height: 45px; 
                                       border-radius: 50%; display: flex; align-items: center; justify-content: center;
                                       cursor: pointer; border: 3px solid white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                                       transition: all 0.3s ease;"
                                       onmouseover="this.style.transform='scale(1.1)'"
                                       onmouseout="this.style.transform='scale(1)'">
                                    <span style="font-size: 20px;">📸</span>
                                </label>
                                <input type="file" name="profile_photo" id="profile_photo" accept="image/*" style="display:none;" onchange="this.form.submit()">
                            </div>
                        </div>

                        <!-- Form Fields -->
                        <div style="margin-bottom: 20px;">
                            <label for="name" style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ Auth::user()->name }}" required 
                                   style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                          font-size: 16px; color: #334155; transition: all 0.3s ease;
                                          box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        </div>

                        <div style="margin-bottom: 20px;">
                            <label for="email" style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Email</label>
                            <input type="email" name="email" id="email" value="{{ Auth::user()->email }}" required 
                                   style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                          font-size: 16px; color: #334155; transition: all 0.3s ease;
                                          box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        </div>

                        <div style="margin-bottom: 25px;">
                            <label for="password" style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Kata Sandi Baru</label>
                            <input type="password" name="password" id="password" placeholder="Biarkan kosong jika tidak ingin mengganti" 
                                   style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                          font-size: 16px; color: #334155; transition: all 0.3s ease;
                                          box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                                   onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" 
                                    style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; border: none; padding: 10px 20px;
                                           border-radius: 10px; cursor: pointer; font-size: 16px; font-weight: 500;
                                           display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
                                           box-shadow: 0 4px 15px rgba(30,60,114,0.2);"
                                    onmouseover="this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.transform='translateY(0)'">
                                <span>💾</span> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Tambahkan Chart.js CDN dan script --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
function showTab(tab) {
    // Sembunyikan semua tab
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
        content.classList.remove('active');
    });

    // Reset semua button sidebar
    document.querySelectorAll('.menu-btn').forEach(btn => {
        btn.classList.remove('active');
    });

    // Tampilkan tab yang dipilih dengan animasi
    const selectedTab = document.getElementById('tab-' + tab);
    if (selectedTab) {
        selectedTab.style.display = 'block';
        // Trigger reflow
        selectedTab.offsetHeight;
        selectedTab.classList.add('active');
    }

    // Aktifkan button yang dipilih
    const activeButton = document.querySelector(`button[onclick="showTab('${tab}')"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }

    // Render chart jika tab rekap
    if(tab === 'rekap') {
        setTimeout(renderRekapCharts, 100);
    }
}

// Tampilkan tab default saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    showTab('buku');
});

// Data untuk grafik (ambil dari PHP ke JS)
@php
    // Data untuk grafik garis: peminjaman per hari (7 hari terakhir)
    $days = [];
    $counts = [];
    $start = now()->subDays(6)->startOfDay();
    for($i=0; $i<7; $i++) {
        $date = $start->copy()->addDays($i);
        $days[] = $date->format('d M');
        $counts[] = $peminjamans->whereBetween('created_at', [$date->copy()->startOfDay(), $date->copy()->endOfDay()])->count();
    }
    // Data untuk grafik pie: status
    $statusLabels = ['Menunggu Konfirmasi', 'Dipinjam', 'Dikembalikan'];
    $statusCounts = [
        $peminjamans->where('status', 'menunggu konfirmasi')->count(),
        $peminjamans->where('status', 'dipinjam')->count(),
        $peminjamans->where('status', 'dikembalikan')->count(),
    ];
@endphp
function renderRekapCharts() {
    // Garis
    var ctxLine = document.getElementById('chartLine').getContext('2d');
    if(window.lineChart) window.lineChart.destroy();
    window.lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: {!! json_encode($days) !!},
            datasets: [{
                label: 'Jumlah Peminjaman',
                data: {!! json_encode($counts) !!},
                borderColor: '#1e3c72',
                backgroundColor: 'rgba(30,60,114,0.08)',
                tension: 0.3,
                fill: true,
                pointRadius: 5,
                pointBackgroundColor: '#2a5298'
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { precision:0 } }
            }
        }
    });
    // Pie
    var ctxPie = document.getElementById('chartPie').getContext('2d');
    if(window.pieChart) window.pieChart.destroy();
    window.pieChart = new Chart(ctxPie, {
        type: 'pie',
        data: {
            labels: {!! json_encode($statusLabels) !!},
            datasets: [{
                data: {!! json_encode($statusCounts) !!},
                backgroundColor: ['#f59e0b', '#1e3c72', '#22c55e'],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
    });
}
</script>

<style>
.menu-btn {
    position: relative;
    overflow: hidden;
    transform-origin: left;
}

.menu-btn::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 0;
    background: linear-gradient(135deg, #1e3c72, #2a5298);
    border-radius: 10px;
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    z-index: 0;
}

.menu-btn:hover::before,
.menu-btn.active::before {
    width: 100%;
}

.menu-btn > * {
    position: relative;
    z-index: 1;
}

.menu-btn:hover span,
.menu-btn:hover div,
.menu-btn.active span,
.menu-btn.active div {
    color: white !important;
    transform: translateX(5px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.menu-btn:not(:hover):not(.active) span,
.menu-btn:not(:hover):not(.active) div {
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    transform: translateX(0);
}

/* Tab content transitions */
.tab-content {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    display: none;
}

.tab-content.active {
    opacity: 1;
    transform: translateY(0);
    display: block;
}
</style>
@endsection
