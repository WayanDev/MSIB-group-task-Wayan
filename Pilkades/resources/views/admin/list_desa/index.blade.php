@extends('layout.appadmin')

@section('content')

<h1 class="mt-4">List Desa</h1>
<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li class="breadcrumb-item active">List Desa</li>
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
            <a class="btn btn-primary" href="{{route('list_desa.create')}}">
                Tambah Data
            </a>
            <a class="btn btn-success" href="{{route('exportlistdesa')}}">
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
                        <form action="{{ route('importlistdesa') }}" method="POST" enctype="multipart/form-data">
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
                    <th>Nama Desa</th>
                    <th>Alamat Kantor</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $no=1;
                @endphp
                @foreach ($list_desa as $desa)
                
                <tr>
                    <th>{{ $no }}</th>
                    <th>{{ $desa['nama'] }}</th>
                    <th>{{ $desa['alamat_kantor'] }}</th>
                    <td>
                        <a class="btn btn-warning btn-sm" href="{{ route('list_desa.edit', $desa['nama']) }}">Edit</a>
                        {{-- <form action="{{ route('list_desa.destroy', $desa->nama) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                        </form> --}}
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