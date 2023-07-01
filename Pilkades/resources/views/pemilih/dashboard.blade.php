@extends('layout.appadmin')

@section('content')
    <h1 class="mt-4">Dashboard</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
    </ol>
    @if(session('error'))
        <div class="alert alert-danger" id="error-message">
            {{ session('error') }}
        </div>
        <?php session()->forget('error'); ?>
        <script>
            setTimeout(function() {
                document.getElementById('error-message').style.display = 'none';
            }, 3000); // Menghilangkan pesan error setelah 5 detik (5000 milidetik)
        </script>
    @endif
    <strong style="font-size: 20px">{{ $tanggalDashboard }} Jam {{ $jamDashboard }}</strong>
    <h2>Hi, {{ Auth::guard('pemilih')->user()->nama }}</h2>
    <h4>Tata Cara Pemilihan</h4>

    <p>Selamat datang di dashboard pemilih, Anda dapat menggunakan layanan ini untuk melakukan voting kepala desa secara online. Berikut adalah tata cara untuk memilih:</p>

    <ol>
        <li>Pastikan koneksi jaringan Anda stabil</li>
        <li>Klik menu "<a href="{{route('pemilih.kandidat')}}">Kandidat</a>" dibawah menu Dashboard</li>
        <li>Untuk melihat Profil kandidat Anda bisa klik tombol <strong>Detail</strong></li>
        <li>Pilih kandidat dengan cara klik tombol <strong>Pilih</strong></li>
        <li>Konfirmasi pilihan dengan klik <strong>Ya</strong>, Jika belum yakin bisa klik tombol <strong>Batal</strong></li>
        <li>Terima kasih telah menggunakan layanan voting ini. Pastikan untuk menjaga kerahasiaan akun Anda dan tidak memberikan informasi login kepada orang lain.</li>
        <li>Setelah memilih bisa klik <strong>Logout</strong> pada icon <i class="fas fa-user fa-fw"></i> pada kanan atas halaman</li>
    </ol>

    <p>Jika Anda mengalami masalah atau memiliki pertanyaan, jangan ragu untuk menghubungi panitia pemilihan.</p>
@endsection