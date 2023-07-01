<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class listDesa extends Model
{
    use HasFactory;
    protected $table='list_desa';
    protected $primaryKey = 'nama';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['nama','alamat_kantor'];

    //Relasi ke tabel akun_desa
    public function akun_desa()
    {
        return $this->hasOne(akunDesa::class,'list_desa_nama', 'nama');
    }

}
