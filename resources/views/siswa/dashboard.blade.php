@extends('layouts.app')

@section('title', 'Dashboard Siswa - Perpustakaan Sekolah')

@section('content')
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

<div style="min-height: 85vh; background: #f8fafc; padding: 20px;">
    {{-- Main Content --}}
    <div style="max-width: 1400px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            {{-- Tambahkan ini untuk notifikasi --}}
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

            {{-- Tambahkan hidden input untuk warning deadline --}}
            @php
                $hasLate = false;
                $lateTitles = [];
                foreach (isset($peminjamans) ? $peminjamans : [] as $peminjaman) {
                    if (
                        $peminjaman->status === 'dipinjam' && 
                        $peminjaman->tanggal_kembali && 
                        now() > \Carbon\Carbon::parse($peminjaman->tanggal_kembali)
                    ) {
                        $hasLate = true;
                        $lateTitles[] = $peminjaman->buku->judul;
                    }
                }
            @endphp
            <input type="hidden" id="hasLate" value="{{ $hasLate ? '1' : '0' }}">
            <input type="hidden" id="lateTitles" value="{{ implode(', ', $lateTitles) }}">
            
            {{-- Tab Content --}}
            <div id="tab-buku" class="tab-content">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
                    <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600;">📚 Koleksi Buku</h3>
                </div>

                {{-- Search and Filter Section --}}
                <div style="background: white; border-radius: 15px; padding: 25px; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                    <div style="display: flex; gap: 15px; flex-wrap: wrap; align-items: end;">
                        {{-- Search Input --}}
                        <div style="flex: 1; min-width: 250px;">
                            <label style="display: block; color: #1e3c72; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
                                <span style="margin-right: 5px;">🔍</span> Cari Buku
                            </label>
                            <input type="text" id="searchInput" placeholder="Cari judul buku..."
                                   style="width: 100%; padding: 12px 45px 12px 15px; border: 2px solid #e2e8f0; 
                                          border-radius: 10px; font-size: 15px; transition: all 0.3s ease;
                                          background: url('data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2220%22 height=%2220%22 viewBox=%220 0 24 24%22 fill=%22none%22 stroke=%22%2364748b%22 stroke-width=%222%22><circle cx=%2211%22 cy=%2211%22 r=%228%22/><path d=%22m21 21-4.35-4.35%22/></svg>') no-repeat right 15px center;"
                                   onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 0 0 3px rgba(30,60,114,0.1)'"
                                   onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'"
                                   onkeyup="filterBooks()">
                        </div>

                        {{-- Category Filter --}}
                        <div style="min-width: 180px;">
                            <label style="display: block; color: #1e3c72; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
                                <span style="margin-right: 5px;">📑</span> Kategori
                            </label>
                            <select id="categoryFilter" onchange="filterBooks()"
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; 
                                           border-radius: 10px; font-size: 15px; transition: all 0.3s ease;
                                           background: white; cursor: pointer;"
                                    onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 0 0 3px rgba(30,60,114,0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                <option value="">Semua Kategori</option>
                                <option value="fiksi">Fiksi</option>
                                <option value="non fiksi">Non Fiksi</option>
                                <option value="buku mata pelajaran">Buku Mata Pelajaran</option>
                            </select>
                        </div>

                        {{-- Author Filter --}}
                        <div style="min-width: 180px;">
                            <label style="display: block; color: #1e3c72; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
                                <span style="margin-right: 5px;">👤</span> Pengarang
                            </label>
                            <select id="authorFilter" onchange="filterBooks()"
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; 
                                           border-radius: 10px; font-size: 15px; transition: all 0.3s ease;
                                           background: white; cursor: pointer;"
                                    onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 0 0 3px rgba(30,60,114,0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                <option value="">Semua Pengarang</option>
                                @php
                                    $authors = isset($bukus) ? $bukus->pluck('penulis')->unique()->sort()->values() : collect();
                                @endphp
                                @foreach($authors as $author)
                                    <option value="{{ strtolower($author) }}">{{ $author }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Year Filter --}}
                        <div style="min-width: 150px;">
                            <label style="display: block; color: #1e3c72; font-weight: 600; margin-bottom: 8px; font-size: 14px;">
                                <span style="margin-right: 5px;">📅</span> Tahun Terbit
                            </label>
                            <select id="yearFilter" onchange="filterBooks()"
                                    style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; 
                                           border-radius: 10px; font-size: 15px; transition: all 0.3s ease;
                                           background: white; cursor: pointer;"
                                    onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 0 0 3px rgba(30,60,114,0.1)'"
                                    onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                                <option value="">Semua Tahun</option>
                                @php
                                    $years = isset($bukus) ? $bukus->pluck('tahun_terbit')->unique()->sort()->reverse()->values() : collect();
                                @endphp
                                @foreach($years as $year)
                                    <option value="{{ $year }}">{{ $year }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Reset Button --}}
                        <button onclick="resetFilter()" 
                                style="padding: 12px 24px; background: #f1f5f9; color: #1e3c72; 
                                       border: 2px solid #e2e8f0; border-radius: 10px; font-weight: 600;
                                       cursor: pointer; transition: all 0.3s ease; font-size: 15px;
                                       display: flex; align-items: center; gap: 8px;"
                                onmouseover="this.style.background='#e2e8f0'"
                                onmouseout="this.style.background='#f1f5f9'">
                            <span>🔄</span> Reset
                        </button>
                    </div>

                    {{-- Search Results Info --}}
                    <div id="searchInfo" style="margin-top: 15px; padding: 10px 15px; background: #f0f7ff; 
                                               border-radius: 8px; color: #1e3c72; font-size: 14px; display: none;">
                        <span id="searchInfoText"></span>
                    </div>
                </div>

                <div id="bookGrid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
                    @foreach(isset($bukus) ? $bukus : [] as $buku)
                    <a href="{{ route('siswa.buku.detail', $buku->id) }}" class="book-card" data-judul="{{ strtolower($buku->judul) }}" 
                         data-penulis="{{ strtolower($buku->penulis) }}" 
                         data-kategori="{{ strtolower($buku->kategori) }}" 
                         data-tahun="{{ $buku->tahun_terbit }}"
                         style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; 
                                cursor: pointer; position: relative; text-decoration: none;
                                border: 1px solid #e5e7eb; height: 100%; box-shadow: 0 4px 15px rgba(0,0,0,0.05);
                                display: block;"
                         onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                        
                        <!-- Book Cover/Image with Gradient Overlay -->
                        <div style="position: relative; height: 200px; background: linear-gradient(135deg, #1e3c72, #2a5298);">
                            @if($buku->image)
                                <img src="{{ asset('storage/'.$buku->image) }}" 
                                     style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9; transition: transform 0.3s ease;"
                                     onmouseover="this.style.transform='scale(1.1)'"
                                     onmouseout="this.style.transform='scale(1)'">
                            @else
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 48px;">
                                    📚
                                </div>
                            @endif
                            <!-- Gradient Overlay -->
                            <div style="position: absolute; bottom: 0; left: 0; right: 0; height: 50%; 
                                        background: linear-gradient(to top, rgba(0,0,0,0.7), transparent);"></div>
                        </div>
                        
                        <!-- Book Info -->
                        <div style="padding: 25px;">
                            <!-- Category Badge -->
                            <div style="position: absolute; top: 180px; right: 20px; background: #e3f2fd; color: #1e3c72; 
                                        padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;
                                        box-shadow: 0 4px 15px rgba(0,0,0,0.1); backdrop-filter: blur(5px);
                                        border: 1px solid rgba(255,255,255,0.3);">
                                <span style="margin-right: 5px;">📑</span>{{ $buku->kategori }}
                            </div>

                            <!-- Title -->
                            <h4 style="color: #1e3c72; font-size: 22px; font-weight: 700; margin-bottom: 15px; 
                                       display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; 
                                       overflow: hidden; line-height: 1.4;">
                                {{ $buku->judul }}
                            </h4>

                            <!-- Meta Info with Icons -->
                            <div style="display: flex; flex-wrap: wrap; gap: 15px; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #e5e7eb;">
                                <div style="display: flex; align-items: center; gap: 8px; background: #f8fafc; padding: 8px 12px; border-radius: 8px;">
                                    <span style="color: #1e3c72; font-size: 16px;">👤</span>
                                    <span style="color: #64748b; font-size: 14px; font-weight: 500;">{{ $buku->penulis }}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 8px; background: #f8fafc; padding: 8px 12px; border-radius: 8px;">
                                    <span style="color: #1e3c72; font-size: 16px;">📅</span>
                                    <span style="color: #64748b; font-size: 14px; font-weight: 500;">{{ $buku->tahun_terbit }}</span>
                                </div>
                            </div>

                            <!-- Synopsis with Icon -->
                            <div style="margin-bottom: 20px;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                    <span style="color: #1e3c72; font-size: 18px;">📖</span>
                                    <span style="color: #1e3c72; font-weight: 600; font-size: 14px;">Sinopsis</span>
                                </div>
                                <p style="color: #64748b; font-size: 14px; line-height: 1.6;
                                          display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; 
                                          overflow: hidden; margin: 0; padding-left: 26px;">
                                    {{ $buku->sinopsis }}
                                </p>
                            </div>

                            <!-- View Details Button -->
                            <div style="width: 100%; background: linear-gradient(135deg, #1e3c72, #2a5298); color: white;
                                         border: none; padding: 14px; border-radius: 12px; font-weight: 600; font-size: 14px;
                                         display: flex; align-items: center; justify-content: center; gap: 8px;
                                         transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(30,60,114,0.2);">
                                <span>📚</span> Lihat Detail
                            </div>
                        </div>
                    </a>
                    @endforeach
                </div>

                {{-- Modal Pinjam Buku --}}
                <div id="pinjamModal" style="display:none; position:fixed; left:0; top:0; width:100vw; height:100vh; z-index:2000; pointer-events:none;">
                    <div style="position:fixed; left:50%; top:50%; transform:translate(-50%,-50%); background:white; width:95%; max-width:400px; border-radius:18px; box-shadow:0 8px 40px rgba(30,60,114,0.18); padding:0; overflow:hidden; z-index:10; animation:popIn 0.25s; pointer-events:auto;">
                        <div id="modalImageWrap" style="width:100%; height:180px; background:#f8fafc; display:flex; align-items:center; justify-content:center;">
                            <img id="modalImage" src="" alt="Cover Buku" style="width:100%; height:100%; object-fit:cover; border-radius:0; display:none;">
                            <span id="modalImageIcon" style="font-size:64px; color:#1e3c72; display:none;">📚</span>
                        </div>
                        <div style="padding:24px 24px 18px 24px;">
                            <h3 id="modalTitle" style="margin-bottom:10px; color:#1e3c72; font-size:22px; font-weight:700;"></h3>
                            <div id="modalDetails" style="color:#334155; font-size:15px; margin-bottom:18px;"></div>
                            <form id="pinjamForm" method="POST">
                                @csrf
                                <div style="margin-bottom: 14px;">
                                    <label for="tanggal_pinjam" style="font-weight:600; color:#1e3c72; font-size:14px;">Tanggal & Jam Pinjam</label>
                                    <input type="datetime-local" name="tanggal_pinjam" id="tanggal_pinjam" required
                                        style="width:100%;padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;margin-top:4px;font-size:15px;">
                                </div>
                                <div style="margin-bottom: 18px;">
                                    <label for="tanggal_kembali" style="font-weight:600; color:#1e3c72; font-size:14px;">Tanggal & Jam Kembali (max 3 hari)</label>
                                    <input type="datetime-local" name="tanggal_kembali" id="tanggal_kembali" required
                                        style="width:100%;padding:8px 12px;border-radius:8px;border:1px solid #e2e8f0;margin-top:4px;font-size:15px;">
                                </div>
                                <div style="display:flex; gap:10px;">
                                    <button type="submit" style="flex:1; background:linear-gradient(135deg,#1e3c72,#2a5298); color:white; border:none; padding:12px 0; border-radius:8px; font-weight:600; font-size:15px; cursor:pointer; box-shadow:0 2px 8px rgba(30,60,114,0.10);">
                                        📚 Pinjam Buku
                                    </button>
                                    <button type="button" onclick="closePinjamModal()" style="flex:1; background:#f1f5f9; color:#1e3c72; border:none; padding:12px 0; border-radius:8px; font-weight:600; font-size:15px; cursor:pointer;">
                                        Batal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div id="tab-riwayat" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">📋</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Riwayat Peminjaman</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Daftar buku yang pernah Anda pinjam</p>
                        </div>
                    </div>

                    {{-- Tabel Riwayat Peminjaman --}}
                    <div style="background: #f8fafc; border-radius: 12px; padding: 5px; margin-bottom: 20px;">
                        <table style="width: 100%; border-collapse: collapse;">
                            <thead>
                                <tr style="border-bottom: 2px solid #e2e8f0;">
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>📚</span> Judul Buku
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>🔄</span> Status
                                        </div>
                                    </th>
                                    <th style="padding: 15px; text-align: left; color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        <div style="display: flex; align-items: center; gap: 8px;">
                                            <span>📅</span> Waktu
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
                                @forelse(isset($peminjamans) ? $peminjamans : [] as $peminjaman)
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
                                                <div style="color: #64748b; font-size: 12px;">Kode: #{{ $peminjaman->id }}</div>
                                            </div>
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
                                            {{ $peminjaman->created_at->format('d M Y') }}
                                            <div style="font-size: 12px; color: #94a3b8;">
                                                {{ $peminjaman->created_at->format('H:i') }}
                                            </div>
                                        </div>
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
                                        @if($peminjaman->status == 'dipinjam')
                                            <form action="{{ route('siswa.peminjaman.selesai', $peminjaman->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                <button type="submit" 
                                                        onclick="return confirm('Yakin ingin mengembalikan buku ini?')"
                                                        style="background: #1e3c72; color: white; border: none; padding: 8px 16px;
                                                               border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 500;
                                                               display: flex; align-items: center; gap: 6px; transition: all 0.3s ease;"
                                                        onmouseover="this.style.transform='translateY(-2px)'"
                                                        onmouseout="this.style.transform='translateY(0)'">
                                                    <span>📦</span> Kembalikan
                                                </button>
                                            </form>
                                        @elseif($peminjaman->status == 'dikembalikan')
                                            <span style="color: #64748b; font-size: 13px;">Selesai</span>
                                        @else
                                            <span style="color: #64748b; font-size: 13px;">-</span>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" style="padding: 30px; text-align: center;">
                                        <div style="color: #64748b;">
                                            <div style="font-size: 48px; margin-bottom: 10px;">📚</div>
                                            <div style="font-weight: 500; margin-bottom: 5px;">Belum Ada Peminjaman</div>
                                            <div style="font-size: 14px;">Anda belum meminjam buku apapun</div>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="tab-favorite" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 25px;">
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 25px;">
                        <div style="background: #fff8e1; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">⭐</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Favorite Saya</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Daftar buku favorite Anda</p>
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 25px;">
                        @forelse($favorites as $favorite)
                        <div class="book-card" style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease; 
                                    position: relative; border: 1px solid #e5e7eb; box-shadow: 0 4px 15px rgba(0,0,0,0.05);"
                             onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                            
                            <!-- Book Cover -->
                            <div style="height: 200px; background: linear-gradient(135deg, #1e3c72, #2a5298); position: relative;">
                                @if($favorite->buku->image)
                                    <img src="{{ asset('storage/'.$favorite->buku->image) }}" 
                                         style="width: 100%; height: 100%; object-fit: cover; opacity: 0.9;">
                                @else
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); font-size: 48px;">📚</div>
                                @endif
                            </div>
                            
                            <div style="padding: 25px;">
                                <!-- Category Badge -->
                                <div style="position: absolute; top: 180px; right: 20px; background: #e3f2fd; color: #1e3c72; 
                                            padding: 8px 15px; border-radius: 20px; font-size: 14px; font-weight: 600;
                                            box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                    <span>📑</span> {{ $favorite->buku->kategori }}
                                </div>

                                <!-- Book Info -->
                                <h4 style="color: #1e3c72; font-size: 22px; font-weight: 700; margin-bottom: 15px;">
                                    {{ $favorite->buku->judul }}
                                </h4>

                                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <span>👤</span>
                                        <span style="color: #64748b;">{{ $favorite->buku->penulis }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 5px;">
                                        <span>📅</span>
                                        <span style="color: #64748b;">{{ $favorite->buku->tahun_terbit }}</span>
                                    </div>
                                </div>

                                <div style="margin-bottom: 20px;">
                                    <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
                                        <span>📖</span>
                                        <span style="color: #1e3c72; font-weight: 600;">Sinopsis</span>
                                    </div>
                                    <p style="color: #64748b; font-size: 14px; line-height: 1.6;">
                                        {{ Str::limit($favorite->buku->sinopsis, 150) }}
                                    </p>
                                </div>

                                <!-- Action Buttons -->
                                <div style="display: flex; gap: 10px;">
                                    <button onclick="showPinjamModal(
                                        {{ $favorite->buku->id }},
                                        '{{ addslashes($favorite->buku->judul) }}',
                                        '{{ addslashes($favorite->buku->penulis) }}',
                                        '{{ $favorite->buku->kategori }}',
                                        '{{ $favorite->buku->tahun_terbit }}',
                                        '{{ addslashes($favorite->buku->sinopsis) }}',
                                        '{{ $favorite->buku->image ? asset('storage/'.$favorite->buku->image) : '' }}'
                                    )" style="flex: 1; background: linear-gradient(135deg, #1e3c72, #2a5298); 
                                             color: white; border: none; padding: 12px; border-radius: 10px; 
                                             font-weight: 600; cursor: pointer;">
                                        <span>📚</span> Pinjam
                                    </button>
                                    <form action="{{ route('siswa.toggleFavorite', $favorite->buku->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        <button type="submit" style="background: #fee2e2; color: #dc2626; border: none; 
                                                               padding: 12px; border-radius: 10px; cursor: pointer;">
                                            <span>❌</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div style="text-align: center; padding: 40px 20px; grid-column: 1/-1;">
                            <div style="font-size: 48px; margin-bottom: 20px;">📚</div>
                            <h4 style="color: #1e3c72; font-size: 20px; font-weight: 600; margin-bottom: 10px;">
                                Belum Ada Buku Favorite
                            </h4>
                            <p style="color: #64748b;">
                                Anda belum menambahkan buku ke daftar favorite
                            </p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div id="tab-profil" class="tab-content" style="display:none;">
                <div style="background: white; border-radius: 15px; padding: 30px;">
                    <!-- Profile Header -->
                    <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                        <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                            <span style="font-size: 24px;">👤</span>
                        </div>
                        <div>
                            <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Profil Saya</h3>
                            <p style="color: #64748b; margin: 5px 0 0 0;">Kelola informasi pribadi Anda</p>
                        </div>
                    </div>

                    <form action="{{ route('siswa.updateProfile') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('POST')
                        
                        <!-- Profile Photo Section -->
                        <div style="text-align: center; margin-bottom: 30px;">
                            <div style="position: relative; display: inline-block;">
                                @if(Auth::user()->profile_photo)
                                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" alt="Foto Profil" 
                                         style="width: 120px; height: 120px; border-radius: 50%; object-fit: cover; 
                                                border: 4px solid white; box-shadow: 0 4px 15px rgba(30,60,114,0.15);">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}" 
                                         alt="Foto Profil" style="width: 120px; height: 120px; border-radius: 50%; 
                                                object-fit: cover; border: 4px solid white; 
                                                box-shadow: 0 4px 15px rgba(30,60,114,0.15);">
                                @endif
                                
                                <label for="profile_photo" style="position: absolute; bottom: 0; right: 0; 
                                       background: #1e3c72; color: white; width: 35px; height: 35px; 
                                       border-radius: 50%; display: flex; align-items: center; justify-content: center;
                                       cursor: pointer; border: 3px solid white; box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                    📷
                                </label>
                                <input type="file" id="profile_photo" name="profile_photo" accept="image/*" 
                                       style="display: none;" onchange="showPreview(this)">
                            </div>
                            <p style="color: #64748b; font-size: 14px; margin-top: 10px;">
                                Klik ikon kamera untuk mengubah foto profil
                            </p>
                        </div>

                        <!-- Form Fields -->
                        <div style="background: #f8fafc; border-radius: 15px; padding: 25px;">
                            <div style="margin-bottom: 20px;">
                                <label style="display: block; color: #1e3c72; font-weight: 600; margin-bottom: 8px;">
                                    <span style="margin-right: 8px;">👤</span> Nama Lengkap
                                </label>
                                <input type="text" name="name" value="{{ Auth::user()->name }}" required
                                       style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; 
                                              border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                       onfocus="this.style.borderColor='#1e3c72'; 
                                               this.style.boxShadow='0 0 0 3px rgba(30,60,114,0.1)'"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            </div>

                            <div style="margin-bottom: 25px;">
                                <label style="display: block; color: #1e3c72; font-weight: 600; margin-bottom: 8px;">
                                    <span style="margin-right: 8px;">📧</span> Email
                                </label>
                                <input type="email" name="email" value="{{ Auth::user()->email }}" required
                                       style="width: 100%; padding: 12px 15px; border: 2px solid #e2e8f0; 
                                              border-radius: 10px; font-size: 15px; transition: all 0.3s ease;"
                                       onfocus="this.style.borderColor='#1e3c72'; 
                                               this.style.boxShadow='0 0 0 3px rgba(30,60,114,0.1)'"
                                       onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            </div>

                            <button type="submit" 
                                    style="width: 100%; background: linear-gradient(135deg, #1e3c72, #2a5298);
                                           color: white; border: none; padding: 14px; border-radius: 10px; 
                                           font-weight: 600; font-size: 16px; cursor: pointer; 
                                           display: flex; align-items: center; justify-content: center; gap: 8px;
                                           transition: all 0.3s ease;"
                                    onmouseover="this.style.background='linear-gradient(135deg, #2a5298, #1e3c72)'"
                                    onmouseout="this.style.background='linear-gradient(135deg, #1e3c72, #2a5298)'">
                                <span>💾</span> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Warning Modal untuk buku telat --}}
