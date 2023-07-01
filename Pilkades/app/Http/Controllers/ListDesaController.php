<?php

namespace App\Http\Controllers;
use App\Models\akunDesa;
use App\Models\listDesa;
use Illuminate\Http\Request;
use App\Exports\ListDesaExport;
use App\Imports\ListDesaImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;

class ListDesaController extends Controller
{
    //Export List Desa
    public function listdesaexport()
    {
        return Excel::download(new ListDesaExport, 'List_Desa.xlsx');
    }

    //Import List Desa
    public function listdesaimport(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $namaFile = $file->getClientOriginalName();
                $path = public_path('DataListDesa') . '/' . $namaFile;

                $file->move(public_path('DataListDesa'), $namaFile);
            
                Excel::import(new ListDesaImport, $path);
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
        $list_desa = listDesa::all();
        return view('admin.list_desa.index',compact('list_desa'));
    }

    public function create()
    {
        $list_desa = listDesa::all();
        return view('admin.list_desa.create', compact('list_desa'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'alamat_kantor' => 'required',
        ]);

        // Jika validasi sukses, simpan data ke database
        $listDesa = new listDesa;
        $listDesa->nama = $request->nama;
        $listDesa->alamat_kantor = $request->alamat_kantor;
        $listDesa->save();

        Alert::success('Sukses', 'Data desa berhasil ditambahkan')->persistent(true)->autoClose(1000);
        return redirect()->route('list_desa.index');
    }

    public function edit($nama)
    {
        //Menampilkan form edit
        $list_desa = listDesa::findOrFail($nama);
        return view('admin.list_desa.edit', compact('list_desa'));
    }

    public function update(Request $request, $nama)
    {
        $validatedData = $request->validate([
            'nama' => 'required',
            'alamat_kantor' => 'required',
        ],[
            'nama.required' => 'Nama desa harus diisi.',
            'alamat_kantor.required' => 'Alamat kantor harus diisi.',
        ]);
        $list_desa = listDesa::findOrFail($nama);
        $list_desa->nama = $validatedData['nama'];
        $list_desa->alamat_kantor = $validatedData['alamat_kantor'];
        $list_desa->save();

        Alert::info('Berhasil', 'Berhasil mengedit Desa')->persistent(true)->autoClose(3000);
        return redirect()->route('list_desa.index');
    }
    
    // public function destroy(string $nama)
    // {
    //     $list_desa = listDesa::findOrFail($nama);
    //     $list_desa->delete();

    //     return redirect()->route('list_desa.index')->with('success', 'Data desa berhasil dihapus');
    // }
}
