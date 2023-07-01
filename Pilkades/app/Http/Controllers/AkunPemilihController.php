<?php

namespace App\Http\Controllers;

use App\Models\akunDesa;
use App\Models\akunPemilih;
use App\Models\listPemilih;
use Illuminate\Http\Request;
use App\Exports\AkunPemilihExport;
use App\Imports\AkunPemilihImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class AkunPemilihController extends Controller
{
    //Export excel
    public function akunpemilihexport()
    {
        $user = Auth::guard('akun_desa')->user();
        $akun_desa_id = $user->list_desa_nama;

        return Excel::download(new AkunPemilihExport($akun_desa_id), 'AkunPemilih.xlsx');
    }

    //Import Excel
    public function akunpemilihimport(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $namaFile = $file->getClientOriginalName();
                $path = public_path('DataAkunPemilih') . '/' . $namaFile;

                $file->move(public_path('DataAkunPemilih'), $namaFile);
                // $data = Excel::toArray(new AkunPemilihImport, $path);
                // dd($data);

                Excel::import(new AkunPemilihImport, $path);
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
        $akunDesa = Auth::guard('akun_desa')->user();

        if ($akunDesa->role === 'admin') {
            // Jika yang login adalah admin, tampilkan semua data pemilih
            $akun_pemilih = akunPemilih::with('akun_desa')->get();
        } elseif ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, filter data pemilih berdasarkan akun_desa_id dan list_desa_nama
            $akun_pemilih = akunPemilih::whereHas('akun_desa', function ($query) use ($akunDesa) {
                    $query->where('list_desa_nama', $akunDesa->list_desa_nama);
            })
            ->get();
        }

        return view('petugas.akun_pemilih.index',compact('akun_pemilih'));
    }

    public function create()
    {
        $akunDesa = Auth::guard('akun_desa')->user();

        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, tampilkan hanya pemilih dengan akun_desa_id yang sama dengan list_desa_nama petugas
            $list_pemilih = listPemilih::whereHas('akun_desa', function ($query) use ($akunDesa) {
                $query->where('list_desa_nama', $akunDesa->list_desa_nama);
            })->get();
        }

        return view('petugas.akun_pemilih.create', compact('list_pemilih'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'username' => 'required|unique:akun_pemilih',
            'nama' => 'required',
            'password' => 'required',
            'status' => 'required',
            'akun_desa_id' => 'required',
        ],[
            'username.required' => 'Username harus diisi',
            'username.unique' => 'Username sudah terdaftar',
            'nama.required' => 'Nama harus diisi',
            'password.required' => 'Password harus diisi',
            'status.required' => 'Status harus diisi',
            'akun_desa_id.required' => 'Asal Desa harus diisi'
        ]);

        $akun_pemilih = new akunPemilih();
        $akun_pemilih->username = $validatedData['username'];
        $akun_pemilih->nama = $validatedData['nama'];
        $akun_pemilih->password = Hash::make($validatedData['password']);
        $akun_pemilih->status = $validatedData['status'];
        $akun_pemilih->akun_desa_id = $validatedData['akun_desa_id'];
        $akun_pemilih->save();

        Alert::success('Sukses', 'Data akun pemilih berhasil ditambahkan')->persistent(true)->autoClose(1000);

        return redirect()->route('akun_pemilih.index');
    }

    public function edit($id)
    {
        $akun_pemilih = akunPemilih::findOrFail($id);

        return view('petugas.akun_pemilih.edit', compact('akun_pemilih'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required',
        ],
        [
            'status.required' => 'Status harus diisi.',
        ]);

        $akun_pemilih = akunPemilih::findOrFail($id);
        $akun_pemilih->status = $request->input('status');
        // Periksa apakah input password kosong
        // Jika inputan kosong maka password yang sebelumnya akan dipertahankan
        if ($request->has('password') && !empty($request->input('password'))) {
            $newPassword = $request->input('password');

            // Periksa apakah password baru tidak sama dengan password sebelumnya
            if (!Hash::check($newPassword, $akun_pemilih->password)) {
                $akun_pemilih->password = Hash::make($newPassword);
            } else {
                return redirect()->back()->withErrors(['password' => 'Password baru tidak boleh sama dengan password sebelumnya.'])->withInput();
            }
        }

        $akun_pemilih->save();

        Alert::info('Berhasil', 'Berhasil merubah data akun pemilih')->persistent(true)->autoClose(1000);

        return redirect()->route('akun_pemilih.index');
    }


    public function destroy(akunPemilih $akun_pemilih)
    {
        $akun_pemilih->delete();
        Alert::info('Berhasil', 'Berhasil menghapus data akun pemilih')->persistent(true)->autoClose(1000);
        return redirect()->route('akun_pemilih.index');
    }
}
