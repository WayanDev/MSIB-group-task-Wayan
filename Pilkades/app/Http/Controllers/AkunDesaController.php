<?php

namespace App\Http\Controllers;
use App\Models\akunDesa;
use App\Models\Kandidat;
use App\Models\listDesa;
use App\Models\listPemilih;
use App\Models\jadwalVoting;
use Illuminate\Http\Request;
use App\Exports\AkunDesaExport;
use App\Imports\AkunDesaImport;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use RealRashid\SweetAlert\Facades\Alert;

class AkunDesaController extends Controller
{

    //Export Akun Desa
    public function akundesaexport()
    {
        return Excel::download(new AkunDesaExport, 'Akun_Desa.xlsx');
    }
    
    //Import List Desa
    public function akundesaimport(Request $request)
    {
        try {
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $namaFile = $file->getClientOriginalName();
                $path = public_path('DataAkunDesa') . '/' . $namaFile;

                $file->move(public_path('DataAkunDesa'), $namaFile);
                // $data = Excel::toArray(new AkunDesaImport, $path);
                // dd($data);

                Excel::import(new AkunDesaImport, $path);
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
        $akun_desa = akunDesa::with('list_desa')->get();
        return view('admin.akun_desa.index', compact('akun_desa'));
    }

    public function create()
    {
        $list_desa = listDesa::all();
        return view('admin.akun_desa.create',compact('list_desa'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'list_desa_nama' => 'required|unique:akun_desa',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
        ],[
            'list_desa_nama.required' => 'Nama desa harus dipilih.',
            'username.required' => 'Username harus diisi.',
            'password.required' => 'Password harus diisi.',
            'role.required' => 'Role harus dipilih.',
        ]);

        $akun_desa = new akunDesa();
        $akun_desa->list_desa_nama = $validatedData['list_desa_nama'];
        $akun_desa->username = $validatedData['username'];
        $akun_desa->password = Hash::make($validatedData['password']);
        $akun_desa->role = $validatedData['role'];
        $akun_desa->save();

        Alert::success('Sukses', 'Data desa berhasil ditambahkan')->persistent(true)->autoClose(1000);

        return redirect()->route('akun_desa.index');
    }

    public function edit($id)
    {
        $akun_desa = akunDesa::findOrFail($id);
        $list_desa = listDesa::all();
        return view('admin.akun_desa.edit', compact('akun_desa', 'list_desa'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'username' => 'required',
        ]);

        $akun_desa = akunDesa::findOrFail($id);
        // Periksa apakah input password kosong 
        // Jika inputan kosong maka password yang sebelumnya akan dipertahankan 
        if ($request->has('password') && !empty($request->input('password'))) {
            $akun_desa->password = Hash::make($request->input('password'));
        }
        // Update data lainnya...
        $akun_desa->username = $request->input('username');
        $akun_desa->role = $request->input('role');
        
        // Simpan perubahan ke database
        $akun_desa->save();

        Alert::info('Berhasil', 'Berhasil mengedit data akun desa')->persistent(true)->autoClose(1000);

        return redirect()->route('akun_desa.index');
    }

    public function destroy($id)
    {
        $akun_desa = akunDesa::findOrFail($id);
        $akun_desa->delete();
        Alert::info('Berhasil', 'Berhasil menghapus data akun desa')->persistent(true)->autoClose(1000);
        return redirect()->route('akun_desa.index')->with('success', 'Akun Desa berhasil dihapus');
    }
}
