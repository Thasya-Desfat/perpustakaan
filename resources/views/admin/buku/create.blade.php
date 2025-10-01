@extends('layouts.app')

@section('title', 'Tambah Buku')

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
    <div style="max-width: 800px; margin: 0 auto;">
        <div style="background: white; border-radius: 15px; padding: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
            {{-- Form Header --}}
            <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 30px;">
                <div style="background: #e3f2fd; padding: 12px; border-radius: 12px;">
                    <span style="font-size: 24px;">📚</span>
                </div>
                <div>
                    <h3 style="color: #1e3c72; font-size: 24px; font-weight: 600; margin: 0;">Tambah Buku Baru</h3>
                    <p style="color: #64748b; margin: 5px 0 0 0;">Isi formulir berikut untuk menambahkan buku baru</p>
                </div>
            </div>

            <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                {{-- Form Fields --}}
                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Judul</label>
                    <input type="text" name="judul" value="{{ old('judul') }}" required
                           style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                  font-size: 16px; color: #334155; transition: all 0.3s ease;
                                  box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                           onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                           onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                </div>

                <div style="margin-bottom: 20px;">
                    <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Sinopsis</label>
                    <textarea name="sinopsis" required
                              style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                     font-size: 16px; color: #334155; min-height: 120px; resize: vertical;
                                     transition: all 0.3s ease; box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                              onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                              onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">{{ old('sinopsis') }}</textarea>
                </div>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 20px;">
                    <div>
                        <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Tahun Terbit</label>
                        <input type="number" name="tahun_terbit" value="{{ old('tahun_terbit') }}" required min="1900" max="2100"
                               style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                      font-size: 16px; color: #334155; transition: all 0.3s ease;
                                      box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    </div>

                    <div>
                        <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Kategori</label>
                        <select name="kategori" required
                                style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                       font-size: 16px; color: #334155; transition: all 0.3s ease; background: white;
                                       box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                                onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                                onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                            <option value="">Pilih Kategori</option>
                            <option value="fiksi" {{ old('kategori')=='fiksi'?'selected':'' }}>Fiksi</option>
                            <option value="non fiksi" {{ old('kategori')=='non fiksi'?'selected':'' }}>Non Fiksi</option>
                            <option value="buku mata pelajaran" {{ old('kategori')=='buku mata pelajaran'?'selected':'' }}>Buku Mata Pelajaran</option>
                        </select>
                    </div>

                    <div>
                        <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Nama Penulis</label>
                        <input type="text" name="penulis" value="{{ old('penulis') }}" required
                               style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                      font-size: 16px; color: #334155; transition: all 0.3s ease;
                                      box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    </div>

                    <div>
                        <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Stok</label>
                        <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0"
                               style="width: 100%; padding: 10px 15px; border: 1px solid #e2e8f0; border-radius: 10px; 
                                      font-size: 16px; color: #334155; transition: all 0.3s ease;
                                      box-shadow: 0 2px 10px rgba(0,0,0,0.05);"
                               onfocus="this.style.borderColor='#1e3c72'; this.style.boxShadow='0 2px 10px rgba(30,60,114,0.1)'"
                               onblur="this.style.borderColor='#e2e8f0'; this.style.boxShadow='none'">
                    </div>
                </div>

                <div style="margin-bottom: 30px;">
                    <label style="font-weight: 500; color: #1e3c72; display: block; margin-bottom: 8px;">Gambar Buku</label>
                    <input type="file" name="image" accept="image/*"
                           style="width: 100%; padding: 10px 15px; border: 2px dashed #e2e8f0; border-radius: 10px; 
                                  font-size: 16px; color: #334155; transition: all 0.3s ease;
                                  background: #f8fafc;">
                </div>

                <button type="submit" 
                        style="background: linear-gradient(135deg, #1e3c72, #2a5298); color: white; border: none; 
                               padding: 12px 30px; border-radius: 10px; cursor: pointer; font-size: 16px; font-weight: 500;
                               display: flex; align-items: center; gap: 8px; transition: all 0.3s ease;
                               box-shadow: 0 4px 15px rgba(30,60,114,0.2);"
                        onmouseover="this.style.transform='translateY(-2px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                    <span style="font-size: 20px;">💾</span> Simpan
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
