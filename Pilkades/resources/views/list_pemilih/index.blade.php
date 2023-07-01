@extends('layout.appadmin')

@section('content')

<h1 class="mt-4">List Pemilih</h1>
<ol class="breadcrumb mb-4">
    @if(Auth::user()->role === 'admin')
        <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">List Pemilih</li>
    @elseif(Auth::user()->role === 'petugas')
        <li class="breadcrumb-item"><a href="{{route('petugas.dashboard')}}">Dashboard</a></li>
        <li class="breadcrumb-item active">List Pemilih</li>
    @endif
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
        }, 10000); // Menghilangkan pesan error setelah 3 detik (3000 milidetik)
    </script>
@endif
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between items-center">
        <div class="pt-2">
            <i class="fas fa-table me-1"></i>
            Data List Pemilih
        </div>
        @if(Auth::user()->role === 'petugas' || Auth::user()->role === 'admin')
            <a class="btn btn-danger" target="_blank" href="{{ route('export-pemilih') }}">
                <i class="fas fa-file-pdf"></i> PDF
            </a>
        @endif
        @if (Auth::user()->role === 'petugas')
        <div class="text-end">
            <a class="btn btn-primary" href="{{route('list_pemilih.create')}}">
                Tambah Data
            </a>
            <a class="btn btn-success" href="{{route('exportlistpemilih')}}">
                <i class="fas fa-file-excel"></i> Export
            </a>
            <a style="color:white" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fas fa-upload"></i> Import Excel</a>
        </div>
        @endif
        <!-- Modal -->
        <div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="importModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importModalLabel">Import Excel</h5>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Your import form goes here -->
                    <form action="{{ route('importlistpemilih') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="excelFile">Choose Excel File</label>
                        <input type="file" class="form-control" id="excelFile" name="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Import</button>
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
                    <th>NIK</th>
                    <th>Asal Desa</th>
                    <th>Nama</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Jenis Kelamin</th>
                    <th>Alamat</th>
                    <th>Status Kawin</th>
                    <th>Pekerjaan</th>
                    @if(Auth::user()->role === 'petugas')
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($list_pemilih as $lp)

                <tr>
                    <th>{{ $no }}</th>
                    <th>{{ $lp->nik }}</th>
                    <th>{{ $lp->akun_desa_id }}</th>
                    <th>{{ $lp->nama }}</th>
                    <th>{{ $lp->tmp_lahir }}</th>
                    <th>{{ $lp->tgl_lahir }}</th>
                    <th>{{ $lp->jenis_kelamin }}</th>
                    <th>{{ $lp->alamat }}</th>
                    <th>{{ $lp->status_perkawinan }}</th>
                    <th>{{ $lp->pekerjaan }}</th>
                    @if(Auth::user()->role === 'petugas')
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('list_pemilih.edit', $lp->nik) }}">Edit</a>
                    
                        <button class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $lp->nik }}" type="submit">Hapus</button>
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $lp->nik }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $lp->nik }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel{{ $lp->nik }}">Konfirmasi Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data List Pemilih ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('list_pemilih.destroy', $lp->nik) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Hapus</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                    @endif
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