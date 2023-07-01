<?php

namespace App\Http\Controllers\Api;

use App\Models\Voting;
use App\Models\akunDesa;
use App\Models\Kandidat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $akunDesaPetugas = akunDesa::where('role', 'petugas')->get();
        $dataPerDesa = [];

        foreach ($akunDesaPetugas as $akunDesa) {
            $desaNama = $akunDesa->list_desa_nama;

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

            $kandidats = Kandidat::whereHas('akun_desa', function ($query) use ($desaNama) {
                $query->where('list_desa_nama', $desaNama);
            })->get();

            $persentaseSuara = [];

            foreach ($kandidats as $kandidat) {
                if (!in_array($kandidat->nama, $namaKandidat)) {
                    $namaKandidat[] = $kandidat->nama;
                    $jumlahSuara[] = 0;
                }
            }

            $totalSuara = array_sum($jumlahSuara);

            foreach ($jumlahSuara as $suara) {
                if ($totalSuara > 0) {
                    $persentaseSuara[] = number_format(($suara / $totalSuara) * 100, 2) . "%";
                } else {
                    $persentaseSuara[] = "0%";
                }
            }

            $dataPerDesa[] = [
                'desaNama' => $desaNama,
                'namaKandidat' => $namaKandidat,
                'jumlahSuara' => $jumlahSuara,
                'persentaseSuara' => $persentaseSuara
            ];
        }

        return response()->json([
            'success' => true,
            'message' => 'Voting Results',
            'data' => $dataPerDesa
        ], 200);
    }
}
