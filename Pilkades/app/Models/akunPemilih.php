<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
class akunPemilih extends Authenticatable
{
    use HasFactory;
    protected $table='akun_pemilih';
    protected $primaryKey ='id';
    protected $fillable = [
        'username',
        'nama',
        'password',
        'status',
        'akun_desa_id',
        'session_token',
        'created_at',
        'updated_at'
    ];
    
    //Reference ke tabel pemilih
    public function list_pemilih()
    {
        return $this->belongsTo(listPemilih::class, 'username', 'nik');
    }
    public function akun_desa()
    {
        return $this->belongsTo(akunDesa::class,'akun_desa_id','list_desa_nama');
    }
    //Reasi ke tabel voting
    public function voting()
    {
        return $this->hasOne(Voting::class);
    }

    public function kandidat()
    {
        return $this->hasOne(Kandidat::class, 'akun_desa_id');
    }

    public function jadwal_voting()
    {
        return $this->hasOne(jadwalVoting::class, 'akun_desa_id');
    }
}
