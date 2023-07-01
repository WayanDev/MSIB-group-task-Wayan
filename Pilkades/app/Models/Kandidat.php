<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kandidat extends Model
{
    use HasFactory;
    protected $table='kandidat';
    protected $primaryKey = 'id';
    protected $fillable = [
    'akun_desa_id','nama',
    'jenis_kelamin','usia',
    'visi','misi','foto',
];
    
    //Reference tabel akun_desa
    public function akun_desa()
    {
        return $this->belongsTo(akunDesa::class, 'akun_desa_id','list_desa_nama');
    }
    //Reasi ke tabel voting
    public function voting()
    {
        return $this->hasOne(Voting::class,'kandidat_id');
    }

    public function akun_pemilih()
    {
        return $this->belongsTo(akunPemilih::class, 'akun_desa_id','akun_desa_id');
    }
}
