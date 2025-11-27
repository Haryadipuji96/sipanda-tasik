<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;

class TemplateBarangRuanganExport implements FromArray, WithHeadings, WithTitle, WithEvents
{
    protected $ruangan;

    public function __construct($ruangan)
    {
        $this->ruangan = $ruangan;
    }

    public function array(): array
    {
        $currentYear = date('Y');

        return [
            // Contoh data dengan beberapa field nullable/kosong
            ["Kursi Kantor", "PERABOTAN & FURNITURE", "IKEA", 500000, 2, "unit", "Baik", "2024-01-15", $currentYear, "LEMBAGA", "Kursi kantor ergonomis", "KRS-001", "", "Untuk ruang staff"],
            ["Laptop ASUS", "ELEKTRONIK & TEKNOLOGI", "", 8000000, 1, "unit", "Baik Sekali", "", $currentYear, "HIBAH", "ASUS Vivobook 15, Intel i5, 8GB RAM", "LAP-001", "Gedung B Lantai 2", ""],
            ["Meja Kayu", "PERABOTAN & FURNITURE", "", "", 5, "buah", "Baik", "2024-03-10", "", "YAYASAN", "Meja kayu jati ukuran 120x60cm", "MEJA-001", "", ""],
            ["Proyektor", "ELEKTRONIK & TEKNOLOGI", "Epson", 3500000, 2, "unit", "Cukup", "", 2023, "LEMBAGA", "Proyektor LCD 3000 lumens", "PROJ-001", "", "Perlu perawatan"],
            ['', '', '', '', '', '', '', '', '', '', '', '', '', ''],
        ];
    }

    public function headings(): array
    {
        return [
            'nama_barang*',
            'kategori_barang*',
            'merk_barang', // TANPA * (bisa kosong)
            'harga_rp', // TANPA * (bisa kosong)
            'jumlah*',
            'satuan*',
            'kondisi*',
            'tanggal_pengadaan', // TANPA * (bisa kosong)
            'tahun_pengadaan', // TANPA * (bisa kosong)
            'sumber_barang*',
            'spesifikasi*',
            'kodeseri_barang*',
            'lokasi_lain', // TANPA * (bisa kosong)
            'keterangan' // TANPA * (bisa kosong)
        ];
    }

    public function title(): string
    {
        return 'Template';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                // ========== DROPDOWN KATEGORI BARANG ==========
                $kategoriOptions = [
                    'PERABOTAN & FURNITURE',
                    'ELEKTRONIK & TEKNOLOGI',
                    'PERALATAN LABORATORIUM',
                    'PERALATAN KANTOR',
                    'ALAT KOMUNIKASI',
                    'LAINNYA'
                ];

                $validation = $sheet->getDataValidation('B2:B100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $kategoriOptions) . '"');

                // ========== DROPDOWN SATUAN ==========
                $satuanOptions = ['unit', 'buah', 'set', 'lusin', 'paket'];

                $validation = $sheet->getDataValidation('F2:F100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $satuanOptions) . '"');

                // ========== DROPDOWN KONDISI ==========
                $kondisiOptions = ['Baik Sekali', 'Baik', 'Cukup', 'Rusak Ringan', 'Rusak Berat'];

                $validation = $sheet->getDataValidation('G2:G100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $kondisiOptions) . '"');

                // ========== DROPDOWN SUMBER BARANG ==========
                $sumberOptions = ['HIBAH', 'LEMBAGA', 'YAYASAN'];

                $validation = $sheet->getDataValidation('J2:J100');
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1('"' . implode(',', $sumberOptions) . '"');

                // ========== STYLING ==========
                $sheet->getStyle('A1:N1')->applyFromArray([
                    'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']]
                ]);

                // Set column widths
                $sheet->getColumnDimension('A')->setWidth(25); // nama_barang
                $sheet->getColumnDimension('B')->setWidth(25); // kategori_barang
                $sheet->getColumnDimension('C')->setWidth(20); // merk_barang
                $sheet->getColumnDimension('D')->setWidth(15); // harga_rp
                $sheet->getColumnDimension('E')->setWidth(10); // jumlah
                $sheet->getColumnDimension('F')->setWidth(10); // satuan
                $sheet->getColumnDimension('G')->setWidth(15); // kondisi
                $sheet->getColumnDimension('H')->setWidth(15); // tanggal_pengadaan
                $sheet->getColumnDimension('I')->setWidth(15); // tahun_pengadaan
                $sheet->getColumnDimension('J')->setWidth(15); // sumber_barang
                $sheet->getColumnDimension('K')->setWidth(35); // spesifikasi
                $sheet->getColumnDimension('L')->setWidth(20); // kodeseri_barang
                $sheet->getColumnDimension('M')->setWidth(20); // lokasi_lain
                $sheet->getColumnDimension('N')->setWidth(25); // keterangan

                // CATATAN SINGKAT - TANPA STYLING - TANPA EMOJI
                $sheet->setCellValue('A7', 'CATATAN PENTING:');
                $sheet->setCellValue('A8', '- Ganti data barang yang sudah ada/hapus, dan masukan data baru:');
                $sheet->setCellValue('A9', '- Kolom bertanda * wajib diisi');
                $sheet->setCellValue('A10', '- Spesifikasi*: jika tidak ada, tulis "Tidak ada"');
                $sheet->setCellValue('A11', '- Kode Barang*: jika tidak ada, tulis "Tidak ada"');
                $sheet->setCellValue('A12', '- Harga: angka tanpa titik (contoh: 500000)');
                $sheet->setCellValue('A13', '- Tanggal: YYYY-MM-DD (contoh: 2024-01-31/ boleh kosong)');
                $sheet->setCellValue('A14', '- Hapus catatan ini sebelum import data');
            },
        ];
    }
}
