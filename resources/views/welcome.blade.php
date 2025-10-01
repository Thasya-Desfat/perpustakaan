{{-- 
    FIX: Ganti seluruh isi file ini dengan versi Blade yang benar, 
    jangan gunakan HTML murni + @if + @vite seperti default Laravel 10/11.
    Gunakan @extends('layouts.app') dan @section('content') agar konsisten dengan halaman lain.
--}}
@extends('layouts.app')

@section('title', 'Perpustakaan Digital - Selamat Datang')

@section('content')
{{-- Navbar --}}
<nav style="background: white; position: fixed; width: 100%; top: 0; z-index: 1000; box-shadow: 0 2px 15px rgba(0,0,0,0.05);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 15px 20px; display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 10px;">
            <span style="font-size: 28px;">📚</span>
            <span style="font-size: 20px; font-weight: 700; background: linear-gradient(135deg, #1e3c72, #2a5298); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Perpustakaan Digital</span>
        </div>
        <div style="display: flex; gap: 30px;">
            <a href="#beranda" style="text-decoration: none; color: #1e3c72; font-weight: 600;">Beranda</a>
            <a href="#fitur" style="text-decoration: none; color: #1e3c72; font-weight: 600;">Fitur</a>
            <a href="#tentang" style="text-decoration: none; color: #1e3c72; font-weight: 600;">Tentang</a>
            <a href="#kontak" style="text-decoration: none; color: #1e3c72; font-weight: 600;">Kontak</a>
        </div>
        <div style="display: flex; gap: 15px;">
            @auth
                {{-- Show user info and logout for logged in users --}}
                <div style="display: flex; align-items: center; gap: 15px;">
                    {{-- Profile Info --}}
                    <div style="display: flex; align-items: center; background: #f8fafc; padding: 8px 15px; border-radius: 50px;">
                        @if(Auth::user()->profile_photo)
                            <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}" 
                                 alt="Profile" 
                                 style="width: 32px; height: 32px; border-radius: 50%; object-fit: cover;">
                        @else
                            <span style="width: 32px; height: 32px; background: #e3f2fd; border-radius: 50%; 
                                       display: flex; align-items: center; justify-content: center; color: #1e3c72;">
                                👤
                            </span>
                        @endif
                        <span style="margin-left: 10px; color: #1e3c72;">{{ Auth::user()->name }}</span>
                    </div>

                    {{-- Logout Form --}}
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" 
                                style="padding: 8px 20px; border-radius: 8px; border: none; cursor: pointer;
                                       background: #ef4444; color: white; font-weight: 600;
                                       display: flex; align-items: center; gap: 8px;
                                       transition: all 0.3s ease;"
                                onmouseover="this.style.transform='translateY(-2px)'"
                                onmouseout="this.style.transform='translateY(0)'">
                            <span>🚪</span> Logout
                        </button>
                    </form>

                    {{-- Dashboard Link --}}
                    <a href="{{ Auth::user()->role === 'admin' ? route('admin.dashboard') : route('siswa.dashboard') }}"
                       style="padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
                              background: linear-gradient(135deg, #1e3c72, #2a5298); color: white;
                              display: flex; align-items: center; gap: 8px;
                              transition: all 0.3s ease;"
                       onmouseover="this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.transform='translateY(0)'">
                        <span>📊</span> Dashboard
                    </a>
                </div>
            @else
                {{-- Show login/register for guests --}}
                <a href="{{ route('login') }}" 
                   style="padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
                          color: #1e3c72; border: 2px solid #1e3c72; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#1e3c72'; this.style.color='white'"
                   onmouseout="this.style.background='transparent'; this.style.color='#1e3c72'">
                    <span style="font-size: 16px;">🔑</span> Masuk
                </a>
                <a href="{{ route('register') }}" 
                   style="padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
                          background: linear-gradient(135deg, #1e3c72, #2a5298); color: white;
                          transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                    <span style="font-size: 16px;">✨</span> Daftar
                </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Hero Section --}}
