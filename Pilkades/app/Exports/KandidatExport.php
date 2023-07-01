<?php

namespace App\Exports;

use App\Models\Kandidat;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;


class KandidatExport implements FromCollection, WithMapping, ShouldAutoSize, WithEvents,WithHeadings
{
    protected $akun_desa_id;

    public function __construct($akun_desa_id)
    {
        $this->akun_desa_id = $akun_desa_id;
    }

    public function collection()
    {
        return Kandidat::where('akun_desa_id', $this->akun_desa_id)->get();
    }
    //Heading pada Excel
    public function headings(): array
    {
        return [
            'Asal Desa',
            'Nama',
            'Jenis Kelamin',
            'Usia',
            'Visi',
            'Misi',
            'Foto',
        ];
    }
    public function map($kandidat): array
    {
        return [
            $kandidat->akun_desa_id,
            $kandidat->nama,
            $kandidat->jenis_kelamin,
            $kandidat->usia,
            $kandidat->visi,
            $kandidat->misi,
            $kandidat->foto,
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                // Mendapatkan lembar kerja aktif
                $sheet = $event->sheet->getDelegate();
                // Mendapatkan koleksi data kandidat
                $kandidat = $this->collection();

                // Looping untuk menambahkan gambar pada setiap baris
            foreach ($kandidat as $index => $row) {
                $rowIndex = $index + 2;
                $imagePath = public_path('/' . $row->foto); // Ubah dengan path direktori gambar Anda
                $drawing = new Drawing();
                $drawing->setName($row->foto);
                $drawing->setDescription($row->foto);
                $drawing->setPath($imagePath);
                $drawing->setCoordinates('G' . $rowIndex); // Kolom G untuk gambar
                $drawing->setHeight(80);
   
                // Menentukan posisi gambar pada kolom
                $drawing->setWorksheet($sheet);
            }
        },
    ];
    }
}