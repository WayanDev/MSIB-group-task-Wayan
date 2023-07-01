<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jadwalVoting extends Model
{
    use HasFactory;
    protected $table='jadwal';
    protected $primaryKey ='id';
    protected $fillable = [
        'akun_desa_id',
        'tgl_pemilihan','waktu_mulai',
        'waktu_selesai',
    ];
    //Reference ke tabel akun_desa
    public function akun_desa()
    {
        return $this->belongsTo(akunDesa::class, 'akun_desa_id', 'list_desa_nama');
    }

    public function akun_pemilih()
    {
        return $this->belongsTo(akunPemilih::class,'akun_desa_id');
    }
}
