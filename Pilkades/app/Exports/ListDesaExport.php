<?php

namespace App\Exports;

use App\Models\listDesa;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ListDesaExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return listDesa::select('nama', 'alamat_kantor')->get();
    }

    public function headings(): array
    {
        return [
            'Nama',
            'Alamat Kantor'
        ];
    }
}
