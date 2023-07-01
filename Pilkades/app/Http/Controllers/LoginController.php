<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\akunDesa;
use App\Models\jadwalVoting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        
        if (Auth::guard('akun_desa')->attempt($credentials)) {
            $user = Auth::guard('akun_desa')->user();
            if ($user->role === 'admin') {
                Alert::success('Login Berhasil', 'Kamu berhasil login sebagai admin.')->autoClose(1000);
                return redirect()->route('admin.dashboard');
            } elseif ($user->role === 'petugas') {
                Alert::success('Login Berhasil', 'Kamu berhasil login sebagai petugas.')->autoClose(1000);
                return redirect()->route('petugas.dashboard');
            }
        } 
        elseif (Auth::guard('pemilih')->attempt($credentials)) {

        $user = Auth::guard('pemilih')->user();
        $jadwal = jadwalVoting::where('akun_desa_id', $user->akun_desa_id)->first();
        
        if ($jadwal) {
            $tanggalPemilihan = Carbon::parse($jadwal->tgl_pemilihan);
            $waktuMulai = Carbon::parse($jadwal->waktu_mulai);
            $waktuSelesai = Carbon::parse($jadwal->waktu_selesai);
    
            $sekarang = Carbon::now('Asia/Jakarta');
            //dd($sekarang,$waktuMulai, $waktuSelesai);
            if (
                $tanggalPemilihan->isSameDay($sekarang) &&
                $sekarang->hour >= $waktuMulai->hour &&
                $sekarang->minute >= $waktuMulai->minute &&
                $sekarang->second >= $waktuMulai->second &&

                ($sekarang->hour < $waktuSelesai->hour) ||
                ($sekarang->hour === $waktuSelesai->hour && ($sekarang->minute < $waktuSelesai->minute ||
                ($sekarang->minute === $waktuSelesai->minute && $sekarang->second <= $waktuSelesai->second)))
            ) {
                Alert::success('Login Berhasil', 'Kamu berhasil login sebagai pemilih.')->autoClose(3000);
                return redirect()->route('pemilih.dashboard');
            }else {
                Alert::error('Login Gagal', 'Voting belum dimulai atau telah selesai.')->autoClose(3000);
                return redirect()->back();
            }
        } else {
            Alert::error('Login Gagal', 'Jadwal pemilihan tidak ditemukan.')->autoClose(3000);
            return redirect()->back();
        }
    }

        Alert::error('Login Gagal', 'Username atau Password tidak sesuai')->autoClose(3000);
        return back()->withInput();
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
        Alert::info('Logout Berhasil', 'Kamu berhasil logout.')->autoClose(1000);
        return redirect()->route('login');
    }
}