<div id="warningModal" style="display:none; position:fixed; left:0; top:0; width:100%; height:100%; 
     background-color: rgba(0,0,0,0.5); z-index:9999; animation:fadeIn 0.3s ease;">
    <div style="position:fixed; left:50%; top:50%; transform:translate(-50%, -50%); 
         background:white; width:90%; max-width:500px; border-radius:15px; padding:0;
         box-shadow: 0 10px 25px rgba(0,0,0,0.1); animation:slideIn 0.3s ease;">
        <div style="background: #fee2e2; padding: 20px; border-radius: 15px 15px 0 0;">
            <div style="display:flex; align-items:center; gap:12px;">
                <span style="font-size:32px;">⚠️</span>
                <h3 style="color: #dc2626; margin:0; font-size:24px;">PERINGATAN!</h3>
            </div>
        </div>
        
        <div style="padding:20px;">
            <p style="font-size:16px; color:#4b5563; margin-bottom:20px;">
                Anda memiliki buku yang sudah melewati batas waktu pengembalian!
            </p>
            <div style="background:#f3f4f6; padding:15px; border-radius:8px; margin-bottom:20px;">
                <div style="font-weight:600; color:#1e3c72; margin-bottom:8px;">
                    Segera kembalikan buku berikut:
                </div>
                <div id="warningBookList" style="color:#4b5563;">
                    <!-- List buku telat akan di-inject oleh JavaScript -->
                </div>
            </div>
            
            <button onclick="closeWarningModal()" 
                    style="width:100%; background:#dc2626; color:white; border:0; padding:12px; 
                           border-radius:8px; font-weight:600; cursor:pointer; transition:all 0.3s ease;"
                    onmouseover="this.style.background='#b91c1c'"
                    onmouseout="this.style.background='#dc2626'">
                Saya Mengerti
            </button>
        </div>
    </div>
