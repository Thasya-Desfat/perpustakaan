<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $buku->judul }} - Detail Buku</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Navigation */
        .nav-header {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 10px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }

        .page-title {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Detail Content */
        .detail-content {
            background: white;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .detail-grid {
            display: grid;
            grid-template-columns: 400px 1fr;
            gap: 0;
        }

        /* Book Image Section */
        .image-section {
            background: linear-gradient(135deg, #f8f9ff 0%, #f0f2ff 100%);
            padding: 50px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border-right: 1px solid #e5e7eb;
        }

        .book-image {
            width: 100%;
            max-width: 300px;
            height: 420px;
            object-fit: cover;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            margin-bottom: 30px;
        }

        .book-status {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .status-tersedia {
            background: #d1fae5;
            color: #065f46;
        }

        .status-dipinjam {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Info Section */
        .info-section {
            padding: 50px;
        }

        .book-title {
            font-size: 36px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 30px;
            line-height: 1.2;
        }

        .meta-info-grid {
            display: grid;
            grid-template-columns: 1fr 300px;
            gap: 40px;
            margin-bottom: 40px;
        }

        .meta-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .meta-item-box {
            display: flex;
            flex-direction: column;
        }

        .meta-item-label {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
        }

        .meta-icon {
            font-size: 18px;
        }

        .meta-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .meta-value {
            color: #1e293b;
            font-size: 16px;
            font-weight: 600;
            padding-left: 26px;
        }

        .section-title {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sinopsis-text {
            color: #475569;
            line-height: 1.8;
            font-size: 16px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            flex: 1;
            min-width: 200px;
            padding: 16px 32px;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        .btn-primary:disabled {
            background: #cbd5e1;
            cursor: not-allowed;
            transform: none;
        }

        .btn-favorite {
            background: white;
            color: #dc2626;
            border: 2px solid #dc2626;
        }

        .btn-favorite:hover {
            background: #dc2626;
            color: white;
        }

        .btn-favorite.active {
            background: #dc2626;
            color: white;
        }

        .disabled-message {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            color: #92400e;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pengarang-section {
            margin-bottom: 30px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
        }

        .pengarang-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .pengarang-icon {
            font-size: 20px;
        }

        .pengarang-label {
            font-weight: 600;
            color: #475569;
        }

        .pengarang-value {
            color: #1e293b;
            font-size: 18px;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .detail-grid {
                grid-template-columns: 1fr;
            }

            .image-section {
                border-right: none;
                border-bottom: 1px solid #e5e7eb;
                padding: 40px 30px;
            }

            .info-section {
                padding: 40px 30px;
            }

            .book-title {
                font-size: 28px;
            }

            .meta-info-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }

        @media (max-width: 768px) {
            .nav-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                min-width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Navigation -->
        <div class="nav-header">
            <a href="{{ route('siswa.dashboard') }}" class="back-button">
                <span>←</span>
                <span>Kembali ke Dashboard</span>
            </a>
            <div class="page-title">📖 Detail Buku</div>
        </div>

        <!-- Detail Content -->
        <div class="detail-content">
            <div class="detail-grid">
                <!-- Image Section -->
                <div class="image-section">
                    @if($buku->image)
                        <img src="{{ asset('storage/' . $buku->image) }}" alt="{{ $buku->judul }}" class="book-image">
                    @else
                        <img src="https://via.placeholder.com/300x420/667eea/ffffff?text=No+Image" alt="No Image" class="book-image">
                    @endif
                    
                    <div class="book-status {{ $buku->stok > 0 ? 'status-tersedia' : 'status-dipinjam' }}">
                        {{ $buku->stok > 0 ? '✓ Tersedia' : '✗ Tidak Tersedia' }}
                    </div>
                    
                    <div style="font-size: 14px; color: #64748b; font-weight: 600;">
                        Stok: {{ $buku->stok }} buku
                    </div>
                </div>

                <!-- Info Section -->
                <div class="info-section">
                    <!-- Error/Success Messages -->
                    @if(session('success'))
                        <div style="background: #d1fae5; border: 1px solid #10b981; color: #065f46; 
                                    padding: 15px 20px; border-radius: 10px; margin-bottom: 20px;
                                    display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 20px;">✓</span>
                            <span>{{ session('success') }}</span>
                        </div>
                    @endif

                    @if(session('error'))
                        <div style="background: #fee2e2; border: 1px solid #ef4444; color: #991b1b; 
                                    padding: 15px 20px; border-radius: 10px; margin-bottom: 20px;
                                    display: flex; align-items: center; gap: 10px;">
                            <span style="font-size: 20px;">⚠️</span>
                            <span>{{ session('error') }}</span>
                        </div>
                    @endif

                    <h1 class="book-title" style="margin-bottom: 15px;">{{ $buku->judul }}</h1>
                    
                    <!-- ID Buku -->
                    <div style="margin-bottom: 40px;">
                        <span style="background: #e3f2fd; color: #1e3c72; padding: 8px 16px; border-radius: 8px; 
                                     font-size: 14px; font-weight: 600; display: inline-flex; align-items: center; gap: 8px;">
                            <span>🆔</span>
                            <span>ID Buku: #{{ str_pad($buku->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </span>
                    </div>

                    <!-- Grid Layout: Sinopsis & Meta Info -->
                    <div class="meta-info-grid">
                        <!-- Left Column: Sinopsis -->
                        <div>
                            <div class="section-title">
                                <span>📖</span>
                                <span>Sinopsis</span>
                            </div>
                            <div class="sinopsis-text">
                                {{ $buku->sinopsis ?? 'Tidak ada sinopsis yang tersedia untuk buku ini.' }}
                            </div>
                        </div>

                        <!-- Right Column: Meta Info -->
                        <div class="meta-column">
                            <div class="meta-item-box">
                                <div class="meta-item-label">
                                    <span class="meta-icon">�</span>
                                    <span class="meta-label">Pengarang</span>
                                </div>
                                <div class="meta-value">{{ $buku->penulis }}</div>
                            </div>

                            <div class="meta-item-box">
                                <div class="meta-item-label">
                                    <span class="meta-icon">�</span>
                                    <span class="meta-label">Tahun Terbit</span>
                                </div>
                                <div class="meta-value">{{ $buku->tahun_terbit }}</div>
                            </div>

                            <div class="meta-item-box">
                                <div class="meta-item-label">
                                    <span class="meta-icon">�</span>
                                    <span class="meta-label">Kategori</span>
                                </div>
                                <div class="meta-value">{{ ucfirst($buku->kategori) }}</div>
                            </div>

                            <div class="meta-item-box">
                                <div class="meta-item-label">
                                    <span class="meta-icon">�</span>
                                    <span class="meta-label">Stok Tersedia</span>
                                </div>
                                <div class="meta-value">{{ $buku->stok }} buku</div>
                            </div>
                        </div>
                    </div>

                    @if($activePeminjaman)
                        <div class="disabled-message">
                            <span>⚠️</span>
                            <span>
                                @if($activePeminjaman->status == 'menunggu_konfirmasi')
                                    Anda sudah mengajukan peminjaman buku ini dan sedang menunggu konfirmasi.
                                @else
                                    Anda sedang meminjam buku ini.
                                @endif
                            </span>
                        </div>
                    @endif

                    <div class="action-buttons">
                        <a href="{{ route('siswa.buku.pinjam.form', $buku->id) }}" 
                           class="btn btn-primary {{ ($buku->stok <= 0 || $activePeminjaman) ? 'disabled' : '' }}"
                           style="{{ ($buku->stok <= 0 || $activePeminjaman) ? 'pointer-events: none; opacity: 0.6;' : '' }}">
                            <span>📚</span>
                            <span>
                                @if($activePeminjaman)
                                    Sudah Dipinjam
                                @elseif($buku->stok <= 0)
                                    Stok Habis
                                @else
                                    Pinjam Buku
                                @endif
                            </span>
                        </a>

                        <form action="{{ route('siswa.toggleFavorite', $buku->id) }}" method="POST" style="flex: 1;">
                            @csrf
                            <button type="submit" class="btn btn-favorite {{ $isFavorite ? 'active' : '' }}">
                                <span>{{ $isFavorite ? '❤️' : '🤍' }}</span>
                                <span>{{ $isFavorite ? 'Hapus dari Favorit' : 'Tambah ke Favorit' }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
