<?php

namespace App\Http\Controllers;

use App\Models\akunDesa;
use PDF;
use App\Models\akunPemilih;
use App\Models\listPemilih;
use Illuminate\Http\Request;
use App\Exports\ListPemilihExport;
use App\Imports\ListPemilihImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class ListPemilihController extends Controller
{

    //Export PDF
    public function exportpemilih(){
        $user = Auth::guard('akun_desa')->user();

        if ($user->role == 'petugas') {
            $desaPetugas = $user->list_desa_nama;
            $data = listPemilih::where('akun_desa_id', $desaPetugas)->get();
        } else {
            $data = listPemilih::all();
        }

        view()->share('data', $data);
        $pdf = PDF::loadView('laporan.data-pemilih');
        $pdf->setPaper('A4', 'landscape');
        return $pdf->stream('data-pemilih.pdf');
        //return $pdf->download('data-pemilih.pdf');
    }


    //Export excel
    public function listpemilihexport()
    {
        $user = Auth::guard('akun_desa')->user();
        $akun_desa_id = $user->list_desa_nama;

        return Excel::download(new ListPemilihExport($akun_desa_id), 'ListPemilih.xlsx');
    }

    //Import Excel
    public function listpemilihimport(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $namaFile = $file->getClientOriginalName();
                $path = public_path('DataListPemilih') . '/' . $namaFile;

                $file->move(public_path('DataListPemilih'), $namaFile);
            
                Excel::import(new ListPemilihImport, $path);
                Alert::info('Berhasil', 'Import Data')->persistent(true)->autoClose(5000);
            } else {
                throw new \Exception('Tidak ada file yang diunggah.');
            }
        } catch (\Exception $e) {
            $errorMessage = 'Terjadi kesalahan saat mengunggah file. Periksa apakah ada data duplikat?';
            Alert::error('Gagal', $errorMessage)->persistent(true)->autoClose(5000);
        }

        return redirect()->back();
    }




    public function index()
    {
        if (Auth::guard('akun_desa')->check()) {
            $akunDesa = Auth::guard('akun_desa')->user();

            if ($akunDesa->role === 'admin') {
                // Jika yang login adalah admin, tampilkan semua data pemilih
                $list_pemilih = listPemilih::with('akun_desa')->get();
            } elseif ($akunDesa->role === 'petugas') {
                // Jika yang login adalah petugas, filter data pemilih berdasarkan akun_desa_id dan list_desa_nama
                $list_pemilih = listPemilih::whereHas('akun_desa', function ($query) use ($akunDesa) {
                        $query->where('list_desa_nama', $akunDesa->list_desa_nama);
                })
                ->get();
            }
        }

        return view('list_pemilih.index', compact('list_pemilih'));
    }


    public function create()
    {
        $akunDesa = Auth::guard('akun_desa')->user();

        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, tampilkan hanya desa yang terkait dengan akun desa tersebut
            $akun_desa = akunDesa::where('list_desa_nama', $akunDesa->list_desa_nama)->get();
        } 
        return view('list_pemilih.create', compact('akun_desa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:pemilih,nik|size:16',
            'akun_desa_id' => 'required',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'status_perkawinan' => 'required',
            'pekerjaan' => 'required'
        ],[
            'nik.required' => 'NIK harus diisi',
            'nik.unique' => 'NIK sudah ada dalam daftar pemilih',
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'akun_desa_id.required' => 'Akun Desa harus dipilih',
            'nama.required' => 'Nama harus diisi',
            'tmp_lahir.required' => 'Tempat Lahir harus diisi',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi',
            'tgl_lahir.date' => 'Tanggal Lahir harus dalam format tanggal yang valid',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih',
            'alamat.required' => 'Alamat harus diisi',
            'status_perkawinan.required' => 'Status Perkawinan harus diisi',
            'pekerjaan.required' => 'Pekerjaan harus diisi'
        ]);
        $list_pemilih = new listPemilih;
        $list_pemilih->nik = $request->nik;
        $list_pemilih->akun_desa_id = $request->akun_desa_id;
        $list_pemilih->nama = $request->nama;
        $list_pemilih->tmp_lahir = $request->tmp_lahir;
        $list_pemilih->tgl_lahir = $request->tgl_lahir;
        $list_pemilih->jenis_kelamin = $request->jenis_kelamin;
        $list_pemilih->alamat = $request->alamat;
        $list_pemilih->status_perkawinan = $request->status_perkawinan;
        $list_pemilih->pekerjaan = $request->pekerjaan;

        $list_pemilih->save();

        Alert::info('Berhasil', 'Data pemilih berhasil ditambahkan')->persistent(true)->autoClose(1000);

        return redirect()->route('list_pemilih.index');

    }

    public function edit($nik)
    {
        $akunDesa = Auth::guard('akun_desa')->user();

        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, tampilkan hanya desa yang terkait dengan akun desa tersebut
            $akun_desa = akunDesa::where('list_desa_nama', $akunDesa->list_desa_nama)->get();
        }
        $list_pemilih = listPemilih::findOrFail($nik);

        return view('list_pemilih.edit', compact('list_pemilih', 'akun_desa'));
    }

    public function update(Request $request, $nik)
    {
        $request->validate([
            'nik' => 'required|size:16',
            'akun_desa_id' => 'required',
            'nama' => 'required',
            'tmp_lahir' => 'required',
            'tgl_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'alamat' => 'required',
            'status_perkawinan' => 'required',
            'pekerjaan' => 'required'
        ],[
            'nik.required' => 'NIK harus diisi',
            'nik.size' => 'NIK harus terdiri dari 16 digit',
            'akun_desa_id.required' => 'Akun Desa harus dipilih',
            'nama.required' => 'Nama harus diisi',
            'tmp_lahir.required' => 'Tempat Lahir harus diisi',
            'tgl_lahir.required' => 'Tanggal Lahir harus diisi',
            'tgl_lahir.date' => 'Tanggal Lahir harus dalam format tanggal yang valid',
            'jenis_kelamin.required' => 'Jenis Kelamin harus dipilih',
            'alamat.required' => 'Alamat harus diisi',
            'status_perkawinan.required' => 'Status Perkawinan harus diisi',
            'pekerjaan.required' => 'Pekerjaan harus diisi'
        ]);
        $list_pemilih = listPemilih::findOrFail($nik);
        $list_pemilih->nik = $request->nik;
        $list_pemilih->akun_desa_id = $request->akun_desa_id;
        $list_pemilih->nama = $request->nama;
        $list_pemilih->tmp_lahir = $request->tmp_lahir;
        $list_pemilih->tgl_lahir = $request->tgl_lahir;
        $list_pemilih->jenis_kelamin = $request->jenis_kelamin;
        $list_pemilih->alamat = $request->alamat;
        $list_pemilih->status_perkawinan = $request->status_perkawinan;
        $list_pemilih->pekerjaan = $request->pekerjaan;

        $list_pemilih->save();

        Alert::info('Berhasil', 'Berhasil merubah data pemilih')->persistent(true)->autoClose(1000);

        return redirect()->route('list_pemilih.index');
    }

    public function destroy($nik)
    {
        $list_pemilih = listPemilih::findOrFail($nik);
        $list_pemilih->delete();

        Alert::info('Berhasil', 'Berhasil menghapus data pemilih')->persistent(true)->autoClose(1000);
        return redirect()->route('list_pemilih.index');
    }

    

}
