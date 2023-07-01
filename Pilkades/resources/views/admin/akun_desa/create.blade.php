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
                <h2 class="py-4 text-center fw-bold">Tambah Akun Desa</h2>
                <form action="{{ route('akun_desa.store')}}" enctype="multipart/form-data" method="POST">
                    {{ csrf_field() }}
                    <div class="mb-3">
                        <label for="list_desa_nama" class="form-label">Nama Desa</label>
                        <select class="form-select" aria-label="Default select example" name="list_desa_nama">
                            <option selected disabled>Pilih Desa</option>
                            @foreach ($list_desa as $desa)
                                <option value="{{ $desa->nama }}" {{ old('list_desa_nama') == $desa->nama ? 'selected' : '' }}>{{ $desa->nama }}</option>
                            @endforeach
                        </select>
                        @error('list_desa_nama')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" >
                        @error('username')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" >
                        @error('password')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" aria-label="Default select example" id="role" name="role">
                            <option selected disabled>Pilih Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        </select>
                        @error('role')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="modal-footer my-4">
                        <a href="{{ route('akun_desa.index') }}" type="button" class="btn btn-secondary me-2">Batal</a>
                        <button name="submit" type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection