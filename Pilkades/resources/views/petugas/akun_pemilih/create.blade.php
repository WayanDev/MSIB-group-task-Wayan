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
                <h2 class="py-4 text-center fw-bold">Tambah Akun Pemilih</h2>
                <form action="{{ route('akun_pemilih.store') }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <select class="form-select" aria-label="Default select example" name="username" id="username">
                            <option selected disabled>Pilih NIK</option>
                            @foreach ($list_pemilih as $p)
                                <option value="{{ $p->nik }}" {{ old('username') == $p->nik ? 'selected' : '' }}>{{ $p->nik }}</option>
                            @endforeach
                        </select>
                        @if ($errors->has('username'))
                            <span class="text-danger">{{ $errors->first('username') }}</span>
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
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" 
                        autocomplete="off" id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status">
                            <option selected disabled>Pilih Status</option>
                            <option value="Sudah Memilih" {{ old('status') == "Sudah Memilih" ? 'selected' : '' }}>Sudah Memilih</option>
                            <option value="Belum Memilih" {{ old('status') == "Belum Memilih" ? 'selected' : '' }}>Belum Memilih</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    {{-- akun pemilih --}}
                    <div class="mb-3">
                        <label for="akun_desa_id" class="form-label">Asal Desa</label>
                        <input type="text" class="form-control" id="akun_desa_id" name="akun_desa_id" value="{{ old('akun_desa_id') }}" readonly>
                        @if ($errors->has('akun_desa_id'))
                            <span class="text-danger">{{ $errors->first('akun_desa_id') }}</span>
                        @endif
                    </div>

                    <div class=" modal-footer my-4">
                        <a href="{{route('akun_pemilih.index')}}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
                <script>
                    var listPemilih = @json($list_pemilih);
                </script>

                <script>
                    document.getElementById('username').addEventListener('change', function() {
                        var selectedNik = this.value;
                        var akunDesaIdInput = document.getElementById('akun_desa_id');
                        var namaInput = document.getElementById('nama');
                        
                        // Cari pemilih dengan NIK yang dipilih
                        var selectedPemilih = listPemilih.find(function(pemilih) {
                            return pemilih.nik == selectedNik;
                        });
                        
                        // Perbarui nilai kolom akun_desa_id dengan nilai akun_desa_id dari pemilih yang dipilih
                        akunDesaIdInput.value = selectedPemilih ? selectedPemilih.akun_desa_id : '';

                        // Perbarui nilai kolom nama dengan nilai nama dari pemilih yang dipilih
                        namaInput.value = selectedPemilih ? selectedPemilih.nama : '';
                    });
                </script>

            </div>
        </div>
    </div>
</div>

@endsection