<section id="beranda" style="padding-top: 80px; background: linear-gradient(135deg, #1e3c72, #2a5298); min-height: 100vh; display: flex; align-items: center;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 50px 20px; display: flex; align-items: center; gap: 50px;">
        <div style="flex: 1; color: white;">
            <h1 style="font-size: 48px; font-weight: 800; margin-bottom: 20px; line-height: 1.2;">
                Temukan Dunia Pengetahuan di Perpustakaan Digital
            </h1>
            <p style="font-size: 18px; opacity: 0.9; margin-bottom: 30px; line-height: 1.6;">
                Akses ribuan koleksi buku, artikel, dan sumber belajar digital. Tingkatkan pengetahuan dan wawasan Anda dengan mudah dan menyenangkan.
            </p>
            <div style="display: flex; gap: 20px;">
                <a href="{{ route('register') }}" 
                   style="padding: 15px 30px; background: white; color: #1e3c72; border-radius: 12px; 
                          text-decoration: none; font-weight: 700; display: flex; align-items: center; gap: 8px;
                          transition: all 0.3s ease; box-shadow: 0 10px 25px rgba(0,0,0,0.1);"
                   onmouseover="this.style.transform='translateY(-5px)'"
                   onmouseout="this.style.transform='translateY(0)'">
                    <span style="font-size: 24px;">🚀</span> Mulai Belajar
                </a>
                <a href="#fitur"
                   style="padding: 15px 30px; background: rgba(255,255,255,0.1); color: white; border-radius: 12px;
                          text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 8px;
                          border: 2px solid rgba(255,255,255,0.2); transition: all 0.3s ease;"
                   onmouseover="this.style.background='rgba(255,255,255,0.2)'"
                   onmouseout="this.style.background='rgba(255,255,255,0.1)'">
                    <span style="font-size: 24px;">✨</span> Lihat Fitur
                </a>
            </div>
        </div>
        <div style="flex: 1; position: relative;">
            <div style="position: relative; z-index: 2;">
                <img src="{{ asset('images/library.svg') }}" alt="Library Illustration" 
                     style="width: 100%; max-width: 500px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));
                            animation: float 6s ease-in-out infinite;">
            </div>
            
            <!-- Decorative Floating Elements -->
            <div style="position: absolute; top: -20px; right: -20px; width: 100px; height: 100px; 
                        background: rgba(255,255,255,0.1); border-radius: 50%;
                        animation: float 8s ease-in-out infinite;"></div>
            <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; 
                        background: rgba(255,255,255,0.05); border-radius: 50%;
                        animation: float 10s ease-in-out infinite;"></div>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section style="background: white; padding: 40px 0; box-shadow: 0 -10px 30px rgba(0,0,0,0.1);">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; text-align: center;">
            @foreach([
                ['📚', '1000+', 'Koleksi Buku'],
                ['👥', '500+', 'Siswa Aktif'],
                ['📖', '2000+', 'Peminjaman'],
                ['🏫', '24/7', 'Akses Digital']
            ] as [$icon, $number, $label])
            <div>
                <span style="font-size: 40px;">{{ $icon }}</span>
                <div style="font-size: 36px; font-weight: 800; color: #1e3c72; margin: 10px 0;">{{ $number }}</div>
                <div style="color: #64748b; font-weight: 500;">{{ $label }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Book Catalog Section --}}
