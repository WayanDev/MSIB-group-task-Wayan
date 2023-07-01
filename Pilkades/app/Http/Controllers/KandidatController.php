<?php

namespace App\Http\Controllers;

use App\Models\akunDesa;
use App\Models\Kandidat;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Exports\KandidatExport;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class KandidatController extends Controller
{
    // public function exportKandidat()
    // {
    //     $user = Auth::guard('akun_desa')->user();
    //     $akun_desa_id = $user->list_desa_nama;

    //     return Excel::download(new KandidatExport($akun_desa_id), 'Kandidat.xlsx');
    // }
    
    public function index()
    {
        $akunDesa = Auth::guard('akun_desa')->user();
        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, filter data pemilih berdasarkan akun_desa_id dan list_desa_nama
            $kandidat = Kandidat::whereHas('akun_desa', function ($query) use ($akunDesa) {
                    $query->where('list_desa_nama', $akunDesa->list_desa_nama);
            })
            ->get();
        }
        //$kandidat = Kandidat::with('akun_desa')->get();
        return view('petugas.kandidat.index', compact('kandidat'));
    }

    public function create()
    {
        $akunDesa = Auth::guard('akun_desa')->user();
        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, tampilkan hanya desa yang terkait dengan akun desa tersebut
            $akun_desa = akunDesa::where('list_desa_nama', $akunDesa->list_desa_nama)->get();
        } 
        return view('petugas.kandidat.create', compact('akun_desa'));
    }

    public function store(Request $request)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'akun_desa_id' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'usia' => 'required|integer',
            'visi' => 'required',
            'misi' => 'required',
            'foto' => 'nullable|image|max:2048',
        ]);
        // Jika validasi gagal bawaan laravel
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $kandidat = new Kandidat;
        $kandidat->akun_desa_id = $request->input('akun_desa_id');
        $kandidat->nama = $request->input('nama');
        $kandidat->jenis_kelamin = $request->input('jenis_kelamin');
        $kandidat->usia = $request->input('usia');
        $kandidat->visi = $request->input('visi');
        $kandidat->misi = $request->input('misi');
        // Periksa dan simpan file gambar yang baru diunggah
        if ($request->hasFile('foto')) {
            $photo = $request->file('foto');
            $filename = time() . '.' . Str::slug($request->input('nama')) . '.' . $photo->getClientOriginalExtension();

            $photoPath = $photo->move('photos', $filename);
            $kandidat->foto = $photoPath;
        }else{
            // Jika tidak ada foto yang diunggah, set foto ke noimage.png
            $kandidat->foto = 'photos/noimage.png';
        }

        $kandidat->save();
        Alert::success('Sukses', 'Data kandidat berhasil ditambahkan')->persistent(true)->autoClose(1000);
        return redirect()->route('petugas.kandidat');
    }

    public function show()
    {
        $akun_pemilih = Auth::guard('pemilih')->user();
        $kandidat = null; // Inisialisasi variabel $kandidat dengan nilai awal null
        if (Auth::guard('pemilih')->check()) {
            // Jika yang login adalah petugas, filter data pemilih berdasarkan akun_desa_id dan list_desa_nama
            $kandidat = Kandidat::whereHas('akun_pemilih', function ($query) use ($akun_pemilih) {
                    $query->where('akun_desa_id', $akun_pemilih->akun_desa_id);
            })
            ->get();
        }
        //$kandidat = Kandidat::with('akun_desa')->get();
        return view('pemilih.kandidat', compact('kandidat','akun_pemilih'));
    }

    public function edit($id)
    {
        $akunDesa = Auth::guard('akun_desa')->user();
        if ($akunDesa->role === 'petugas') {
            // Jika yang login adalah petugas, tampilkan hanya desa yang terkait dengan akun desa tersebut
            $akun_desa = akunDesa::where('list_desa_nama', $akunDesa->list_desa_nama)->get();
        }
        $kandidat = Kandidat::with('akun_desa')->findOrFail($id);
        return view('petugas.kandidat.edit', compact('kandidat', 'akun_desa'));
    }

    public function update(Request $request, $id)
    {
        // Validasi inputan
        $validator = Validator::make($request->all(), [
            'akun_desa_id' => 'required',
            'nama' => 'required',
            'jenis_kelamin' => 'required',
            'usia' => 'required|integer',
            'visi' => 'required',
            'misi' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        // Jika validasi gagal bawaan laravel
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $kandidat = Kandidat::findOrFail($id);
        $kandidat->akun_desa_id = $request->input('akun_desa_id');
        $kandidat->nama = $request->input('nama');
        $kandidat->jenis_kelamin = $request->input('jenis_kelamin');
        $kandidat->usia = $request->input('usia');
        $kandidat->visi = $request->input('visi');
        $kandidat->misi = $request->input('misi');
        
        // Upload dan simpan foto baru
        if ($request->hasFile('foto')) {
            $fotoBaruPath = $request->file('foto');
            $filename = time() . '.' . Str::slug($request->input('nama')) . '.' . $fotoBaruPath->getClientOriginalExtension();

            $fotoBaruPath->move(public_path('photos'), $filename);
    
            // Hapus foto lama 
            if ($kandidat->foto && file_exists(public_path($kandidat->foto))) {
                unlink(public_path($kandidat->foto));
            }

            $kandidat->foto = 'photos/' . $filename;
        }

        $kandidat->save();
        Alert::info('Berhasil', 'Berhasil merubah data kandidat')->persistent(true)->autoClose(1000);
        return redirect()->route('petugas.kandidat');
    }

    public function destroy($id)
    {
        $kandidat = Kandidat::findOrFail($id);
        if ($kandidat->foto) {
            $fotoPath = public_path('' . $kandidat->foto);
            //dd($fotoPath); // Cetak path untuk memverifikasi
            if (file_exists($fotoPath)) {
                unlink($fotoPath);
            }
        }
        $kandidat->delete();
        Alert::info('Berhasil', 'Berhasil menghapus data kandidat')->persistent(true)->autoClose(1000);
        return redirect()->route('petugas.kandidat');
    }
}
