@extends('layout.appadmin')

@section('content')

<h1 class="mt-4">Akun Desa</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">Akun Desa</li>
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
            Data Desa
        </div>
        <div class="text-end">
            <a class="btn btn-primary" href="{{route('akun_desa.create')}}">
                Tambah Data
            </a>
            <a class="btn btn-success" href="{{route('exportakundesa')}}">
                <i class="fas fa-file-excel"></i> Export
            </a>
            <a style="color:white" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#importModal"><i class="fas fa-upload"></i> Import Excel</a>
        </div>
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
                        <form action="{{ route('importakundesa') }}" method="POST" enctype="multipart/form-data">
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
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Nama Desa</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($akun_desa as $ad)
                <tr>
                    <th>{{ $no }}</th>
                    <th>{{ $ad->username }}</th>
                    <th>{{ $ad->password }}</th>
                    <th>{{ $ad->role }}</th>
                    <th>{{ $ad->list_desa_nama }}</th>
                    <td>
                        
                        <a class="btn btn-warning btn-sm" href="{{ route('akun_desa.edit', $ad->id) }}">Edit</a>
                        <button class="btn btn-danger btn-sm" type="submit" data-bs-toggle="modal" data-bs-target="#hapusModal{{ $ad->id }}">Hapus</button>
                        <!-- Modal -->
                        <div class="modal fade" id="hapusModal{{ $ad->id }}" tabindex="-1" aria-labelledby="hapusModalLabel{{ $ad->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="hapusModalLabel{{ $ad->id }}">Konfirmasi Hapus Data</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Apakah Anda yakin ingin menghapus data Akun Desa ini?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                        <form action="{{ route('akun_desa.destroy', $ad->id) }}" method="POST">
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