<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pinjam Buku - {{ $buku->judul }}</title>
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
            max-width: 900px;
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

        /* Content Card */
        .content-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        }

        .card-title {
            font-size: 28px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .card-subtitle {
            color: #64748b;
            font-size: 16px;
            margin-bottom: 30px;
        }

        /* Book Info Section */
        .book-info {
            background: #f8fafc;
            padding: 25px;
            border-radius: 15px;
            margin-bottom: 30px;
            display: flex;
            gap: 25px;
            align-items: start;
        }

        .book-cover {
            width: 120px;
            height: 170px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .book-details {
            flex: 1;
        }

        .book-title-small {
            font-size: 20px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 15px;
        }

        .book-meta {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .meta-row {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #64748b;
            font-size: 14px;
        }

        .meta-icon {
            font-size: 16px;
        }

        .meta-text {
            color: #1e293b;
            font-weight: 500;
        }

        /* Form Section */
        .form-group {
            margin-bottom: 25px;
        }

        .form-label {
            display: block;
            color: #1e293b;
            font-weight: 600;
            margin-bottom: 10px;
            font-size: 15px;
        }

        .form-control {
            width: 100%;
            padding: 14px 18px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 15px;
            transition: all 0.3s ease;
            background: #f8fafc;
        }

        .form-control:focus {
            outline: none;
            border-color: #667eea;
            background: white;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .form-helper {
            color: #64748b;
            font-size: 13px;
            margin-top: 6px;
        }

        .info-box {
            background: #fef3c7;
            border: 1px solid #fbbf24;
            color: #92400e;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            display: flex;
            align-items: start;
            gap: 10px;
        }

        .info-icon {
            font-size: 20px;
            margin-top: 2px;
        }

        /* Action Buttons */
        .action-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            flex: 1;
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

        .btn-secondary {
            background: #f1f5f9;
            color: #334155;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .book-info {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header Navigation -->
        <div class="nav-header">
            <a href="{{ route('siswa.buku.detail', $buku->id) }}" class="back-button">
                <span>←</span>
                <span>Kembali</span>
            </a>
            <div class="page-title">📚 Form Peminjaman Buku</div>
        </div>

        <!-- Content Card -->
        <div class="content-card">
            <h1 class="card-title">Konfirmasi Peminjaman Buku</h1>
            <p class="card-subtitle">Lengkapi form di bawah ini untuk meminjam buku</p>

            <!-- Book Info -->
            <div class="book-info">
                @if($buku->image)
                    <img src="{{ asset('storage/' . $buku->image) }}" alt="{{ $buku->judul }}" class="book-cover">
                @else
                    <div class="book-cover" style="background: linear-gradient(135deg, #667eea, #764ba2); display: flex; align-items: center; justify-content: center; font-size: 40px;">
                        📚
                    </div>
                @endif
                
                <div class="book-details">
                    <div class="book-title-small">{{ $buku->judul }}</div>
                    <div class="book-meta">
                        <div class="meta-row">
                            <span class="meta-icon">🆔</span>
                            <span>ID Buku:</span>
                            <span class="meta-text">#{{ str_pad($buku->id, 4, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-icon">👤</span>
                            <span>Pengarang:</span>
                            <span class="meta-text">{{ $buku->penulis }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-icon">📑</span>
                            <span>Kategori:</span>
                            <span class="meta-text">{{ ucfirst($buku->kategori) }}</span>
                        </div>
                        <div class="meta-row">
                            <span class="meta-icon">📦</span>
                            <span>Stok Tersedia:</span>
                            <span class="meta-text">{{ $buku->stok }} buku</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Box -->
            @if($hasActivePeminjaman)
            <div class="info-box" style="background: #fee2e2; border-color: #ef4444;">
                <span class="info-icon">🚫</span>
                <div>
                    <strong style="color: #991b1b;">Peringatan: Anda Tidak Dapat Meminjam Buku!</strong>
                    <p style="margin: 8px 0 0 0; line-height: 1.6; color: #991b1b;">
                        Anda masih memiliki <strong>peminjaman buku yang belum selesai</strong>. 
                        Silakan kembalikan buku yang sedang dipinjam atau tunggu konfirmasi dari petugas terlebih dahulu sebelum meminjam buku baru.
                    </p>
                </div>
            </div>
            @else
            <div class="info-box">
                <span class="info-icon">ℹ️</span>
                <div>
                    <strong>Informasi Penting:</strong>
                    <ul style="margin: 8px 0 0 20px; line-height: 1.6;">
                        <li>Maksimal peminjaman adalah <strong>3 hari</strong></li>
                        <li>Peminjaman memerlukan <strong>konfirmasi dari petugas</strong></li>
                        <li>Pastikan mengembalikan buku tepat waktu</li>
                    </ul>
                </div>
            </div>
            @endif

            <!-- Form -->
            <form action="{{ route('siswa.buku.pinjam', $buku->id) }}" method="POST">
                @csrf
                
                <div class="form-group">
                    <label class="form-label">📅 Tanggal Pinjam</label>
                    <input type="datetime-local" 
                           name="tanggal_pinjam" 
                           class="form-control" 
                           value="{{ now()->format('Y-m-d\TH:i') }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           {{ $hasActivePeminjaman ? 'disabled' : '' }}
                           required>
                    <div class="form-helper">Pilih tanggal dan waktu mulai peminjaman</div>
                </div>

                <div class="form-group">
                    <label class="form-label">📆 Tanggal Kembali (Maksimal 3 Hari)</label>
                    <input type="datetime-local" 
                           name="tanggal_kembali" 
                           class="form-control"
                           value="{{ now()->addDays(3)->format('Y-m-d\TH:i') }}"
                           min="{{ now()->format('Y-m-d\TH:i') }}"
                           max="{{ now()->addDays(3)->format('Y-m-d\TH:i') }}"
                           {{ $hasActivePeminjaman ? 'disabled' : '' }}
                           required>
                    <div class="form-helper">Pilih tanggal dan waktu pengembalian (maksimal 3 hari dari sekarang)</div>
                </div>

                <div class="action-buttons">
                    <button type="submit" class="btn btn-primary" {{ $hasActivePeminjaman ? 'disabled' : '' }}
                            style="{{ $hasActivePeminjaman ? 'opacity: 0.5; cursor: not-allowed;' : '' }}">
                        <span>✓</span>
                        <span>{{ $hasActivePeminjaman ? 'Tidak Dapat Meminjam' : 'Konfirmasi Peminjaman' }}</span>
                    </button>
                    <a href="{{ route('siswa.buku.detail', $buku->id) }}" class="btn btn-secondary">
                        <span>✖</span>
                        <span>Batal</span>
                    </a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
