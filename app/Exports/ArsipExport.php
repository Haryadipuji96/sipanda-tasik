<?php

namespace App\Exports;

use App\Models\Arsip;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;

class ArsipExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $search;

    public function __construct($search = '')
    {
        $this->search = $search;
    }

    /**
     * Ambil data arsip
     */
    public function collection()
    {
        $query = Arsip::with(['kategori']);

        // Filter berdasarkan pencarian jika ada
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%")
                  ->orWhere('nomor_dokumen', 'like', "%{$search}%")
                  ->orWhere('keterangan', 'like', "%{$search}%")
                  ->orWhereHas('kategori', function($q) use ($search) {
                      $q->where('nama_kategori', 'like', "%{$search}%");
                  });
            });
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Judul Dokumen',
            'Nomor Dokumen',
            'Tanggal Dokumen',
            'Tahun',
            'Kategori',
            'Keterangan',
            'File Dokumen'
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($arsip): array
    {
        static $no = 0;
        $no++;

        return [
            $no,
            $arsip->judul_dokumen,
            $arsip->nomor_dokumen ?? '-',
            $arsip->tanggal_dokumen ? \Carbon\Carbon::parse($arsip->tanggal_dokumen)->format('d-m-Y') : '-',
            $arsip->tahun ?? '-',
            $arsip->kategori->nama_kategori ?? '-',
            $arsip->keterangan ?? '-',
            $arsip->file_dokumen ?? '-'
        ];
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 40,  // Judul
            'C' => 20,  // Nomor
            'D' => 15,  // Tanggal
            'E' => 8,   // Tahun
            'F' => 20,  // Kategori
            'G' => 35,  // Keterangan
            'H' => 25,  // File
        ];
    }

    /**
     * Styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style untuk header (baris 1)
            1 => [
                'font' => [
                    'bold' => true, 
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '3B82F6'] // Biru
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                ]
            ],
        ];
    }
}