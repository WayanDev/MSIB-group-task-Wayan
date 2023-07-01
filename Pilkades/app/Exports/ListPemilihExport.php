<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\listPemilih;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;


class ListPemilihExport implements FromCollection, WithMapping, 
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
            'NIK',
            'Asal Desa',
            'Nama',
            'Tempat Lahir',
            'Tanggal Lahir',
            'Jenis Kelamin',
            'Alamat',
            'Status Perkawinan',
            'Pekerjaan',
        ];
    }
    //Export data pilihan
    public function map($row): array
    {
        // Format ulang tanggal menjadi format yang diinginkan (tanpa tanda '-')
        $tglLahir = Carbon::createFromFormat('Y-m-d', $row->tgl_lahir)->format('Ymd');
        return [
            '="' . $row->nik . '"', // Format sebagai formula teks
            $row->akun_desa_id,
            $row->nama,
            $row->tmp_lahir,
            $tglLahir,
            $row->jenis_kelamin,
            $row->alamat,
            $row->status_perkawinan,
            $row->pekerjaan,
        ];
    }

    public function collection()
    {
        return listPemilih::where('akun_desa_id', $this->akun_desa_id)->get();
    }
}
