<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voting extends Model
{
    use HasFactory;
    protected $table='voting';
    protected $fillable = [
        'kandidat_id',
        'akun_pemilih_id'
    ];


    //Reference tabel akun_pemilih
    public function akun_pemilih()
    {
        return $this->belongsTo(akunPemilih::class);
    }
    //Reference tabel kandidat
    public function kandidat()
    {
        return $this->belongsTo(Kandidat::class);
    }

    public function akun_desa()
    {
        return $this->belongsTo(akunDesa::class, 'akun_desa_id','list_desa_nama');
    }
}