<section style="background: #f8fafc; padding: 100px 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            @auth
                @if(Auth::user()->role === 'siswa')
                    <h2 style="font-size: 36px; font-weight: 800; color: #1e3c72; margin-bottom: 15px;">
                        Buku Favorit Anda
                    </h2>
                    <p style="color: #64748b; font-size: 18px; max-width: 600px; margin: 0 auto;">
                        Buku yang mungkin Anda sukai berdasarkan kategori favorit
                    </p>
                @else
                    <h2 style="font-size: 36px; font-weight: 800; color: #1e3c72; margin-bottom: 15px;">
                        Koleksi Buku Terbaru
                    </h2>
                    <p style="color: #64748b; font-size: 18px; max-width: 600px; margin: 0 auto;">
                        Jelajahi koleksi buku terbaru kami yang telah dipilih khusus untuk Anda
                    </p>
                @endif
            @else
                <h2 style="font-size: 36px; font-weight: 800; color: #1e3c72; margin-bottom: 15px;">
                    Koleksi Buku Terbaru
                </h2>
                <p style="color: #64748b; font-size: 18px; max-width: 600px; margin: 0 auto;">
                    Jelajahi koleksi buku terbaru kami yang telah dipilih khusus untuk Anda
                </p>
            @endauth
        </div>

        {{-- Book Grid --}}
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
            @auth
                @if(Auth::user()->role === 'siswa')
                    @php
                        // Ambil semua peminjaman user, group by buku_id, hitung jumlahnya
                        $borrowedBooks = Auth::user()->peminjamans()
                            ->with('buku')
                            ->get()
                            ->groupBy('buku_id')
                            ->map(function($group) {
                                return [
                                    'count' => $group->count(),
                                    'buku' => $group->first()->buku
                                ];
                            })
                            ->sortByDesc('count')
                            ->values(); // <-- penting: reset index ke 0,1,2 dst

                        // Rank badges
                        $rankBadges = [
                            0 => ['emoji' => '👑', 'label' => 'Paling Favorit', 'gradient' => 'linear-gradient(135deg, #FFD700, #FFA500)'],
                            1 => ['emoji' => '🥈', 'label' => 'Favorit Kedua', 'gradient' => 'linear-gradient(135deg, #C0C0C0, #A9A9A9)'],
                            2 => ['emoji' => '🥉', 'label' => 'Favorit Ketiga', 'gradient' => 'linear-gradient(135deg, #CD7F32, #8B4513)']
                        ];
                    @endphp

                    @foreach($borrowedBooks->take(6) as $index => $data)
                        @php $buku = $data['buku']; @endphp
                        <div style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease;
                                    box-shadow: 0 4px 15px rgba(0,0,0,0.05); position: relative;"
                             onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                            
                            {{-- Ranking Badge --}}
                            @if(isset($rankBadges[$index]))
                                <div style="position: absolute; top: -10px; right: 10px; z-index: 10;
                                            padding: 8px 15px; border-radius: 20px;
                                            background: {{ $rankBadges[$index]['gradient'] }};
                                            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
                                            display: flex; align-items: center; gap: 8px;">
                                    <span style="font-size: 24px;">{{ $rankBadges[$index]['emoji'] }}</span>
                                    <span style="color: white; font-weight: 600; font-size: 14px;">
                                        {{ $rankBadges[$index]['label'] }}
                                    </span>
                                </div>
                            @endif

                            {{-- Book Image/Cover --}}
                            <div style="height: 200px; background: linear-gradient(135deg, #1e3c72, #2a5298); position: relative;">
                                @if($buku->image)
                                    <img src="{{ asset('storage/'.$buku->image) }}" 
                                         alt="{{ $buku->judul }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                                font-size: 48px;">📚</div>
                                @endif
                            </div>
                            
                            {{-- Book Info --}}
                            <div style="padding: 25px;">
                                {{-- Category Badge --}}
                                <div style="background: #e3f2fd; color: #1e3c72; display: inline-block;
                                            padding: 6px 12px; border-radius: 15px; font-size: 14px;
                                            margin-bottom: 15px;">
                                    <span style="margin-right: 5px;">📑</span>{{ ucfirst($buku->kategori) }}
                                </div>

                                {{-- Number of Times Borrowed --}}
                                <div style="position: absolute; top: 15px; left: 15px; 
                                            background: rgba(255,255,255,0.9); padding: 5px 12px;
                                            border-radius: 15px; display: flex; align-items: center; gap: 5px;
                                            box-shadow: 0 2px 10px rgba(0,0,0,0.1);">
                                    <span style="font-size: 14px;">📖</span>
                                    <span style="color: #1e3c72; font-weight: 600; font-size: 14px;">
                                        Dipinjam {{ $data['count'] }}x
                                    </span>
                                </div>

                                {{-- Title --}}
                                <h3 style="color: #1e3c72; font-size: 20px; font-weight: 700; margin: 0 0 10px 0;
                                           display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
                                           overflow: hidden;">{{ $buku->judul }}</h3>

                                {{-- Author & Year --}}
                                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                    <div style="display: flex; align-items: center; gap: 5px; color: #64748b;">
                                        <span>👤</span>
                                        <span>{{ $buku->penulis }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 5px; color: #64748b;">
                                        <span>📅</span>
                                        <span>{{ $buku->tahun_terbit }}</span>
                                    </div>
                                </div>

                                {{-- Synopsis Preview --}}
                                <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;
                                          display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;
                                          overflow: hidden;">
                                    <span style="margin-right: 5px;">📖</span>
                                    {{ $buku->sinopsis }}
                                </p>

                                {{-- Pinjam Buku Button --}}
                                <a href="{{ route('siswa.dashboard') }}"
                                   style="display: block; text-align: center; background: linear-gradient(135deg, #1e3c72, #2a5298);
                                          color: white; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600;
                                          transition: all 0.3s ease;">
                                    <span style="margin-right: 5px;">📚</span>
                                    Pinjam Buku
                                </a>
                            </div>
                        </div>
                    @endforeach
                @else
                    {{-- Show regular books for non-siswa users --}}
                    @foreach(\App\Models\Buku::latest()->take(6)->get() as $buku)
                        <div style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease;
                                box-shadow: 0 4px 15px rgba(0,0,0,0.05);"
                             onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'"
                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                            
                            {{-- Book Image/Cover --}}
                            <div style="height: 200px; background: linear-gradient(135deg, #1e3c72, #2a5298); position: relative;">
                                @if($buku->image)
                                    <img src="{{ asset('storage/'.$buku->image) }}" 
                                         alt="{{ $buku->judul }}"
                                         style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                                font-size: 48px;">📚</div>
                                @endif
                            </div>
                            
                            {{-- Book Info --}}
                            <div style="padding: 25px;">
                                {{-- Category Badge --}}
                                <div style="background: #e3f2fd; color: #1e3c72; display: inline-block;
                                            padding: 6px 12px; border-radius: 15px; font-size: 14px;
                                            margin-bottom: 15px;">
                                    <span style="margin-right: 5px;">📑</span>{{ ucfirst($buku->kategori) }}
                                </div>

                                {{-- Title --}}
                                <h3 style="color: #1e3c72; font-size: 20px; font-weight: 700; margin: 0 0 10px 0;
                                           display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
                                           overflow: hidden;">{{ $buku->judul }}</h3>

                                {{-- Author & Year --}}
                                <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                    <div style="display: flex; align-items: center; gap: 5px; color: #64748b;">
                                        <span>👤</span>
                                        <span>{{ $buku->penulis }}</span>
                                    </div>
                                    <div style="display: flex; align-items: center; gap: 5px; color: #64748b;">
                                        <span>📅</span>
                                        <span>{{ $buku->tahun_terbit }}</span>
                                    </div>
                                </div>

                                {{-- Synopsis Preview --}}
                                <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;
                                          display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;
                                          overflow: hidden;">
                                    <span style="margin-right: 5px;">📖</span>
                                    {{ $buku->sinopsis }}
                                </p>

                                {{-- Login to Borrow Button --}}
                                <a href="{{ route('login') }}"
                                   style="display: block; text-align: center; background: linear-gradient(135deg, #1e3c72, #2a5298);
                                          color: white; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600;
                                          transition: all 0.3s ease;">
                                    <span style="margin-right: 5px;">📚</span>
                                    Pinjam Buku
                                </a>
                            </div>
                        </div>
                    @endforeach
                @endif
            @else
                {{-- Show regular books for guests --}}
                @foreach(\App\Models\Buku::latest()->take(6)->get() as $buku)
                    <div style="background: white; border-radius: 20px; overflow: hidden; transition: all 0.3s ease;
                                box-shadow: 0 4px 15px rgba(0,0,0,0.05);"
                         onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'"
                         onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                        
                        {{-- Book Image/Cover --}}
                        <div style="height: 200px; background: linear-gradient(135deg, #1e3c72, #2a5298); position: relative;">
                            @if($buku->image)
                                <img src="{{ asset('storage/'.$buku->image) }}" 
                                     alt="{{ $buku->judul }}"
                                     style="width: 100%; height: 100%; object-fit: cover;">
                            @else
                                <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); 
                                            font-size: 48px;">📚</div>
                            @endif
                        </div>
                        
                        {{-- Book Info --}}
                        <div style="padding: 25px;">
                            {{-- Category Badge --}}
                            <div style="background: #e3f2fd; color: #1e3c72; display: inline-block;
                                        padding: 6px 12px; border-radius: 15px; font-size: 14px;
                                        margin-bottom: 15px;">
                                <span style="margin-right: 5px;">📑</span>{{ ucfirst($buku->kategori) }}
                            </div>

                            {{-- Title --}}
                            <h3 style="color: #1e3c72; font-size: 20px; font-weight: 700; margin: 0 0 10px 0;
                                       display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;
                                       overflow: hidden;">{{ $buku->judul }}</h3>

                            {{-- Author & Year --}}
                            <div style="display: flex; gap: 15px; margin-bottom: 15px;">
                                <div style="display: flex; align-items: center; gap: 5px; color: #64748b;">
                                    <span>👤</span>
                                    <span>{{ $buku->penulis }}</span>
                                </div>
                                <div style="display: flex; align-items: center; gap: 5px; color: #64748b;">
                                    <span>📅</span>
                                    <span>{{ $buku->tahun_terbit }}</span>
                                </div>
                            </div>

                            {{-- Synopsis Preview --}}
                            <p style="color: #64748b; font-size: 14px; line-height: 1.6; margin-bottom: 20px;
                                      display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical;
                                      overflow: hidden;">
                                <span style="margin-right: 5px;">📖</span>
                                {{ $buku->sinopsis }}
                            </p>

                            {{-- Login to Borrow Button --}}
                            <a href="{{ route('login') }}"
                               style="display: block; text-align: center; background: linear-gradient(135deg, #1e3c72, #2a5298);
                                      color: white; text-decoration: none; padding: 12px; border-radius: 10px; font-weight: 600;
                                      transition: all 0.3s ease;">
                                <span style="margin-right: 5px;">📚</span>
                                Pinjam Buku
                            </a>
                        </div>
                    </div>
                @endforeach
            @endauth
        </div>

        {{-- View All Books Button --}}
        <div style="text-align: center; margin-top: 50px;">
            @auth
                @if(Auth::user()->role === 'siswa')
                    <a href="{{ route('siswa.dashboard') }}"
                       style="display: inline-flex; align-items: center; gap: 10px;
                              background: white; color: #1e3c72; text-decoration: none;
                              padding: 15px 30px; border-radius: 12px; font-weight: 700;
                              box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease;"
                       onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                        <span style="font-size: 24px;">📚</span>
                        Lihat Semua Buku di Dashboard
                        <span style="font-size: 24px;">→</span>
                    </a>
                @else
                    <a href="{{ route('login') }}"
                       style="display: inline-flex; align-items: center; gap: 10px;
                              background: white; color: #1e3c72; text-decoration: none;
                              padding: 15px 30px; border-radius: 12px; font-weight: 700;
                              box-shadow: 0 4px 15px rgba(0,0,0,0.05); transition: all 0.3s ease;"
                       onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'"
                       onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                        <span style="font-size: 24px;">📚</span>
                        Lihat Semua Buku
                        <span style="font-size: 24px;">→</span>
                    </a>
                @endif
            @else
                <a href="{{ route('login') }}" 
                   style="padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
                          color: #1e3c72; border: 2px solid #1e3c72; transition: all 0.3s ease;"
                   onmouseover="this.style.background='#1e3c72'; this.style.color='white'"
                   onmouseout="this.style.background='transparent'; this.style.color='#1e3c72'">
                    <span style="font-size: 16px;">🔑</span> Masuk
                </a>
                <a href="{{ route('register') }}" 
                   style="padding: 8px 20px; border-radius: 8px; text-decoration: none; font-weight: 600;
                          background: linear-gradient(135deg, #1e3c72, #2a5298); color: white;
                          transition: all 0.3s ease; box-shadow: 0 4px 15px rgba(0,0,0,0.1);"
                   onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'"
                   onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'">
                    <span style="font-size: 16px;">✨</span> Daftar
                </a>
            @endauth
        </div>
    </div>
</section>

{{-- Features Section --}}
<section id="fitur" style="background: #f8fafc; padding: 100px 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 800; color: #1e3c72; margin-bottom: 15px;">
                Fitur Unggulan
            </h2>
            <p style="color: #64748b; font-size: 18px; max-width: 600px; margin: 0 auto;">
                Nikmati berbagai fitur canggih yang memudahkan proses belajar dan membaca Anda
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 30px;">
            @foreach([
                ['📚', 'Koleksi Digital', 'Akses ribuan buku dalam format digital yang dapat dibaca kapan saja'],
                ['🔍', 'Pencarian Cerdas', 'Temukan buku yang Anda cari dengan sistem pencarian yang canggih'],
                ['📱', 'Akses Multi-Platform', 'Baca melalui berbagai perangkat, dari komputer hingga smartphone'],
                ['📋', 'Peminjaman Online', 'Pinjam dan kembalikan buku secara online dengan mudah'],
                ['📊', 'Tracking Progress', 'Pantau aktivitas membaca dan progress pembelajaran Anda'],
                ['🎯', 'Rekomendasi Pintar', 'Dapatkan rekomendasi buku sesuai minat dan kebutuhan Anda']
            ] as [$icon, $title, $desc])
            <div style="background: white; padding: 30px; border-radius: 20px; transition: all 0.3s ease;
                        box-shadow: 0 4px 15px rgba(0,0,0,0.05);"
                 onmouseover="this.style.transform='translateY(-10px)'; this.style.boxShadow='0 15px 30px rgba(0,0,0,0.1)'"
                 onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.05)'">
                <span style="font-size: 40px;">{{ $icon }}</span>
                <h3 style="color: #1e3c72; font-size: 20px; font-weight: 700; margin: 15px 0;">{{ $title }}</h3>
                <p style="color: #64748b; line-height: 1.6;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- About Section --}}
