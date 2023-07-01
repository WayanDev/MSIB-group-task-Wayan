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
                <h2 class="py-4 text-center fw-bold">Edit Akun Pemilih</h2>
                <form action="{{ route('akun_pemilih.update', $akun_pemilih->id) }}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control"
                        autocomplete="off" value="" id="password" name="password">
                        @if ($errors->has('password'))
                            <span class="text-danger">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" aria-label="Default select example" id="status" name="status">
                            <option selected disabled>Pilih Status</option>
                            <option value="Sudah Memilih" {{ $akun_pemilih->status == "Sudah Memilih" ? 'selected' : '' }}>Sudah Memilih</option>
                            <option value="Belum Memilih" {{ $akun_pemilih->status == "Belum Memilih" ? 'selected' : '' }}>Belum Memilih</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>
                    <div class=" modal-footer my-4">
                        <a href="{{route('akun_pemilih.index')}}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection