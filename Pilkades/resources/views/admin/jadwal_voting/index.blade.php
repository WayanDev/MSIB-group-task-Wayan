@extends('layout.appadmin')

@section('content')

<h1 class="mt-4">Jadwal Pelaksanaan Voting</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Jadwal Pelaksanaan Voting</li>
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
            Data Jadwal Voting
        </div>
        <a class="btn btn-primary" href="{{route('jadwal_voting.create')}}">
            Tambah Data
        </a>
    </div>

    <div class="card-body">
        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Akun Desa</th>
                    <th>Tanggal Pemilihan</th>
                    <th>Waktu Mulai</th>
                    <th>Waktu Selesai</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($jadwal_votings as $jadwal_voting)

                <tr>
                    <th>{{ $no }}</th>
                    <th>{{ $jadwal_voting->akun_desa_id }}</th>
                    <th>{{ $jadwal_voting->tgl_pemilihan }}</th>
                    <th>{{ $jadwal_voting->waktu_mulai }}</th>
                    <th>{{ $jadwal_voting->waktu_selesai }}</th>
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('jadwal_voting.edit', $jadwal_voting->id) }}">Edit</a>     
                        <button class="btn btn-danger btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $jadwal_voting->id }}">Hapus</button>
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $jadwal_voting->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $jadwal_voting->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel{{ $jadwal_voting->id }}">Konfirmasi Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data Jadwal Desa ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('jadwal_voting.destroy', $jadwal_voting->id) }}" method="POST">
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