<section id="tentang" style="background: white; padding: 100px 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 800; color: #1e3c72; margin-bottom: 15px;">
                Tentang Kami
            </h2>
            <p style="color: #64748b; font-size: 18px; max-width: 800px; margin: 0 auto; line-height: 1.6;">
                Perpustakaan Digital adalah solusi modern untuk kebutuhan pembelajaran di era digital. 
                Kami berkomitmen untuk menyediakan akses mudah ke berbagai sumber pengetahuan berkualitas.
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px;">
            @foreach([
                ['🎯', 'Visi', 'Menjadi pusat pembelajaran digital terdepan yang mendukung pendidikan berkualitas'],
                ['🚀', 'Misi', 'Menyediakan akses mudah ke sumber belajar digital bagi seluruh siswa'],
                ['💫', 'Tujuan', 'Membangun generasi yang gemar membaca dan berwawasan luas']
            ] as [$icon, $title, $desc])
            <div style="text-align: center; padding: 30px; border-radius: 20px; 
                        background: linear-gradient(135deg, #f8fafc, #f1f5f9);">
                <span style="font-size: 48px;">{{ $icon }}</span>
                <h3 style="color: #1e3c72; font-size: 24px; font-weight: 700; margin: 15px 0;">{{ $title }}</h3>
                <p style="color: #64748b; line-height: 1.6;">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Feedback Section --}}
