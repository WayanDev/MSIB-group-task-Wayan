<html>
<head>
    <title> Data Pemilih </title>
    <style type="text/css">
        body {
            font-family: Arial;
            margin: 0; /* Menghilangkan margin pada body */
        }

        .rangkasurat {
            width: 980px;
            margin: 0 auto; /* Memberikan margin auto untuk membuatnya tengah */
            padding: 10px;
        }

        .kop {
            border-bottom: 5px solid #000;
            padding: 2px;
        }

        .tengah {
            text-align: center;
            line-height: 10px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            width: 120px;
            margin-right: 5px;
        }

        .perihal {
            margin-top: 10px; /* Mengurangi margin atas pada elemen perihal */
        }
    </style>
</head>
<body>
    <div class="rangkasurat">
        <table class="kop" width="100%">
            <tr>
                <td class="logo">
                    <img src="https://2.bp.blogspot.com/-HnaoRSlkJ3g/WIB31t_xP-I/AAAAAAAAAGA/YWLF4DcHPtwL0op47t2BhO_zwY3JiX6xgCK4B/s1600/LOGO_KPU_RI.png">
                </td>
                <td class="tengah">
                    <h2>KOMISI PEMILIHAN UMUM</h2>
                    <h2>KABUPATEN SLEMAN</h2>
                    <p>Alamat: Jl. Parasamya, Beran Lor, Tridadi, Kec. Sleman, Kabupaten Sleman, Daerah Istimewa Yogyakarta 55511</p>
                    <p>Telp. (0274) 868405 Fax. (0274) 868945. Email: setda@slemankab.go.id</p>
                </td>
            </tr>
        </table>
    </div>
    <h1>Data Desa</h1>
    <table border="2px" style="width: 100%;
            border-collapse: collapse;">
        <thead style="background-color: #04AA6D;">
            <tr>
                <th>No.</th>
                <th>NIK</th>
                <th>Akun</th>
                <th>Nama</th>
                <th>Tempat Lahir</th>
                <th>Tanggal Lahir</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Status Kawin</th>
                <th>Pekerjaan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @php
                $no=1;
            @endphp
            @foreach ($dataPemilih as $lp)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $lp->nik }}</td>
                <td>@php
                    $keterangan = '';
                    if ($dataAkunPemilih->contains('username', $lp->nik)) {
                        $keterangan = 'Ya';
                    }
                    echo $keterangan;
                @endphp</td>
                <td>{{ $lp->nama }}</td>
                <td>{{ $lp->tmp_lahir }}</td>
                <td>{{ $lp->tgl_lahir }}</td>
                <td>{{ $lp->jenis_kelamin }}</td>
                <td>{{ $lp->alamat }}</td>
                <td>{{ $lp->status_perkawinan }}</td>
                <td>{{ $lp->pekerjaan }}</td>
                <td>{{ $lp->akun_pemilih ? $lp->akun_pemilih->status : '-' }}</td>
            </tr>
            @php
                $no++
            @endphp
            @endforeach
        </tbody>
    </table>
</body>
</html>
