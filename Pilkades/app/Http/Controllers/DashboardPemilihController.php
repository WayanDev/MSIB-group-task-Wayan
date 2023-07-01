<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardPemilihController extends Controller
{
    public function index()
{
    if (auth()->check()) {
        if (auth()->guard('pemilih')->check()) {
            return $this->pemilihDashboard();
        }
    }

    return redirect()->route('login');
}
private function pemilihDashboard()
    {
        $sekarang = Carbon::now('Asia/Jakarta')->locale('id');
        $jamDashboard = $sekarang->format('H:i');
        $tanggalDashboard = $sekarang->translatedFormat('l, d F Y');

        return view('pemilih.dashboard',compact('jamDashboard','tanggalDashboard'));
    }
}

