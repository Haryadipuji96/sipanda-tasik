<?php

namespace App\Exports;

use App\Models\DataSarpras;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class SarprasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $search;
    protected $kondisi;

    public function __construct($search = '', $kondisi = '')
    {
        $this->search = $search;
        $this->kondisi = $kondisi;
    }

    /**
     * Ambil data sarpras
     */
    public function collection()
    {
        $query = DataSarpras::with('prodi.fakultas');

        // Filter berdasarkan pencarian jika ada
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kategori', 'like', "%{$search}%")
                  ->orWhere('kode_seri', 'like', "%{$search}%")
                  ->orWhereHas('prodi', function($q) use ($search) {
                      $q->where('nama_prodi', 'like', "%{$search}%");
                  });
            });
        }

        // Filter berdasarkan kondisi jika ada
        if (!empty($this->kondisi)) {
            $query->where('kondisi', $this->kondisi);
        }

        return $query->orderBy('nama_barang')->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Program Studi',
            'Fakultas',
            'Nama Barang',
            'Kategori',
            'Jumlah',
            'Kondisi',
            'Tanggal Pengadaan',
            'Spesifikasi',
            'Kode Seri',
            'Sumber',
            'Keterangan',
            'Lokasi Lain'
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($sarpras): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $sarpras->prodi->nama_prodi ?? 'Umum',
            $sarpras->prodi->fakultas->nama_fakultas ?? '-',
            $sarpras->nama_barang,
            $sarpras->kategori,
            $sarpras->jumlah,
            $this->getKondisiLabel($sarpras->kondisi),
            $sarpras->tanggal_pengadaan ? \Carbon\Carbon::parse($sarpras->tanggal_pengadaan)->format('d-m-Y') : '-',
            $sarpras->spesifikasi,
            $sarpras->kode_seri,
            $this->getSumberLabel($sarpras->sumber),
            $sarpras->keterangan ?? '-',
            $sarpras->lokasi_lain ?? '-'
        ];
    }

    /**
     * Konversi nilai kondisi ke label yang lebih readable
     */
    private function getKondisiLabel($kondisi)
    {
        $labels = [
            'baik' => 'Baik',
            'rusak_ringan' => 'Rusak Ringan',
            'rusak_berat' => 'Rusak Berat',
            'perbaikan' => 'Dalam Perbaikan'
        ];

        return $labels[$kondisi] ?? $kondisi;
    }

    /**
     * Konversi nilai sumber ke label yang lebih readable
     */
    private function getSumberLabel($sumber)
    {
        $labels = [
            'HIBAH' => 'Hibah',
            'LEMBAGA' => 'Lembaga',
            'YAYASAN' => 'Yayasan'
        ];

        return $labels[$sumber] ?? $sumber;
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 20,  // Program Studi
            'C' => 20,  // Fakultas
            'D' => 30,  // Nama Barang
            'E' => 15,  // Kategori
            'F' => 8,   // Jumlah
            'G' => 12,  // Kondisi
            'H' => 15,  // Tanggal Pengadaan
            'I' => 40,  // Spesifikasi
            'J' => 20,  // Kode Seri
            'K' => 12,  // Sumber
            'L' => 25,  // Keterangan
            'M' => 20,  // Lokasi Lain
        ];
    }

    /**
     * Styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris 1)
        $sheet->getStyle('A1:M1')->applyFromArray([
            'font' => [
                'bold' => true, 
                'size' => 11,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3B82F6'] // Biru
            ],
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ]);

        // Style untuk data
        $sheet->getStyle('A2:M' . ($sheet->getHighestRow()))
              ->getAlignment()
              ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
              ->setWrapText(true);

        // Border untuk semua data
        $sheet->getStyle('A1:M' . ($sheet->getHighestRow()))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        // Auto filter
        $sheet->setAutoFilter('A1:M' . ($sheet->getHighestRow()));

        return [
            1 => [
                'font' => [
                    'bold' => true, 
                    'size' => 11,
                    'color' => ['rgb' => 'FFFFFF']
                ],
            ],
        ];
    }
}