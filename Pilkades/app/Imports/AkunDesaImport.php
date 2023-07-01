<?php

namespace App\Imports;

use App\Models\akunDesa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class AkunDesaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Mengabaikan baris pertama (heading)
        if ($row[0] === 'Asal Desa') {
            return null;
        }

        return new akunDesa([
            'list_desa_nama' => $row[0],
            'username' => $row[1],
            'password' => Hash::make($row[2]),
            'role' => $row[3],
        ]);
    }
}
