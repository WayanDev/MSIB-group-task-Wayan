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
                <h2 class="py-4 text-center fw-bold">Edit Jadwal Voting</h2>
                <form action="{{ route('jadwal_voting.update', $jadwal_voting->id) }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')

                    <div class="mb-3">
                        <label for="akun_desa_id" class="form-label">Akun Desa</label>
                        <select class="form-select" aria-label="Default select example" id="akun_desa_id" name="akun_desa_id">
                            <option selected disabled>Pilih Nama Desa</option>
                            @foreach ($akun_desas as $akun_desa)
                                <option value="{{ $akun_desa->list_desa_nama }}" {{ $akun_desa->list_desa_nama == $jadwal_voting->akun_desa_id ? 'selected' : '' }}>
                                    {{ $akun_desa->list_desa_nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="tgl_pemilihan" class="form-label">Tanggal Pemilihan</label>
                        <input type="date" class="form-control" id="tgl_pemilihan" name="tgl_pemilihan" value="{{ old('tgl_pemilihan', $jadwal_voting->tgl_pemilihan) }}" >
                        @error('tgl_pemilihan')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_mulai" class="form-label">Waktu Mulai</label>
                        <input type="time" class="form-control" id="waktu_mulai" name="waktu_mulai" value="{{ old('waktu_mulai', $jadwal_voting->waktu_mulai) }}" >
                        @error('waktu_mulai')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="waktu_selesai" class="form-label">Waktu Selesai</label>
                        <input type="time" class="form-control" id="waktu_selesai" name="waktu_selesai" value="{{ old('waktu_selesai', $jadwal_voting->waktu_selesai) }}" >
                        @error('waktu_selesai')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer my-4">
                        <a href="{{ route('jadwal_voting.index') }}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection