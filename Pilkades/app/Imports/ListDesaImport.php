<?php

namespace App\Imports;

use App\Models\listDesa;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;

class ListDesaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Mengabaikan baris pertama (heading)
        if ($row[0] === 'Nama') {
            return null;
        }

        return new listDesa([
            'nama' => $row[0],
            'alamat_kantor' => $row[1],
        ]);
    }
}
