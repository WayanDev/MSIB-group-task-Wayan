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
                <h2 class="py-4 text-center fw-bold">Tambah List Pemilih</h2>
                <form action="{{ route('list_pemilih.store') }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    
                    <div class="mb-3">
                        <label for="nik" class="form-label">NIK</label>
                        <input type="number" class="form-control" id="nik" name="nik" value="{{ old('nik') }}">
                        @if ($errors->has('nik'))
                            <span class="text-danger">{{ $errors->first('nik') }}</span>
                        @endif
                    </div>
                    
                    <div class="mb-3">
                        <label for="akun_desa_id" class="form-label">Asal Desa</label>
                        <select class="form-select" aria-label="Default select example" id="akun_desa_id" name="akun_desa_id">
                            <option selected disabled>Pilih Nama Desa</option>
                            @foreach ($akun_desa as $ak)
                                <option value="{{ $ak->list_desa_nama }}" {{ old('akun_desa_id') == $ak->list_desa_nama ? 'selected' : '' }}>{{ $ak->list_desa_nama }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('akun_desa_id'))
                            <span class="text-danger">{{ $errors->first('akun_desa_id') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}">
                        @if ($errors->has('nama'))
                            <span class="text-danger">{{ $errors->first('nama') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="tmp_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" id="tmp_lahir" name="tmp_lahir" value="{{ old('tmp_lahir') }}">
                        @if ($errors->has('tmp_lahir'))
                            <span class="text-danger">{{ $errors->first('tmp_lahir') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ old('tgl_lahir') }}">
                        @if ($errors->has('tgl_lahir'))
                            <span class="text-danger">{{ $errors->first('tgl_lahir') }}</span>
                        @endif
                    </div>

                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="form-label col-4">Jenis Kelamin</label>
                        <div class="col-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="jenis_kelamin" id="radio_0" type="radio" class="custom-control-input" value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}> 
                                <label for="radio_0" class="custom-control-label">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="jenis_kelamin" id="radio_1" type="radio" class="custom-control-input" value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}> 
                                <label for="radio_1" class="custom-control-label">Perempuan</label>
                            </div>
                        </div>
                        @if ($errors->has('jenis_kelamin'))
                            <span class="text-danger">{{ $errors->first('jenis_kelamin') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea id="alamat" name="alamat" cols="40" rows="5" class="form-control">{{ old('alamat') }}</textarea>
                        @if ($errors->has('alamat'))
                            <span class="text-danger">{{ $errors->first('alamat') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status_perkawinan" class="form-label">Status Perkawinan</label>
                        <input type="text" class="form-control" id="status_perkawinan" name="status_perkawinan" value="{{ old('status_perkawinan') }}">
                        @if ($errors->has('status_perkawinan'))
                            <span class="text-danger">{{ $errors->first('status_perkawinan') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="pekerjaan" class="form-label">Pekerjaan</label>
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ old('pekerjaan') }}">
                        @if ($errors->has('pekerjaan'))
                            <span class="text-danger">{{ $errors->first('pekerjaan') }}</span>
                        @endif
                    </div>
                    <div class=" modal-footer my-4">
                        <a href="{{route('list_pemilih.index')}}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection