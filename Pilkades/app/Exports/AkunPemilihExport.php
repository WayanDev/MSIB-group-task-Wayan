<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\akunPemilih;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class AkunPemilihExport implements FromCollection, WithMapping, 
WithColumnFormatting, WithHeadings, ShouldAutoSize
{
    protected $akun_desa_id;

    public function __construct($akun_desa_id)
    {
        $this->akun_desa_id = $akun_desa_id;
    }

    //Membuat tipe format TEXT pada kolom NIK
    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_TEXT,
        ];
    }
    //Heading pada Excel
    public function headings(): array
    {
        return [
            'Username',
            'Nama',
            'Password',
            'Status',
            'Asal Desa',
        ];
    }
    //Export data pilihan
    public function map($row): array
    {
        return [
            '="' . $row->username . '"', // Format sebagai formula teks
            $row->nama,
            $row->password,
            $row->status,
            $row->akun_desa_id,
        ];
    }

    public function collection()
    {
        return akunPemilih::where('akun_desa_id', $this->akun_desa_id)->get();
    }
}
