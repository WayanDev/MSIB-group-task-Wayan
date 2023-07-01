<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
    
                @if(Auth::check())
                    {{-- Menu-menu yang akan tampil jika yang Login sebagai Admin --}}
                    @if(Auth::user()->role === 'admin')
                    <a class="nav-link" href="{{route('admin.dashboard')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Data Penduduk</div>
                    <a class="nav-link" href="{{ route('list_pemilih.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-list-ol"></i></div>
                        List Pemilih
                    </a>
                    <div class="sb-sidenav-menu-heading">Data Desa</div>
                    <a class="nav-link" href="{{route('list_desa.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-list-ol"></i></div>
                        List Desa
                    </a>
                    <a class="nav-link" href="{{route('akun_desa.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-user"></i></div>
                        Akun Desa
                    </a>
                    <div class="sb-sidenav-menu-heading">Jadwal Pelaksanaan</div>
                    <a class="nav-link" href="{{route('jadwal_voting.index')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-clock"></i></div>
                        Jadwal Voting
                    </a>
                    {{-- Menu-menu yang akan tampil jika yang Login sebagai Petugas --}}
                    @elseif(Auth::user()->role === 'petugas')
                    <a class="nav-link" href="{{ route('petugas.dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Data Penduduk</div>
                    <a class="nav-link" href="{{ route('list_pemilih.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-list-ol"></i></div>
                        List Pemilih
                    </a>
                    <a class="nav-link" href="{{ route('akun_pemilih.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-user"></i></div>
                        Akun Pemilih
                    </a>
                    <div class="sb-sidenav-menu-heading">Data Kandidat</div>
                    <a class="nav-link" href="{{ route('petugas.kandidat') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-user-group"></i></div>
                        Kandidat
                    </a>
                    <div class="sb-sidenav-menu-heading">Data Hasil Voting</div>
                    <a class="nav-link" href="{{ route('voting.index') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-thumbs-up"></i> </i></div>
                        Voting
                    </a>
                    {{-- Menu-menu yang akan tampil jika yang Login sebagai Pemilih --}}
                    @elseif(Auth::guard('pemilih')->check())
                    <a class="nav-link" href="{{route('pemilih.dashboard')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <div class="sb-sidenav-menu-heading">Voting</div>
                    <a class="nav-link" href="{{route('pemilih.kandidat')}}">
                        <div class="sb-nav-link-icon"><i class="fas fa-solid fa-user-group"></i></div>
                        Kandidat
                    </a>
                    @endif
                    @endif
                </div>
            </div>
            <div class="sb-sidenav-footer">
                {{-- Jika yang Login sebagai Pemilih maka akan menampilkan nama --}}
                @if (Auth::guard('pemilih')->check())
                <div class="small">Login sebagai</div>{{ Auth::guard('pemilih')->user()->nama }}
                {{-- Jika yang Login sebagai Admin/Petugas maka akan menampilkan username --}}
                @elseif (Auth::guard('akun_desa')->check())
                <div class="small">Login sebagai:</div>{{ Auth::guard('akun_desa')->user()->username }}
                @endif
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">