</div>

<script>
function filterBooks() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const categoryFilter = document.getElementById('categoryFilter').value.toLowerCase();
    const authorFilter = document.getElementById('authorFilter').value.toLowerCase();
    const yearFilter = document.getElementById('yearFilter').value;
    const bookCards = document.querySelectorAll('.book-card');
    const searchInfo = document.getElementById('searchInfo');
    const searchInfoText = document.getElementById('searchInfoText');
    
    let visibleCount = 0;
    let totalCount = bookCards.length;

    bookCards.forEach(card => {
        const judul = card.getAttribute('data-judul') || '';
        const penulis = card.getAttribute('data-penulis') || '';
        const kategori = card.getAttribute('data-kategori') || '';
        const tahun = card.getAttribute('data-tahun') || '';

        // Check if matches search (only by title now)
        const matchesSearch = searchInput === '' || judul.includes(searchInput);

        // Check if matches category
        const matchesCategory = categoryFilter === '' || kategori === categoryFilter;

        // Check if matches author
        const matchesAuthor = authorFilter === '' || penulis === authorFilter;

        // Check if matches year
        const matchesYear = yearFilter === '' || tahun === yearFilter;

        if (matchesSearch && matchesCategory && matchesAuthor && matchesYear) {
            card.style.display = 'block';
            visibleCount++;
        } else {
            card.style.display = 'none';
        }
    });

    // Show search info
    if (searchInput !== '' || categoryFilter !== '' || authorFilter !== '' || yearFilter !== '') {
        searchInfo.style.display = 'block';
        let filterText = [];
        
        if (searchInput !== '') filterText.push(`judul "<strong>${searchInput}</strong>"`);
        if (categoryFilter !== '') filterText.push(`kategori "<strong>${categoryFilter}</strong>"`);
        if (authorFilter !== '') {
            const authorSelect = document.getElementById('authorFilter');
            const authorName = authorSelect.options[authorSelect.selectedIndex].text;
            filterText.push(`pengarang "<strong>${authorName}</strong>"`);
        }
        if (yearFilter !== '') filterText.push(`tahun "<strong>${yearFilter}</strong>"`);
        
        searchInfoText.innerHTML = `
            <strong>📊 Hasil Pencarian:</strong> 
            Menampilkan ${visibleCount} dari ${totalCount} buku
            ${filterText.length > 0 ? ' untuk ' + filterText.join(', ') : ''}
        `;
    } else {
        searchInfo.style.display = 'none';
    }

    // Show "no results" message if no books found
    let noResultsMsg = document.getElementById('noResultsMsg');
    if (visibleCount === 0) {
        if (!noResultsMsg) {
            noResultsMsg = document.createElement('div');
            noResultsMsg.id = 'noResultsMsg';
            noResultsMsg.style.cssText = 'grid-column: 1/-1; text-align: center; padding: 60px 20px;';
            noResultsMsg.innerHTML = `
                <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.5;">📚</div>
                <h3 style="color: #1e3c72; font-size: 22px; font-weight: 600; margin-bottom: 10px;">
                    Buku Tidak Ditemukan
                </h3>
                <p style="color: #64748b; font-size: 16px;">
                    Coba gunakan kata kunci lain atau reset filter
                </p>
            `;
            document.getElementById('bookGrid').appendChild(noResultsMsg);
        } else {
            noResultsMsg.style.display = 'block';
        }
    } else {
        if (noResultsMsg) {
            noResultsMsg.style.display = 'none';
        }
    }
}

function resetFilter() {
    document.getElementById('searchInput').value = '';
    document.getElementById('categoryFilter').value = '';
    document.getElementById('authorFilter').value = '';
    document.getElementById('yearFilter').value = '';
    filterBooks();
}

function showTab(tab) {
    // Hapus kelas active dari semua tab
    document.querySelectorAll('.tab-content').forEach(content => {
        content.style.display = 'none';
        content.classList.remove('active');
    });

    // Tampilkan tab yang dipilih dengan animasi
    const selectedTab = document.getElementById('tab-' + tab);
    if (selectedTab) {
        selectedTab.style.display = 'block';
        // Trigger reflow
        selectedTab.offsetHeight;
        selectedTab.classList.add('active');
    }

    // Update active state pada menu buttons
    document.querySelectorAll('.menu-btn').forEach(btn => {
        btn.classList.remove('active');
    });
    
    const activeButton = document.querySelector(`button[onclick="showTab('${tab}')"]`);
    if (activeButton) {
        activeButton.classList.add('active');
    }
}

function showPinjamModal(id, judul, penulis, kategori, tahun, sinopsis, image) {
    document.getElementById('modalTitle').innerText = judul;
    document.getElementById('modalDetails').innerHTML =
        '<div style="margin-bottom:6px;"><b>Penulis:</b> ' + penulis + '</div>' +
        '<div style="margin-bottom:6px;"><b>Kategori:</b> ' + kategori + '</div>' +
        '<div style="margin-bottom:6px;"><b>Tahun:</b> ' + tahun + '</div>' +
        '<div style="margin-bottom:6px;"><b>Sinopsis:</b> ' + sinopsis + '</div>';
    document.getElementById('pinjamForm').action = '/siswa/buku/' + id + '/pinjam';

    // Set default tanggal pinjam & kembali
    let now = new Date();
    let pad = n => n < 10 ? '0'+n : n;
    let local = now.getFullYear() + '-' + pad(now.getMonth()+1) + '-' + pad(now.getDate()) + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
    document.getElementById('tanggal_pinjam').value = local;
    document.getElementById('tanggal_pinjam').min = local;

    let maxDate = new Date(now.getTime() + 3*24*60*60*1000);
    let maxLocal = maxDate.getFullYear() + '-' + pad(maxDate.getMonth()+1) + '-' + pad(maxDate.getDate()) + 'T' + pad(now.getHours()) + ':' + pad(now.getMinutes());
    document.getElementById('tanggal_kembali').value = maxLocal;
    document.getElementById('tanggal_kembali').min = local;
    document.getElementById('tanggal_kembali').max = maxLocal;

    var img = document.getElementById('modalImage');
    var icon = document.getElementById('modalImageIcon');
    if(image && image !== '') {
        img.src = image;
        img.style.display = 'block';
        icon.style.display = 'none';
    } else {
        img.style.display = 'none';
        icon.style.display = 'block';
    }

    document.getElementById('pinjamModal').style.display = 'block';
}
function closePinjamModal() {
    document.getElementById('pinjamModal').style.display = 'none';
}

