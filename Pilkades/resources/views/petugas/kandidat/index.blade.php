@extends('layout.appadmin')

@section('content')

<h1 class="mt-4">Kandidat</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('petugas.dashboard')}}">Dashboard</a></li>
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
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between items-center">
        <div class="pt-2">
            <i class="fas fa-table me-1"></i>
            Data Kandidat
        </div>
        <a class="btn btn-primary" href="{{route('kandidat.create')}}">
            Tambah Data
        </a>
    </div>

    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Asal Desa</th>
                    <th>Nama</th>
                    <th>Jenis Kelamin</th>
                    <th>Usia</th>
                    <th>Visi</th>
                    <th>Misi</th>
                    <th>Foto</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($kandidat as $k)

                <tr>
                    <th>{{ $no }}</th>
                    <th>{{ $k->akun_desa_id}}</th>
                    <th>{{ $k->nama }}</th>
                    <th>{{ $k->jenis_kelamin }}</th>
                    <th>{{ $k->usia }}</th>
                    <th>{{ $k->visi }}</th>
                    <th>{{ $k->misi }}</th>
                    <th>
                        @if ($k->foto)
                            <img src="{{ asset('/'.$k->foto) }}" alt="Foto Kandidat" width="100">
                        @else
                            <img src="{{ asset('photos/noimage.png') }}" alt="No Image">
                        @endif
                        </th>
                    
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('kandidat.edit', $k->id) }}">Edit</a>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $k->id }}">Hapus</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $k->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $k->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel{{ $k->id }}">Konfirmasi Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data kandidat ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('kandidat.destroy', $k->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                @php
                    $no++
                @endphp
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection