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
                <h2 class="py-4 text-center fw-bold">Edit Kandidat</h2>
                <form action="{{ route('kandidat.update', $kandidat->id) }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')

                    <div class="mb-3">
                        <label for="akun_desa_id" class="form-label">Asal Desa</label>
                        <select class="form-select" aria-label="Default select example" id="akun_desa_id" name="akun_desa_id">
                            <option selected disabled>Pilih Nama Desa</option>
                            @foreach ($akun_desa as $desa)
                                <option value="{{ $desa->list_desa_nama }}" {{ old('akun_desa_id', $kandidat->akun_desa_id) == $desa->list_desa_nama ? 'selected' : '' }}>{{ $desa->list_desa_nama }}</option>
                            @endforeach
                        </select>
                        @error('akun_desa_id')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" value="{{ old('nama', $kandidat->nama) }}" class="form-control" id="nama" name="nama">
                        @error('nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3 row">
                        <label for="jenis_kelamin" class="form-label col-4">Jenis Kelamin</label>
                        <div class="col-8">
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="jenis_kelamin" id="radio_0" type="radio" class="custom-control-input" value="Laki-laki" {{ old('jenis_kelamin', $kandidat->jenis_kelamin) == 'Laki-laki' ? 'checked' : '' }}>
                                <label for="radio_0" class="custom-control-label">Laki-laki</label>
                            </div>
                            <div class="custom-control custom-radio custom-control-inline">
                                <input name="jenis_kelamin" id="radio_1" type="radio" class="custom-control-input" value="Perempuan" {{ old('jenis_kelamin', $kandidat->jenis_kelamin) == 'Perempuan' ? 'checked' : '' }}>
                                <label for="radio_1" class="custom-control-label">Perempuan</label>
                            </div>
                        </div>
                        @error('jenis_kelamin')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="usia" class="form-label">Usia</label>
                        <input type="number" value="{{ old('usia', $kandidat->usia) }}" class="form-control" id="usia" name="usia">
                        @error('usia')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="visi" class="form-label">Visi</label>
                        <textarea class="form-control" id="visi" name="visi" rows="3">{{ old('visi', $kandidat->visi) }}</textarea>
                        @error('visi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="misi" class="form-label">Misi</label>
                        <textarea class="form-control" id="misi" name="misi" rows="3">{{ old('misi', $kandidat->misi) }}</textarea>
                        @error('misi')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <img src="{{ asset('/'.$kandidat->foto) }}" alt="Foto Kandidat" width="100">
                        <input type="file" class="form-control" id="foto" name="foto">
                        @error('foto')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer my-4">
                        <a href="{{ route('petugas.kandidat') }}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection