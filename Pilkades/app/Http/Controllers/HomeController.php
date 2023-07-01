<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\akunDesa;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function showVotingResults(Request $request)
    {
        // Mendapatkan semua desa dengan role petugas
        $akunDesaPetugas = akunDesa::where('role', 'petugas')->get();

        // Inisialisasi array untuk menyimpan hasil suara per desa
        $dataPerDesa = [];

        foreach ($akunDesaPetugas as $akunDesa) {
            $desaNama = $akunDesa->list_desa_nama;

            // Menampilkan Data Hasil Suara Kandidat per desa
            $votingResults = Voting::whereHas('akun_desa', function ($query) use ($desaNama) {
                $query->where('list_desa_nama', $desaNama);
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
            $kandidats = Kandidat::whereHas('akun_desa', function ($query) use ($desaNama) {
                $query->where('list_desa_nama', $desaNama);
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

            // Menyimpan data hasil suara per desa ke dalam array
            $dataPerDesa[] = [
                'desaNama' => $desaNama,
                'namaKandidat' => $namaKandidat,
                'jumlahSuara' => $jumlahSuara,
                'persentaseSuara' => $persentaseSuara
            ];
        }

        // Mengirim data hasil suara per desa ke view home.blade.php
        return view('home', compact('dataPerDesa'));
    }
}
