@extends('layout.appadmin')

@section('content')
<link href="{{asset('css/kandidat.css')}}" rel="stylesheet" />

<h1 class="mt-4">Kandidat</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{ route('pemilih.dashboard') }}">Dashboard</a></li>
    <li class="breadcrumb-item active">Kandidat</li>
</ol>
@if(session('success'))
    <div>{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger" id="error-message">
        {{ session('error') }}
    </div>
    <?php session()->forget('error'); ?>
    <script>
        setTimeout(function() {
            document.getElementById('error-message').style.display = 'none';
        }, 3000); // Menghilangkan pesan error setelah 3 detik (3000 milidetik)
    </script>
@endif

<div class="card-container">
    <div class="row row-cols-md-4 row-cols-sm-2">
        @if ($kandidat)
        @foreach ($kandidat as $k)
        <div class="col mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between items-center">
                    <div class="image-container">
                        <div class="image-inner">
                            <img src="{{ $k->foto ? asset('/'.$k->foto) : asset('photos/noimage.png') }}" class="card-img-top" alt="Foto Kandidat">
                        </div>
                    </div>
                </div>

                <div class="card-body" align="center">
                    <h5 class="card-title">{{ $k->nama }}</h5>
                    {{-- mengonversi karakter baris baru ("\n") menjadi tag <br> --}}
                </div>
                <div class="card-footer d-flex justify-content-between">
                    {{-- Tombol Pilih --}}
                    @if ($akun_pemilih->status == 'Sudah Memilih')
                        <button class="btn btn-danger btn-block" disabled>Sudah Memilih</button>
                    @else
                        <form action="{{ route('voting.store') }}" method="POST" id="voting-form-{{ $k->id }}">
                            @csrf
                            <input type="hidden" name="kandidat_id" value="{{ $k->id }}">
                            <button id="button-{{ $k->id }}" type="button" class="btn btn-warning" onclick="confirmVoting({{ $k->id }})"
                                {{ $k->akun_pemilih_id ? 'disabled' : '' }}>Pilih</button>
                        </form>
                    @endif
                    {{-- Tombol Detail --}}
                    <button type="button" class="btn btn-info" onclick="showDetails(this)" 
                        data-nama="{{ $k->nama }}" data-jenis-kelamin="{{ $k->jenis_kelamin }}" 
                        data-usia="{{ $k->usia }}" data-visi="{{ $k->visi }}" data-misi="{{ $k->misi }}">Detail</button>
                </div>
            </div>
        </div>
        @endforeach
        @endif
    </div>
</div>


<script src="{{ asset('js/kandidat.js') }}"></script>

@endsection
