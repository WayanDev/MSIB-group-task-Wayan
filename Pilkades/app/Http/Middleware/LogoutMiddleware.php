<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use App\Models\JadwalVoting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class LogoutMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure  $next
     * @param  mixed  ...$guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guard)
    {
        $user = Auth::guard('pemilih')->user();
        $jadwal = JadwalVoting::where('akun_desa_id', $user->akun_desa_id)->first();

        if ($jadwal) {
            $waktuSelesai = Carbon::parse($jadwal->waktu_selesai);
            $sekarang = Carbon::now('Asia/Jakarta');

            if (($sekarang->hour > $waktuSelesai->hour) ||
                ($sekarang->hour === $waktuSelesai->hour && ($sekarang->minute > $waktuSelesai->minute ||
                ($sekarang->minute === $waktuSelesai->minute && $sekarang->second >= $waktuSelesai->second)))
            ) {
                Auth::guard('pemilih')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                Alert::info('Info', 'Waktu pemilihan telah berakhir. Anda telah logout secara otomatis.')->autoClose(3000);
                return redirect('/login');
            }
        }

        return $next($request);
    }
}
