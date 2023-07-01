<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listPemilih extends Model
{
    use HasFactory;
    protected $table='pemilih';
    protected $primaryKey ='nik';
    protected $fillable = [
        'nik',
        'akun_desa_id',
        'nama',
        'tmp_lahir',
        'tgl_lahir',
        'jenis_kelamin',
        'alamat',
        'status_perkawinan',
        'pekerjaan'
    ];
    
    //Reference ke tabel akun_desa
    public function akun_desa()
    {
        return $this->belongsTo(akunDesa::class,'akun_desa_id','list_desa_nama');
    }
    //Relasi ke tabel akun_pemilih 
    public function akun_pemilih()
    {
        return $this->hasOne(akunPemilih::class, 'username', 'nik');
    }
}
