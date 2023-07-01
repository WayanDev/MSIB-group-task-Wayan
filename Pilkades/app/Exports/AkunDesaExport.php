<?php

namespace App\Exports;

use App\Models\akunDesa;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class AkunDesaExport implements FromCollection,WithHeadings,ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return akunDesa::select('list_desa_nama', 'username', 'password', 'role')->get();
    }

    public function headings(): array
    {
        return [
            'Asal Desa',
            'Username',
            'Password',
            'Role',
        ];
    }
}
