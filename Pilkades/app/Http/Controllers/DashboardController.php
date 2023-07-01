<?php

namespace App\Http\Controllers;

use PDF;
use Carbon\Carbon;
use App\Models\Voting;
use App\Models\akunDesa;
use App\Models\Kandidat;
use App\Models\listDesa;
use App\Models\akunPemilih;
use App\Models\listPemilih;
use App\Models\jadwalVoting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class DashboardController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            // Memeriksa apakah pengguna sudah login

            if (auth()->guard('akun_desa')->check()) {
                // Memeriksa apakah pengguna login sebagai 'akun_desa' atau 'petugas'

                $role = auth()->user()->role;

                if ($role === 'admin') {
                    return $this->adminDashboard();
                } elseif ($role === 'petugas') {
                    return $this->petugasDashboard();
                }
            }
        }

        // Handle jika pengguna belum login atau tidak memiliki peran yang valid
        return redirect()->route('login');
    }

     //Export PDF Admin
    public function exportdashboard(){

        $dataPemilih = listPemilih::all();
        $dataListDesa = listDesa::all();
        $dataAkunDesa = akunDesa::all();
        $dataJadwal = jadwalVoting::all();

        $pdf = PDF::loadView('laporan.data-dashboard',
            compact('dataPemilih','dataJadwal','dataListDesa','dataAkunDesa'));
        $pdf->setPaper('A4', 'landscape');
        $filename = 'dashboard.pdf';

        // Mengirimkan file PDF ke browser untuk diunduh
        return $pdf->stream($filename);
    }

     //Export PDF Admin
    public function exportdashboardpetugas(){

        $user = Auth::guard('akun_desa')->user();

        if ($user->role == 'petugas') {
            $desaPetugas = $user->list_desa_nama;
            $dataPemilih = listPemilih::where('akun_desa_id', $desaPetugas)->get();
            $dataAkunPemilih = akunPemilih::where('akun_desa_id', $desaPetugas)->get();
            $dataKandidat = Kandidat::where('akun_desa_id', $desaPetugas)->get();
        }

        $pdf = PDF::loadView('laporan.data-dashboard-petugas',
            compact('dataPemilih','dataAkunPemilih','dataKandidat'));
        $pdf->setPaper('A4', 'landscape');
        $filename = 'dashboardPetugas.pdf';

        // Mengirimkan file PDF ke browser untuk diunduh
        return $pdf->stream($filename);
    }


    private function adminDashboard()
    {
        $sekarang = Carbon::now('Asia/Jakarta')->locale('id');
        $jamDashboard = $sekarang->format('H:i');
        $tanggalDashboard = $sekarang->translatedFormat('l, d F Y');

        $list_desa = listDesa::count();
        $akun_desa = akunDesa::whereNotNull('list_desa_nama')->count();
        $voting = jadwalVoting::count();
        $penduduk = listPemilih::count();

        $list_pemilih_per_desa = DB::table('pemilih')
            ->leftJoin('akun_pemilih', 'pemilih.nik', '=', 'akun_pemilih.username')
            ->select('pemilih.akun_desa_id', DB::raw('COUNT(pemilih.nik) as total_pemilih, COUNT(akun_pemilih.username) as total_pemilih_dengan_akun'))
            ->groupBy('pemilih.akun_desa_id')
            ->get();
        
        $pemilih_per_jenis_kelamin = DB::table('pemilih')
        ->select('jenis_kelamin', DB::raw('COUNT(nik) as total_pemilih'))
        ->groupBy('jenis_kelamin')
        ->get();

        $pemilih_per_usia = DB::table('pemilih')
            ->select(DB::raw('CASE
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 17 AND TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 25 THEN "17-24 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 25 AND TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 35 THEN "25-34 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 35 AND TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 45 THEN "35-44 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 45 AND TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) < 55 THEN "45-54 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, tgl_lahir, CURDATE()) >= 55 THEN "55 Tahun ke atas"
                ELSE "Usia Tidak Diketahui"
            END as usia'),
            DB::raw('COUNT(nik) as total_pemilih')
        )
        ->groupBy('usia')
        ->orderByRaw('CASE
            WHEN usia = "17-24 Tahun" THEN 1
            WHEN usia = "25-34 Tahun" THEN 2
            WHEN usia = "35-44 Tahun" THEN 3
            WHEN usia = "45-54 Tahun" THEN 4
            WHEN usia = "55 Tahun ke atas" THEN 5
            ELSE 7
        END')
        ->get();

        return view('admin.dashboard',compact('jamDashboard','tanggalDashboard','list_desa','akun_desa','voting','penduduk','list_pemilih_per_desa','pemilih_per_jenis_kelamin',
            'pemilih_per_usia'));
    }

    private function petugasDashboard()
    {

        $sekarang = Carbon::now('Asia/Jakarta')->locale('id');
        $jamDashboard = $sekarang->format('H:i');
        $tanggalDashboard = $sekarang->translatedFormat('l, d F Y');

        $akun_desa_nama = Auth::guard('akun_desa')->user()->list_desa_nama;

        //Menampilkan Data Hasil Suara Kandidat
        $votingResults = Voting::whereHas('akun_desa', function ($query) use ($akun_desa_nama) {
            $query->where('list_desa_nama', $akun_desa_nama);
        })
        ->select('kandidat_id', Voting::raw('count(*) as total_suara'))
        ->groupBy('kandidat_id')
        ->get();

        $namaKandidat = [];
        $jumlahSuara = [];

        foreach ($votingResults as $result) {
            $kandidat = Kandidat::find($result->kandidat_id);
            if ($kandidat) {
                $namaKandidat[] = $kandidat->nama;
                $jumlahSuara[] = $result->total_suara;
            }
        }

        // Mendapatkan semua kandidat di desa tersebut
        $kandidats = Kandidat::whereHas('akun_desa', function ($query) use ($akun_desa_nama) {
            $query->where('list_desa_nama', $akun_desa_nama);
        })->get();

        // Menyiapkan array persentase suara
        $persentaseSuara = [];

        // Menambahkan kandidat yang belum terpilih
        foreach ($kandidats as $kandidat) {
            if (!in_array($kandidat->nama, $namaKandidat)) {
                $namaKandidat[] = $kandidat->nama;
                $jumlahSuara[] = 0;
            }
        }

        $totalSuara = array_sum($jumlahSuara);

        // Menghitung persentase suara
        foreach ($jumlahSuara as $suara) {
            if ($totalSuara > 0) {
                $persentaseSuara[] = number_format(($suara / $totalSuara) * 100, 2) . "%";
            } else {
                $persentaseSuara[] = "0%";
            }
        }

        //Menampilkan data pemilih yang sudah memiliki akun
        $penduduk_aktif = listPemilih::join('akun_pemilih', 'pemilih.nik', '=', 'akun_pemilih.username')
            ->join('akun_desa', 'pemilih.akun_desa_id', '=', 'akun_desa.list_desa_nama')
            ->where('akun_desa.list_desa_nama', $akun_desa_nama)
            ->count();
        //menampilkan data pemilih yang belum memiliki akun
        $penduduk_belum_aktif = listPemilih::leftJoin('akun_pemilih', 'pemilih.nik', '=', 'akun_pemilih.username')
            ->join('akun_desa', 'pemilih.akun_desa_id', '=', 'akun_desa.list_desa_nama')
            ->where('akun_desa.list_desa_nama', $akun_desa_nama)
            ->whereNull('akun_pemilih.username')
            ->count();
        //menampilkan data total pemilih
        $total_penduduk = $penduduk_aktif + $penduduk_belum_aktif;
        //menampilkan data pemilih berdasarkan usia, dari tabel pemilih
        $pemilih_per_usia = listPemilih::join('akun_desa', 'pemilih.akun_desa_id', '=', 'akun_desa.list_desa_nama')
        ->where('akun_desa.list_desa_nama', $akun_desa_nama)
        ->selectRaw('
            CASE
                WHEN TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) >= 17 AND TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) < 25 THEN "17-24 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) >= 25 AND TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) < 35 THEN "25-34 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) >= 35 AND TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) < 45 THEN "35-44 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) >= 45 AND TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) < 55 THEN "45-54 Tahun"
                WHEN TIMESTAMPDIFF(YEAR, pemilih.tgl_lahir, CURDATE()) >= 55 THEN "55 Tahun ke atas"
                ELSE "Usia Tidak Diketahui"
            END AS usia,
            COUNT(pemilih.nik) as total_penduduk
        ')
        ->groupBy('usia')
        ->orderByRaw('
            CASE
                WHEN usia = "17-24 Tahun" THEN 1
                WHEN usia = "25-34 Tahun" THEN 2
                WHEN usia = "35-44 Tahun" THEN 3
                WHEN usia = "45-54 Tahun" THEN 4
                WHEN usia = "55 Tahun ke atas" THEN 5
                ELSE 7
            END
        ')
        ->get();
        //menampilkan data pemilih berdasarkan jenis kelamin dari tabel pemilih
        $jenisKelamin = listPemilih::selectRaw('jenis_kelamin, COUNT(*) as jumlah')
            ->where('akun_desa_id', $akun_desa_nama)
            ->whereIn('jenis_kelamin', ['Laki-laki', 'Perempuan'])
            ->groupBy('jenis_kelamin')
            ->get();
        //menampilkan data status pemilih pada tabel akun_pemilih
        $jumlahMemilih = akunPemilih::selectRaw('status, COUNT(*) as jumlah')
            ->where('akun_desa_id', $akun_desa_nama)
            ->whereIn('status', ['Sudah Memilih', 'Belum Memilih'])
            ->groupBy('status')
            ->get();

        return view('petugas.dashboard',compact('jamDashboard','tanggalDashboard','persentaseSuara','namaKandidat','jumlahSuara','votingResults','jenisKelamin',
        'jumlahMemilih','penduduk_aktif','penduduk_belum_aktif','total_penduduk',
        'pemilih_per_usia'));

    }

}
