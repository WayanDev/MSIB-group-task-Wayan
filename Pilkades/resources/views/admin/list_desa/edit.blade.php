@extends('layout.appadmin')

@section('content')

<div class="row-cols-md-2">
    <div class="container my-5">
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
        <div class="card">
            <div class="container-fluid px-5 py-2">
                <h2 class="py-4 text-center fw-bold">Edit Desa</h2>
                <form action="{{ route('list_desa.update', $list_desa->nama) }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Desa</label>
                        <input type="text" class="form-control" id="nama" name="nama" 
                        value="{{ old('nama', $list_desa->nama) }}">
                        @if ($errors->has('nama'))
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kantor" class="form-label">Alamat Kantor</label>
                        <textarea type="text" id="alamat_kantor" name="alamat_kantor" cols="40" 
                        rows="5" class="form-control">{{ old('alamat_kantor', $list_desa->alamat_kantor) }}</textarea>
                        @if ($errors->has('alamat_kantor'))
                            <span class="text-danger">{{ $errors->first('alamat_kantor') }}</span>
                        @endif
                    </div>

                    <div class=" modal-footer my-4">
                        <a href="{{route('list_desa.index')}}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection