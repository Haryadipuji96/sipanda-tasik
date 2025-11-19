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
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class SarprasExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths, WithColumnFormatting
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
        $query = DataSarpras::with(['prodi.fakultas', 'ruangan']);

        // Filter berdasarkan pencarian jika ada
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kategori_barang', 'like', "%{$search}%")
                  ->orWhere('merk_barang', 'like', "%{$search}%")
                  ->orWhere('kode_seri', 'like', "%{$search}%")
                  ->orWhereHas('prodi', function($q) use ($search) {
                      $q->where('nama_prodi', 'like', "%{$search}%");
                  })
                  ->orWhereHas('ruangan', function($q) use ($search) {
                      $q->where('nama_ruangan', 'like', "%{$search}%");
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
            'Ruangan',
            'Kategori Ruangan',
            'Nama Barang',
            'Kategori Barang',
            'Merk Barang',
            'Jumlah',
            'Satuan',
            'Harga (Rp)',
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
            $sarpras->prodi->nama_prodi ?? 'Unit Umum',
            $sarpras->prodi->fakultas->nama_fakultas ?? '-',
            $sarpras->nama_ruangan,
            $sarpras->kategori_ruangan,
            $sarpras->nama_barang,
            $sarpras->kategori_barang,
            $sarpras->merk_barang ?? '-',
            $sarpras->jumlah,
            $sarpras->satuan,
            $sarpras->harga ?: 0,
            $sarpras->kondisi,
            $sarpras->tanggal_pengadaan ? \Carbon\Carbon::parse($sarpras->tanggal_pengadaan)->format('d-m-Y') : '-',
            $sarpras->spesifikasi,
            $sarpras->kode_seri,
            $sarpras->sumber,
            $sarpras->keterangan ?? '-',
            $sarpras->lokasi_lain ?? '-'
        ];
    }

    /**
     * Format kolom
     */
    public function columnFormats(): array
    {
        return [
            'K' => NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1, // Format harga
        ];
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
            'D' => 20,  // Ruangan
            'E' => 15,  // Kategori Ruangan
            'F' => 25,  // Nama Barang
            'G' => 15,  // Kategori Barang
            'H' => 15,  // Merk Barang
            'I' => 8,   // Jumlah
            'J' => 8,   // Satuan
            'K' => 15,  // Harga
            'L' => 12,  // Kondisi
            'M' => 15,  // Tanggal Pengadaan
            'N' => 40,  // Spesifikasi
            'O' => 20,  // Kode Seri
            'P' => 12,  // Sumber
            'Q' => 25,  // Keterangan
            'R' => 20,  // Lokasi Lain
        ];
    }

    /**
     * Styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Style untuk header (baris 1)
        $sheet->getStyle('A1:R1')->applyFromArray([
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
        $sheet->getStyle('A2:R' . ($sheet->getHighestRow()))
              ->getAlignment()
              ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
              ->setWrapText(true);

        // Style khusus untuk kolom harga (rata kanan)
        $sheet->getStyle('K2:K' . ($sheet->getHighestRow()))
              ->getAlignment()
              ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

        // Style khusus untuk kolom jumlah (rata tengah)
        $sheet->getStyle('I2:I' . ($sheet->getHighestRow()))
              ->getAlignment()
              ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Style khusus untuk kolom kondisi (rata tengah)
        $sheet->getStyle('L2:L' . ($sheet->getHighestRow()))
              ->getAlignment()
              ->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

        // Border untuk semua data
        $sheet->getStyle('A1:R' . ($sheet->getHighestRow()))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        // Auto filter
        $sheet->setAutoFilter('A1:R' . ($sheet->getHighestRow()));

        // Freeze panes (header tetap terlihat saat scroll)
        $sheet->freezePane('A2');

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