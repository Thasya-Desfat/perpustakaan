@extends('layouts.app')

@section('title', 'Daftar Buku')

@section('content')
<div class="container">
    <h2>Daftar Buku</h2>
    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
        @foreach($bukus as $buku)
        <div class="card" style="width: 250px;">
            <div style="cursor:pointer;" onclick="showPinjamForm({{ $buku->id }}, '{{ $buku->judul }}', '{{ $buku->penulis }}', '{{ $buku->kategori }}', '{{ $buku->tahun_terbit }}', '{{ $buku->sinopsis }}', '{{ $buku->image ? asset('storage/'.$buku->image) : '' }}')">
                @if($buku->image)
                    <img src="{{ asset('storage/'.$buku->image) }}" style="width:100%;height:180px;object-fit:cover;">
                @endif
            </div>
            <div style="padding: 10px;">
                <h4>{{ $buku->judul }}</h4>
                <p><b>Penulis:</b> {{ $buku->penulis }}</p>
                <p><b>Kategori:</b> {{ $buku->kategori }}</p>
                <p><b>Tahun:</b> {{ $buku->tahun_terbit }}</p>
                <p>{{ $buku->sinopsis }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

{{-- Modal Pinjam Buku --}}
<div id="pinjamModal" style="display:none;position:fixed;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.5);align-items:center;justify-content:center;z-index:9999;">
    <div style="background:#fff;padding:30px;max-width:400px;width:100%;border-radius:8px;position:relative;">
        <button onclick="closePinjamForm()" style="position:absolute;top:10px;right:10px;">X</button>
        <h3 id="modalJudul"></h3>
        <img id="modalImage" src="" style="width:100%;height:180px;object-fit:cover;display:none;">
        <p id="modalPenulis"></p>
        <p id="modalKategori"></p>
        <p id="modalTahun"></p>
        <p id="modalSinopsis"></p>
        <form id="pinjamForm" method="POST">
            @csrf
            <button type="submit" class="btn btn-primary">Pinjam Buku</button>
        </form>
    </div>
</div>
<script>
function showPinjamForm(id, judul, penulis, kategori, tahun, sinopsis, image) {
    document.getElementById('modalJudul').innerText = judul;
    document.getElementById('modalPenulis').innerText = "Penulis: " + penulis;
    document.getElementById('modalKategori').innerText = "Kategori: " + kategori;
    document.getElementById('modalTahun').innerText = "Tahun: " + tahun;
    document.getElementById('modalSinopsis').innerText = sinopsis;
    if(image) {
        document.getElementById('modalImage').src = image;
        document.getElementById('modalImage').style.display = 'block';
    } else {
        document.getElementById('modalImage').style.display = 'none';
    }
    document.getElementById('pinjamForm').action = '/siswa/buku/' + id + '/pinjam';
    document.getElementById('pinjamModal').style.display = 'flex';
}
function closePinjamForm() {
    document.getElementById('pinjamModal').style.display = 'none';
}
</script>
@endsection
