<?php

namespace App\Imports;

use Carbon\Carbon;
use App\Models\listPemilih;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ListPemilihImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // Mengabaikan baris pertama (heading)
        if ($row[0] === 'heading'|| $row[4] === 'Tanggal Lahir') {
            return null;
        }
        if (!isset($row[4])) {
        return null;
        }

        $tglLahir = Carbon::parse($row[4])->format('Y-m-d');
        
        return new listPemilih([
            'nik' => $row[0],
            'akun_desa_id' => $row[1],
            'nama' => $row[2],
            'tmp_lahir' => $row[3],
            'tgl_lahir' => $tglLahir,
            'jenis_kelamin' => $row[5],
            'alamat' => $row[6],
            'status_perkawinan' => $row[7],
            'pekerjaan' => $row[8],
        ]);
    }
}