<section id="feedback" style="background: #fff; padding: 80px 0 60px 0;">
    <div style="max-width: 900px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 35px;">
            <h2 style="font-size: 32px; font-weight: 800; color: #1e3c72; margin-bottom: 10px;">
                Kirim Feedback
            </h2>
            <p style="color: #64748b; font-size: 16px;">
                Berikan penilaian dan saran Anda untuk website atau koleksi buku kami!
            </p>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 30px; justify-content: center;">
            {{-- Card 1: Feedback Website --}}
            <div style="flex:1 1 350px; background: #f8fafc; border-radius: 16px; padding: 30px; box-shadow: 0 2px 10px rgba(30,60,114,0.06); min-width:320px; max-width:400px;">
                <h3 style="color:#1e3c72; font-size:20px; font-weight:700; margin-bottom:18px;">Feedback Website</h3>
                @if(session('success_website'))
                    <div id="popupSuccessWebsite" style="background:#e8f5e9;color:#22c55e;border-radius:8px;padding:12px 20px;text-align:center;margin-bottom:18px;">
                        {{ session('success_website') }}
                    </div>
                    @php
                        $lastFeedback = \App\Models\Feedback::where('user_id', Auth::id())->where('type','website')->latest()->first();
                    @endphp
                    @if($lastFeedback)
                        <div style="background: #fff; border-radius: 12px; padding: 18px; margin-bottom: 15px; box-shadow: 0 2px 10px rgba(30,60,114,0.04);">
                            <div style="font-weight:700; color:#1e3c72; margin-bottom:8px;">Feedback Anda:</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Nama:</span> {{ $lastFeedback->nama }}</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Email:</span> {{ $lastFeedback->email }}</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Rating:</span> {{ $lastFeedback->rating ? $lastFeedback->rating . ' ⭐' : '-' }}</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Pesan:</span> {{ $lastFeedback->pesan }}</div>
                            <div style="font-size:12px; color:#64748b;">Dikirim pada: {{ $lastFeedback->created_at->format('d M Y H:i') }}</div>
                        </div>
                    @endif
                @endif
                <form method="POST" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="website">
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Nama</label>
                        <input type="text" name="nama" value="{{ Auth::check() ? Auth::user()->name : old('nama') }}" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Email</label>
                        <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Rating Website (1-5)</label>
                        <select name="rating" style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                            <option value="">Pilih rating</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}" {{ old('rating')==$i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>
                    <div style="margin-bottom: 18px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Pesan / Saran</label>
                        <textarea name="pesan" rows="3" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">{{ old('pesan') }}</textarea>
                    </div>
                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white;padding:12px;border:none;border-radius:10px;font-weight:700;font-size:15px;cursor:pointer;">
                        <span style="margin-right: 6px;">📩</span> Kirim Feedback
                    </button>
                </form>
            </div>
            {{-- Card 2: Feedback Buku --}}
            <div style="flex:1 1 350px; background: #f8fafc; border-radius: 16px; padding: 30px; box-shadow: 0 2px 10px rgba(30,60,114,0.06); min-width:320px; max-width:400px;">
                <h3 style="color:#1e3c72; font-size:20px; font-weight:700; margin-bottom:18px;">Feedback Buku</h3>
                @if(session('success_buku'))
                    <div id="popupSuccessBuku" style="background:#e8f5e9;color:#22c55e;border-radius:8px;padding:12px 20px;text-align:center;margin-bottom:18px;">
                        {{ session('success_buku') }}
                    </div>
                    @php
                        $lastBookFeedback = \App\Models\Feedback::where('user_id', Auth::id())->where('type','buku')->latest()->first();
                    @endphp
                    @if($lastBookFeedback)
                        <div style="background: #fff; border-radius: 12px; padding: 18px; margin-bottom: 15px; box-shadow: 0 2px 10px rgba(30,60,114,0.04);">
                            <div style="font-weight:700; color:#1e3c72; margin-bottom:8px;">Feedback Anda:</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Nama:</span> {{ $lastBookFeedback->nama }}</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Email:</span> {{ $lastBookFeedback->email }}</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Buku:</span> 
                                @if($lastBookFeedback->buku_id)
                                    @php $buku = \App\Models\Buku::find($lastBookFeedback->buku_id); @endphp
                                    {{ $buku ? $buku->judul : '-' }}
                                @else
                                    -
                                @endif
                            </div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Rating:</span> {{ $lastBookFeedback->rating ? $lastBookFeedback->rating . ' ⭐' : '-' }}</div>
                            <div style="margin-bottom:8px;"><span style="font-weight:600;">Pesan:</span> {{ $lastBookFeedback->pesan }}</div>
                            <div style="font-size:12px; color:#64748b;">Dikirim pada: {{ $lastBookFeedback->created_at->format('d M Y H:i') }}</div>
                            @if(isset($buku) && $buku && $buku->image)
                                <div style="margin-top:10px;">
                                    <img src="{{ asset('storage/'.$buku->image) }}" alt="cover buku" style="width:60px;height:80px;object-fit:cover;border-radius:6px;">
                                </div>
                            @endif
                        </div>
                    @endif
                @endif
                <form method="POST" action="{{ route('feedback.store') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="type" value="buku">
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Nama</label>
                        <input type="text" name="nama" value="{{ Auth::check() ? Auth::user()->name : old('nama') }}" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Email</label>
                        <input type="email" name="email" value="{{ Auth::check() ? Auth::user()->email : old('email') }}" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Buku</label>
                        <select name="buku_id" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                            <option value="">Pilih Buku</option>
                            @foreach(\App\Models\Buku::orderBy('judul')->get() as $buku)
                                <option value="{{ $buku->id }}" {{ old('buku_id')==$buku->id ? 'selected' : '' }}>
                                    {{ $buku->judul }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="margin-bottom: 14px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Rating Buku (1-5)</label>
                        <select name="rating" style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">
                            <option value="">Pilih rating</option>
                            @for($i=1;$i<=5;$i++)
                                <option value="{{ $i }}" {{ old('rating')==$i ? 'selected' : '' }}>{{ $i }} ⭐</option>
                            @endfor
                        </select>
                    </div>
                    <div style="margin-bottom: 18px;">
                        <label style="color: #1e3c72; font-weight: 600; margin-bottom: 6px; display: block;">Pesan / Saran</label>
                        <textarea name="pesan" rows="3" required style="width:100%;padding:10px 12px;border-radius:8px;border:1px solid #e2e8f0;">{{ old('pesan') }}</textarea>
                    </div>
                    <button type="submit" style="width:100%;background:linear-gradient(135deg,#1e3c72,#2a5298);color:white;padding:12px;border:none;border-radius:10px;font-weight:700;font-size:15px;cursor:pointer;">
                        <span style="margin-right: 6px;">📩</span> Kirim Feedback Buku
                    </button>
                </form>

                {{-- Tampilkan semua feedback buku user --}}
                @php
                    $feedbackBukuList = Auth::check()
                        ? \App\Models\Feedback::where('type','buku')->where('user_id', Auth::id())->latest()->get()
                        : [];
                @endphp
                @if(count($feedbackBukuList))
                    <div style="margin-top:28px;">
                        <div style="font-weight:700;color:#1e3c72;margin-bottom:10px;">Daftar Feedback Buku Anda:</div>
                        @foreach($feedbackBukuList as $fb)
                            @php $buku = \App\Models\Buku::find($fb->buku_id); @endphp
                            <div style="background:#fff;border-radius:12px;padding:16px;margin-bottom:14px;box-shadow:0 2px 10px rgba(30,60,114,0.04);">
                                <div style="display:flex;align-items:center;gap:12px;">
                                    @if($buku && $buku->image)
                                        <img src="{{ asset('storage/'.$buku->image) }}" alt="cover buku" style="width:40px;height:55px;object-fit:cover;border-radius:5px;">
                                    @else
                                        <div style="width:40px;height:55px;display:flex;align-items:center;justify-content:center;font-size:22px;background:#f1f5f9;border-radius:5px;">📚</div>
                                    @endif
                                    <div>
                                        <div style="font-weight:600;color:#1e3c72;">{{ $buku ? $buku->judul : '-' }}</div>
                                        <div style="font-size:13px;color:#64748b;">{{ $fb->created_at->format('d M Y H:i') }}</div>
                                    </div>
                                </div>
                                <div style="margin-top:8px;">
                                    <span style="font-weight:600;">Rating:</span> {{ $fb->rating ? $fb->rating . ' ⭐' : '-' }}
                                </div>
                                <div style="margin-top:4px;">
                                    <span style="font-weight:600;">Pesan:</span> {{ $fb->pesan }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>
<script>
    // Pop up hilang otomatis setelah 2.5 detik
    window.addEventListener('DOMContentLoaded', function() {
        if(document.getElementById('popupSuccessWebsite')) {
            setTimeout(function(){ document.getElementById('popupSuccessWebsite').style.display='none'; }, 2500);
        }
        if(document.getElementById('popupSuccessBuku')) {
            setTimeout(function(){ document.getElementById('popupSuccessBuku').style.display='none'; }, 2500);
        }
    });
</script>

{{-- Contact Section --}}
<section id="kontak" style="background: #f8fafc; padding: 100px 0;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="text-align: center; margin-bottom: 60px;">
            <h2 style="font-size: 36px; font-weight: 800; color: #1e3c72; margin-bottom: 15px;">
                Hubungi Kami
            </h2>
            <p style="color: #64748b; font-size: 18px;">
                Ada pertanyaan? Jangan ragu untuk menghubungi kami
            </p>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 30px; text-align: center;">
            @foreach([
                ['📍', 'Alamat', 'Jl. Pendidikan No. 123, Kota Bandung'],
                ['📧', 'Email', 'perpustakaan@sekolah.ac.id'],
                ['📞', 'Telepon', '(022) 123-4567'],
                ['⏰', 'Jam Operasional', 'Senin - Jumat: 08:00 - 16:00']
            ] as [$icon, $title, $info])
            <div style="background: white; padding: 30px; border-radius: 20px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                <span style="font-size: 40px;">{{ $icon }}</span>
                <h3 style="color: #1e3c72; font-size: 20px; font-weight: 700; margin: 15px 0;">{{ $title }}</h3>
                <p style="color: #64748b;">{{ $info }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Footer --}}
<footer style="background: #1e3c72; color: white; padding: 60px 0 30px;">
    <div style="max-width: 1200px; margin: 0 auto; padding: 0 20px;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 40px; margin-bottom: 50px;">
            <div>
                <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                    <span style="font-size: 32px;">📚</span>
                    <span style="font-size: 24px; font-weight: 700;">Perpustakaan Digital</span>
                </div>
                <p style="color: rgba(255,255,255,0.8); line-height: 1.6;">
                    Memberikan akses mudah ke dunia pengetahuan melalui teknologi digital yang inovatif.
                </p>
            </div>
            
            <div>
                <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Menu</h4>
                <div style="display: flex; flex-direction: column; gap: 10px;">
                    <a href="#beranda" style="color: rgba(255,255,255,0.8); text-decoration: none;">Beranda</a>
                    <a href="#fitur" style="color: rgba(255,255,255,0.8); text-decoration: none;">Fitur</a>
                    <a href="#tentang" style="color: rgba(255,255,255,0.8); text-decoration: none;">Tentang</a>
                    <a href="#kontak" style="color: rgba(255,255,255,0.8); text-decoration: none;">Kontak</a>
                </div>
            </div>
            
            <div>
                <h4 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">Ikuti Kami</h4>
                <div style="display: flex; gap: 15px;">
                    <a href="#" style="color: white; text-decoration: none; font-size: 24px;">📱</a>
                    <a href="#" style="color: white; text-decoration: none; font-size: 24px;">📷</a>
                    <a href="#" style="color: white; text-decoration: none; font-size: 24px;">📨</a>
                    <a href="#" style="color: white; text-decoration: none; font-size: 24px;">🌐</a>
                </div>
            </div>
        </div>
        
        <div style="text-align: center; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1);">
            <p style="color: rgba(255,255,255,0.6);">
                © {{ date('Y') }} Perpustakaan Digital. All rights reserved.
            </p>
        </div>
    </div>
</footer>

<style>
/* Smooth Scroll */
html {
    scroll-behavior: smooth;
}

/* Navbar Link Hover Effect */
nav a {
    position: relative;
}

nav a::after {
    content: '';
    position: absolute;
    bottom: -5px;
    left: 0;
    width: 0;
    height: 2px;
    background: #1e3c72;
    transition: width 0.3s ease;
}

nav a:hover::after {
    width: 100%;
}

/* Button Hover Effects */
a[href="{{ route('login') }}"]:hover {
    background: #1e3c72;
    color: white;
}

a[href="{{ route('register') }}"]:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(30,60,114,0.3);
}

/* Section Transitions */
section {
    transition: transform 0.6s ease-out;
}

section:hover {
    transform: translateY(-5px);
}

/* Stats Counter Animation */
@keyframes countUp {
    from { transform: translateY(20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.stats-item {
    animation: countUp 1s ease-out forwards;
}

/* Floating Animation for Illustration */
@keyframes float {
    0%, 100% { transform: translateY(0) rotate(0deg); }
    50% { transform: translateY(-20px) rotate(2deg); }
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    #beranda > div {
        flex-direction: column;
        text-align: center;
    }
    
    #beranda img {
        margin: 40px auto 0;
    }
}
</style>

@endsection
