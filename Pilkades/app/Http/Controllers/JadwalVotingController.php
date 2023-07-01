<?php

namespace App\Http\Controllers;

use App\Models\akunDesa;
use App\Models\jadwalVoting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;

class JadwalVotingController extends Controller
{
    public function index()
    {
        $jadwal_votings = jadwalVoting::with('akun_desa')->get();
        return view('admin.jadwal_voting.index', compact('jadwal_votings'));
    }

    public function create()
    {
        $akun_desas = akunDesa::all();
        return view('admin.jadwal_voting.create', compact('akun_desas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'akun_desa_id' => 'required',
            'tgl_pemilihan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ],[
            'akun_desa_id.required' => 'Akun Desa desa harus dipilih.',
            'tgl_pemilihan.required'=> 'Tanggal Pemilihan desa harus dipilih.',
            'waktu_mulai.required' => 'Waktu Mulai harus ditentukan.',
            'waktu_selesai.required'=> 'Waktu selesai harus ditentukan.',
        ]);

        jadwalVoting::create($request->all());

        Alert::success('Sukses', 'Data Jadwal Voting berhasil ditambahkan')->persistent(true)->autoClose(1000);

        return redirect()->route('jadwal_voting.index');

    }


    public function edit($id)
    {
        $jadwal_voting = jadwalVoting::findOrFail($id);
        $akun_desas = akunDesa::all();
        return view('admin.jadwal_voting.edit', compact('jadwal_voting', 'akun_desas'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'akun_desa_id' => 'required',
            'tgl_pemilihan' => 'required',
            'waktu_mulai' => 'required',
            'waktu_selesai' => 'required',
        ],[
            'tgl_pemilihan.required'=> 'Tanggal Pemilihan desa harus dipilih.',
            'waktu_mulai.required' => 'Waktu Mulai harus ditentukan.',
            'waktu_selesai.required'=> 'Waktu selesai harus ditentukan.',
        ]);

        $jadwal_voting = jadwalVoting::findOrFail($id);
        $jadwal_voting->akun_desa_id = $validatedData['akun_desa_id'];
        $jadwal_voting->tgl_pemilihan = $validatedData['tgl_pemilihan'];
        $jadwal_voting->waktu_mulai = $validatedData['waktu_mulai'];
        $jadwal_voting->waktu_selesai = $validatedData['waktu_selesai'];
        $jadwal_voting->save();

        Alert::info('Berhasil', 'Berhasil merubah data jadwal voting')->persistent(true)->autoClose(1000);

        return redirect()->route('jadwal_voting.index');
    }

    public function destroy($id)
    {
        $jadwal_voting = jadwalVoting::findOrFail($id);
        $jadwal_voting->delete();
        Alert::info('Berhasil', 'Berhasil merubah data jadwal voting')->persistent(true)->autoClose(1000);
        return redirect()->route('jadwal_voting.index');
    }
}
