@extends('layouts.app')

@section('content')
<style>
    .dashboard-container {
        background: linear-gradient(to bottom, #f0f7ff 0%, #ffffff 100%);
        min-height: 100vh;
        padding: 0;
    }
    
    /* Stats Navbar - Di Tengah (Static) */
    .stats-navbar {
        background: transparent;
        padding: 0;
        margin-bottom: 2.5rem;
    }
    
    .stats-navbar .container {
        max-width: 1200px;
        overflow-x: auto;
        overflow-y: hidden;
        padding-bottom: 0.5rem;
    }
    
    /* Custom scrollbar */
    .stats-navbar .container::-webkit-scrollbar {
        height: 6px;
    }
    
    .stats-navbar .container::-webkit-scrollbar-track {
        background: rgba(226, 232, 240, 0.3);
        border-radius: 10px;
    }
    
    .stats-navbar .container::-webkit-scrollbar-thumb {
        background: rgba(59, 130, 246, 0.5);
        border-radius: 10px;
    }
    
    .stats-navbar .container::-webkit-scrollbar-thumb:hover {
        background: rgba(59, 130, 246, 0.7);
    }
    
    .stats-grid {
        display: flex;
        gap: 1.2rem;
        min-width: min-content;
    }
    
    .stat-item {
        background: white;
        backdrop-filter: blur(10px);
        border-radius: 14px;
        padding: 1.8rem 1.5rem;
        text-align: center;
        border: 2px solid #e2e8f0;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        min-width: 200px;
        flex-shrink: 0;
    }
    
    .stat-item:hover {
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
        border-color: #3b82f6;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(59, 130, 246, 0.15);
    }
    
    .stat-item-icon {
        font-size: 2.5rem;
        margin-bottom: 0.8rem;
    }
    
    .stat-item-title {
        font-size: 0.85rem;
        color: #64748b;
        font-weight: 600;
        margin-bottom: 0.8rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .stat-item-number {
        font-size: 2.8rem;
        font-weight: 800;
        color: #1e293b;
        line-height: 1;
    }
    
    /* Content Area */
    .content-area {
        padding: 2.5rem 0;
    }
    
    .page-header {
        background: linear-gradient(135deg, #2563eb 0%, #3b82f6 100%);
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(37, 99, 235, 0.15);
        margin-bottom: 2rem;
        position: relative;
        overflow: hidden;
    }
    
    .page-header::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -10%;
        width: 300px;
        height: 300px;
        background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .page-header::after {
        content: '';
        position: absolute;
        bottom: -30%;
        left: -5%;
        width: 200px;
        height: 200px;
        background: radial-gradient(circle, rgba(255,255,255,0.08) 0%, transparent 70%);
        border-radius: 50%;
    }
    
    .page-header h1 {
        font-size: 2rem;
        font-weight: 700;
        color: white;
        margin: 0;
        position: relative;
        z-index: 1;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
    }
    
    .page-header p {
        color: rgba(255, 255, 255, 0.95);
        margin: 0.5rem 0 0 0;
        font-size: 1rem;
        position: relative;
        z-index: 1;
    }
    
    .stat-card {
        background: white;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
        border: 1px solid #e8f0fe;
        margin-bottom: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    
    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, var(--accent-color), var(--accent-light));
    }
    
    .stat-card::after {
        content: '';
        position: absolute;
        bottom: -50px;
        right: -50px;
        width: 100px;
        height: 100px;
        background: var(--accent-color);
        opacity: 0.05;
        border-radius: 50%;
        transition: all 0.3s ease;
    }
    
    .stat-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(37, 99, 235, 0.15);
    }
    
    .stat-card:hover::after {
        bottom: -30px;
        right: -30px;
        width: 150px;
        height: 150px;
    }
    
    .stat-card.blue {
        --accent-color: #2563eb;
        --accent-light: #60a5fa;
    }
    
    .stat-card.green {
        --accent-color: #059669;
        --accent-light: #34d399;
    }
    
    .stat-card.orange {
        --accent-color: #ea580c;
        --accent-light: #fb923c;
    }
    
    .stat-card.purple {
        --accent-color: #7c3aed;
        --accent-light: #a78bfa;
    }
    
    .stat-header {
        display: flex;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    
    .stat-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-right: 1rem;
        background: var(--icon-bg);
        box-shadow: 0 4px 12px var(--icon-shadow);
        transition: all 0.3s ease;
    }
    
    .stat-card:hover .stat-icon {
        transform: scale(1.1) rotate(5deg);
    }
    
    .stat-card.blue .stat-icon {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        color: #1e40af;
        --icon-shadow: rgba(37, 99, 235, 0.2);
    }
    
    .stat-card.green .stat-icon {
        background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%);
        color: #047857;
        --icon-shadow: rgba(5, 150, 105, 0.2);
    }
    
    .stat-card.orange .stat-icon {
        background: linear-gradient(135deg, #fed7aa 0%, #fdba74 100%);
        color: #c2410c;
        --icon-shadow: rgba(234, 88, 12, 0.2);
    }
    
    .stat-card.purple .stat-icon {
        background: linear-gradient(135deg, #ede9fe 0%, #ddd6fe 100%);
        color: #6d28d9;
        --icon-shadow: rgba(124, 58, 237, 0.2);
    }
    
    .stat-title {
        font-size: 0.95rem;
        color: #64748b;
        font-weight: 600;
        margin: 0;
        letter-spacing: 0.3px;
    }
    
    .stat-number {
        font-size: 2.8rem;
        font-weight: 800;
        color: #1e293b;
        margin: 0;
        line-height: 1;
    }
    
    .menu-section {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.06);
        border: 1px solid #e8f0fe;
    }
    
    .menu-title {
        font-size: 1.4rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 2rem 0;
        padding-bottom: 1rem;
        border-bottom: 3px solid #f0f7ff;
        position: relative;
    }
    
    .menu-title::after {
        content: '';
        position: absolute;
        bottom: -3px;
        left: 0;
        width: 80px;
        height: 3px;
        background: linear-gradient(90deg, #2563eb, #3b82f6);
        border-radius: 2px;
    }
    
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 1.5rem;
    }
    
    .menu-item {
        background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
        border: 2px solid #e2e8f0;
        border-radius: 14px;
        padding: 1.8rem;
        text-decoration: none;
        color: #1e293b;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        position: relative;
        overflow: hidden;
    }
    
    .menu-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(37, 99, 235, 0.05), transparent);
        transition: left 0.5s ease;
    }
    
    .menu-item:hover::before {
        left: 100%;
    }
    
    .menu-item:hover {
        background: linear-gradient(135deg, #f0f7ff 0%, #ffffff 100%);
        border-color: #3b82f6;
        text-decoration: none;
        color: #2563eb;
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(37, 99, 235, 0.15);
    }
    
    .menu-item-icon {
        width: 60px;
        height: 60px;
        border-radius: 12px;
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        margin-right: 1.5rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
    }
    
    .menu-item:hover .menu-item-icon {
        background: linear-gradient(135deg, #2563eb, #3b82f6);
        transform: scale(1.1);
        box-shadow: 0 6px 16px rgba(37, 99, 235, 0.3);
    }
    
    .menu-item-content h5 {
        font-size: 1.15rem;
        font-weight: 700;
        margin: 0 0 0.4rem 0;
        transition: color 0.3s ease;
    }
    
    .menu-item-content p {
        font-size: 0.9rem;
        color: #64748b;
        margin: 0;
        line-height: 1.5;
    }
    
    @media (max-width: 768px) {
        .stats-navbar .container {
            padding-left: 1rem;
            padding-right: 1rem;
        }
        
        .stats-grid {
            gap: 1rem;
        }
        
        .stat-item {
            padding: 1.5rem 1.2rem;
            min-width: 180px;
        }
        
        .stat-item-number {
            font-size: 2.2rem;
        }
        
        .content-area {
            padding: 1.5rem 0;
        }
        
        .page-header {
            padding: 2rem 1.5rem;
        }
        
        .page-header h1 {
            font-size: 1.6rem;
        }
        
        .menu-section {
            padding: 1.8rem;
        }
        
        .menu-grid {
            grid-template-columns: 1fr;
        }
        
        .menu-item {
            padding: 1.5rem;
        }
    }
</style>

<div class="dashboard-container">
    <!-- Content Area di Atas -->
    <div class="content-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Page Header -->
                    <div class="page-header">
                        <h1>📚 Dashboard Petugas Perpustakaan</h1>
                        <p>Selamat datang kembali, kelola perpustakaan digital dengan mudah</p>
                    </div>
                    
                    <!-- Menu Section -->
                    <div class="menu-section">
                        <h5 class="menu-title">Menu Petugas</h5>
                        <div class="menu-grid">
                            <a href="{{ route('petugas.peminjaman') }}" class="menu-item">
                                <div class="menu-item-icon">�</div>
                                <div class="menu-item-content">
                                    <h5>Kelola Peminjaman</h5>
                                    <p>Kelola dan monitor peminjaman buku</p>
                                </div>
                            </a>
                            
                            <a href="{{ route('petugas.siswa') }}" class="menu-item">
                                <div class="menu-item-icon">👨‍🎓</div>
                                <div class="menu-item-content">
                                    <h5>Data Siswa</h5>
                                    <p>Lihat dan kelola data siswa</p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Navbar di Bawah -->
    <div class="stats-navbar">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-item">
                    <div class="stat-item-icon">�</div>
                    <div class="stat-item-title">Peminjaman Hari Ini</div>
                    <div class="stat-item-number">{{ $data['peminjaman_hari_ini'] }}</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-item-icon">✅</div>
                    <div class="stat-item-title">Pengembalian Hari Ini</div>
                    <div class="stat-item-number">{{ $data['pengembalian_hari_ini'] }}</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-item-icon">�</div>
                    <div class="stat-item-title">Sedang Dipinjam</div>
                    <div class="stat-item-number">{{ $data['sedang_dipinjam'] }}</div>
                </div>
                
                <div class="stat-item">
                    <div class="stat-item-icon">👥</div>
                    <div class="stat-item-title">Total Siswa</div>
                    <div class="stat-item-number">{{ $data['total_siswa'] }}</div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection