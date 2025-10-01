@extends('layouts.app')

@section('title', 'Daftar - Perpustakaan Sekolah')

@section('content')
<div class="header" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%); position: relative; overflow: hidden;">
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; opacity: 0.1;">
        <div style="position: absolute; top: 20%; left: 10%; font-size: 60px;">📚</div>
        <div style="position: absolute; top: 60%; right: 15%; font-size: 45px;">📖</div>
        <div style="position: absolute; top: 30%; right: 30%; font-size: 35px;">✏️</div>
        <div style="position: absolute; bottom: 20%; left: 20%; font-size: 40px;">🏫</div>
    </div>
    <div style="position: relative; z-index: 2;">
        <div style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 10px;">
            <div style="font-size: 48px;">📚</div>
            <h1 style="margin: 0; font-weight: 700; text-shadow: 2px 2px 4px rgba(0,0,0,0.3);">Perpustakaan Digital</h1>
        </div>
        <p style="text-align: center; opacity: 0.9; font-size: 16px; margin: 0;">Sistem Manajemen Perpustakaan Sekolah</p>
    </div>
</div>

<div class="container">
    <div class="card" style="width: 480px; margin: 40px auto; box-shadow: 0 15px 35px rgba(30,60,114,0.15); border-radius: 20px; overflow: hidden; position: relative;">
        <!-- Decorative Top Border -->
        <div style="height: 6px; background: linear-gradient(90deg, #1e3c72, #2a5298, #4a69bd); width: 100%;"></div>
        
        <!-- Main Content -->
        <div style="padding: 30px;">
            <div style="text-align: center; margin-bottom: 25px;">
                <div style="display: inline-block; padding: 15px; background: linear-gradient(135deg, #e3f2fd, #bbdefb); border-radius: 50%; margin-bottom: 15px; box-shadow: 0 8px 20px rgba(30,60,114,0.1);">
                    <span style="font-size: 36px;">👋</span>
                </div>
                <h2 style="color: #1e3c72; font-weight: 700; margin-bottom: 5px; font-size: 24px;">Daftar Akun Baru</h2>
                <p style="color: #64b5f6; font-size: 14px; margin: 0; font-weight: 500;">Bergabung dengan perpustakaan digital</p>
            </div>

            @if($errors->any())
                <div class="alert alert-danger" style="border-radius: 12px; border: none; background: linear-gradient(135deg, #ffebee, #ffcdd2); color: #c62828; box-shadow: 0 4px 12px rgba(198,40,40,0.15);">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <span style="font-size: 20px;">⚠️</span>
                        <span style="font-weight: 500;">{{ $errors->first() }}</span>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="name" style="color: #1e3c72; font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 18px;">👤</span>
                        Nama Lengkap
                    </label>
                    <div style="position: relative;">
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                               style="width: 100%; border: 2px solid #e3f2fd; transition: all 0.3s ease; border-radius: 12px; 
                                      padding: 16px 50px 16px 20px; font-size: 16px; background: #fafafa;"
                               onfocus="this.style.borderColor='#2a5298'; this.style.boxShadow='0 0 20px rgba(42,82,152,0.15)'; this.style.background='white'"
                               onblur="this.style.borderColor='#e3f2fd'; this.style.boxShadow='none'; this.style.background='#fafafa'"
                               placeholder="Masukkan nama lengkap Anda">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="email" style="color: #1e3c72; font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 18px;">📧</span>
                        Email
                    </label>
                    <div style="position: relative;">
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required 
                               style="width: 100%; border: 2px solid #e3f2fd; transition: all 0.3s ease; border-radius: 12px; 
                                      padding: 16px 50px 16px 20px; font-size: 16px; background: #fafafa;"
                               onfocus="this.style.borderColor='#2a5298'; this.style.boxShadow='0 0 20px rgba(42,82,152,0.15)'; this.style.background='white'"
                               onblur="this.style.borderColor='#e3f2fd'; this.style.boxShadow='none'; this.style.background='#fafafa'"
                               placeholder="Masukkan alamat email Anda">
                    </div>
                </div>

                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="password" style="color: #1e3c72; font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 18px;">🔒</span>
                        Password
                    </label>
                    <div style="position: relative;">
                        <input type="password" id="password" name="password" required 
                               style="width: 100%; border: 2px solid #e3f2fd; transition: all 0.3s ease; border-radius: 12px; 
                                      padding: 16px 50px 16px 20px; font-size: 16px; background: #fafafa;"
                               onfocus="this.style.borderColor='#2a5298'; this.style.boxShadow='0 0 20px rgba(42,82,152,0.15)'; this.style.background='white'"
                               onblur="this.style.borderColor='#e3f2fd'; this.style.boxShadow='none'; this.style.background='#fafafa'"
                               placeholder="Buat password Anda">
                    </div>
                </div>

                <!-- Password Confirmation -->
                <div class="form-group" style="margin-bottom: 25px;">
                    <label for="password_confirmation" style="color: #1e3c72; font-weight: 600; margin-bottom: 8px; display: flex; align-items: center; gap: 8px;">
                        <span style="font-size: 18px;">🔐</span>
                        Konfirmasi Password
                    </label>
                    <div style="position: relative;">
                        <input type="password" id="password_confirmation" name="password_confirmation" required 
                               style="width: 100%; border: 2px solid #e3f2fd; transition: all 0.3s ease; border-radius: 12px; 
                                      padding: 16px 50px 16px 20px; font-size: 16px; background: #fafafa;"
                               onfocus="this.style.borderColor='#2a5298'; this.style.boxShadow='0 0 20px rgba(42,82,152,0.15)'; this.style.background='white'"
                               onblur="this.style.borderColor='#e3f2fd'; this.style.boxShadow='none'; this.style.background='#fafafa'"
                               placeholder="Konfirmasi password Anda">
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="form-group" style="margin-top: 25px;">
                    <button type="submit" class="btn" 
                            style="width: 100%; background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #4a69bd 100%); 
                                   border: none; padding: 18px; font-size: 18px; font-weight: 700; 
                                   border-radius: 12px; transition: all 0.4s ease; cursor: pointer; color: white;
                                   box-shadow: 0 8px 25px rgba(30,60,114,0.3); position: relative; overflow: hidden;"
                            onmouseover="this.style.transform='translateY(-3px)'; this.style.boxShadow='0 15px 35px rgba(30,60,114,0.4)'"
                            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 8px 25px rgba(30,60,114,0.3)'">
                        <span style="display: flex; align-items: center; justify-content: center; gap: 12px; position: relative; z-index: 2;">
                            <span style="font-size: 20px;">✨</span>
                            <span>Daftar Sekarang</span>
                        </span>
                    </button>
                </div>
            </form>

            <!-- Login Link -->
            <div style="text-align: center; margin-top: 25px;">
                <p style="color: #64b5f6; font-size: 16px; margin-bottom: 15px; font-weight: 500;">Sudah punya akun?</p>
                <a href="{{ route('login') }}" 
                   style="display: inline-flex; align-items: center; gap: 10px; color: #1e3c72; text-decoration: none; font-weight: 600; 
                          padding: 12px 25px; border: 2px solid #e3f2fd; border-radius: 12px; 
                          transition: all 0.3s ease; background: linear-gradient(135deg, #f8fbff, #e3f2fd);"
                   onmouseover="this.style.borderColor='#2a5298'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 20px rgba(30,60,114,0.15)'"
                   onmouseout="this.style.borderColor='#e3f2fd'; this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                    <span style="font-size: 18px;">🔑</span>
                    <span>Masuk ke Akun</span>
                    <span style="font-size: 16px;">→</span>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
/* ...copy all styles from login page... */
</style>
@endsection