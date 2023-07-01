<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class akunDesa extends Authenticatable
{
    use HasFactory, Notifiable;
    
    protected $table='akun_desa';
    protected $primaryKey ='id';
    protected $fillable = ['list_desa_nama', 'username', 'password', 'role', 'session_token'];
    

    public function list_desa()
    {
        return $this->belongsTo(listDesa::class,'list_desa_nama', 'nama');
    }
    public function jadwal_voting()
    {
        return $this->hasMany(jadwalVoting::class, 'akun_desa_id');
    }
    public function list_pemilih()
    {
        return $this->hasMany(listPemilih::class,'akun_desa_id');
    }
    public function akun_pemilih()
    {
        return $this->hasMany(akunPemilih::class,'akun_desa_id');
    }
    public function kandidat()
    {
        return $this->hasMany(Kandidat::class, 'akun_desa_id');
    }

    public function voting()
    {
        return $this->hasMany(Voting::class, 'akun_desa_id');
    }
}
