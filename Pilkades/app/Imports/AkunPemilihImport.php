<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\akunPemilih;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunPemilihImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Mengabaikan baris pertama (heading)
        if ($row[0] === 'Username') {
            return null;
        }

        return new akunPemilih([
            'username' => $row[0],
            'nama' => $row[1],
            'password' => Hash::make($row[2]),
            'status' => $row[3],
            'akun_desa_id' => $row[4],
        ]);
    }
}