// Fungsi untuk menampilkan modal warning
function showWarningModal(books) {
    const bookList = books.split(',').map(book => 
        `<div style="display:flex; align-items:center; gap:8px; margin-bottom:4px;">
            <span style="color:#dc2626">📚</span>${book.trim()}
        </div>`
    ).join('');
    
    document.getElementById('warningBookList').innerHTML = bookList;
    document.getElementById('warningModal').style.display = 'block';
}

// Fungsi untuk menutup modal warning
function closeWarningModal() {
    document.getElementById('warningModal').style.display = 'none';
}

// Set tab default dan active state saat halaman dimuat
document.addEventListener('DOMContentLoaded', function() {
    showTab('buku');
    
    setTimeout(function() {
        // Warning jika ada peminjaman yang telat
        var hasLate = document.getElementById('hasLate').value === '1';
        var lateTitles = document.getElementById('lateTitles').value;
        
        if (hasLate && lateTitles) {
            showWarningModal(lateTitles);
        }
    }, 500); // Tambah delay untuk memastikan DOM sudah siap
});
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

#pinjamModal {
    animation: fadeIn 0.2s;
}
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}
@keyframes popIn {
    from { transform: scale(0.95); opacity: 0; }
    to { transform: scale(1); opacity: 1; }
}
#pinjamModal {
    /* No background overlay */
    background: none !important;
    pointer-events: none;
}
#pinjamModal[style*="display: block"] {
    pointer-events: auto;
}
#pinjamModal > div {
    pointer-events: auto;
}

/* Animasi untuk Warning Modal */
@keyframes fadeIn {
    from { opacity: 0; }
    to { opacity: 1; }
}

@keyframes slideIn {
    from { transform: translate(-50%, -60%); opacity: 0; }
    to { transform: translate(-50%, -50%); opacity: 1; }
}
</style>
@endsection
