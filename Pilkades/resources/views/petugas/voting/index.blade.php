@extends('layout.appadmin')

@section('content')

<h1 class="mt-4">Voting</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href={{route('petugas.dashboard')}}>Dashboard</a></li>
    <li class="breadcrumb-item active">Voting</li>
</ol>
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
            Data Pemilih
        </div>
        <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAllModal">
            Hapus Semua Data
        </button>
        <!-- Modal -->
        <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-labelledby="deleteAllModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAllModalLabel">Konfirmasi Hapus Semua Data Voting</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Anda yakin ingin menghapus semua data voting?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form action="{{ route('voting.destroyAll') }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Hapus</button>
                </form>
            </div>
            </div>
        </div>
        </div>
    </div>
    
    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Kandidat</th>
                    <th>Nama Pemilih</th>
                    <th>Asal Desa</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($voting as $ad)
                <tr>
                    <th>{{ $no }}</th>
                    <th>{{ $ad->kandidat->nama }}</th>
                    <th>{{ $ad->akun_pemilih->nama }}</th>
                    <th>{{ $ad->akun_desa_id }}</th>
                    <td>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $ad->id }}">Hapus</button>
                        
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $ad->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $ad->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel{{ $ad->id }}">Konfirmasi Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data Voting ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('voting.destroy', $ad->id) }}" method="POST">
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