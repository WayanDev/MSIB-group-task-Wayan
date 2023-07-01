<?php

namespace App\Http\Controllers;

use App\Models\Voting;
use App\Models\Kandidat;
use App\Models\akunPemilih;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class VotingController extends Controller
{
    public function index()
    {
        $akunDesa = Auth::guard('akun_desa')->user();
        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, filter data pemilih berdasarkan akun_desa_id dan list_desa_nama
            $voting = Voting::whereHas('akun_desa', function ($query) use ($akunDesa) {
                    $query->where('list_desa_nama', $akunDesa->list_desa_nama);
            })
            ->get();
        }
        //$kandidat = Kandidat::with('akun_desa')->get();
        return view('petugas.voting.index', compact('voting'));
    }

    public function store(Request $request)
    {
        // Validasi data input
        $request->validate([
            'kandidat_id' => 'required|exists:kandidat,id',
        ]);

        $kandidatId = $request->input('kandidat_id');
        $akunPemilihId = Auth::guard('pemilih')->user()->id; // atau sesuaikan dengan cara Anda mendapatkan ID akun pemilih

        // Periksa apakah pemilih sudah memilih sebelumnya
        $akunPemilih = akunPemilih::find($akunPemilihId);
        if ($akunPemilih->status === 'Sudah Memilih') {
            Alert::info('Maaf', 'Anda sudah melakukan voting');
            return redirect()->back();
        }

        // Simpan data voting
        $voting = new Voting();
        $voting->kandidat_id = $kandidatId;
        $voting->akun_pemilih_id = $akunPemilihId;
        $voting->akun_desa_id = Auth::guard('pemilih')->user()->akun_desa_id; // Mengambil nilai akun_desa_id dari akun pemilih yang sedang login
        $voting->save();

        // Ubah status pemilih menjadi "Sudah Memilih"
        $akunPemilih->status = 'Sudah Memilih';
        $akunPemilih->save();
        Alert::success('Good', 'Terima kasih sudah menyumbangkan Hak Suaramu');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $voting = Voting::findOrFail($id);
        $voting->delete();

        Alert::info('Berhasil', 'Berhasil menghapus data pemilih')->persistent(true)->autoClose(1000);
        return redirect()->route('voting.index');
    }

    public function destroyAll()
    {
        Voting::truncate();

        Alert::info('Berhasil', 'Berhasil menghapus semua data pemilih')->persistent(true)->autoClose(1000);
        return redirect()->route('voting.index');
    }

}
