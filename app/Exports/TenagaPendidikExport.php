<?php

namespace App\Exports;

use App\Models\TenagaPendidik;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class TenagaPendidikExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $search;

    public function __construct($search = '')
    {
        $this->search = $search;
    }

    /**
     * Ambil data tenaga pendidik
     */
    public function collection()
    {
        $query = TenagaPendidik::with('prodi.fakultas');

        // Filter berdasarkan pencarian jika ada
        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tendik', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('jabatan_struktural', 'like', "%{$search}%")
                    ->orWhere('status_kepegawaian', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        return $query->orderBy('nama_tendik')->get();
    }

    /**
     * Header kolom Excel
     */
    public function headings(): array
    {
        return [
            'No',
            'Nama Tenaga Pendidik',
            'Gelar Depan',
            'Gelar Belakang',
            'Posisi/Jabatan Struktural',
            'Program Studi',
            'Fakultas',
            'Status Kepegawaian',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'TMT Kerja',
            'Pendidikan Terakhir',
            'NIP/NIK',
            'Email',
            'No HP',
            'Alamat',
            'Riwayat Golongan',
            'Keterangan',
            // Tambahan kolom status file
            'File KTP',
            'File KK',
            'File Ijazah S1',
            'File Transkrip S1',
            'File Ijazah S2',
            'File Transkrip S2',
            'File Ijazah S3',
            'File Transkrip S3',
            'File Perjanjian Kerja',
            'File SK',
            'File Surat Tugas',
            'File Dokumen Lainnya'
        ];
    }

    /**
     * Mapping data ke kolom
     */
    public function map($tendik): array
    {
        static $no = 0;
        $no++;

        // Format riwayat golongan
        $riwayatGolongan = '';
        if (!empty($tendik->golongan_array)) {
            $golonganArray = is_array($tendik->golongan_array) 
                ? $tendik->golongan_array 
                : json_decode($tendik->golongan_array, true);
            
            if (is_array($golonganArray)) {
                foreach ($golonganArray as $index => $gol) {
                    if (!empty($gol['tahun']) || !empty($gol['golongan'])) {
                        $riwayatGolongan .= ($index + 1) . ". " . ($gol['golongan'] ?? '-') . " (" . ($gol['tahun'] ?? '-') . ")\n";
                    }
                }
            }
        }

        return [
            $no,
            $tendik->nama_tendik,
            $tendik->gelar_depan ?? '-',
            $tendik->gelar_belakang ?? '-',
            $tendik->jabatan_struktural ?? '-',
            $tendik->prodi->nama_prodi ?? '-',
            $tendik->prodi->fakultas->nama_fakultas ?? '-',
            $this->getStatusLabel($tendik->status_kepegawaian),
            $this->getJenisKelaminLabel($tendik->jenis_kelamin),
            $tendik->tempat_lahir ?? '-',
            $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->format('d-m-Y') : '-',
            $tendik->tmt_kerja ? \Carbon\Carbon::parse($tendik->tmt_kerja)->format('d-m-Y') : '-',
            $tendik->pendidikan_terakhir ?? '-',
            $tendik->nip ?? '-',
            $tendik->email ?? '-',
            $tendik->no_hp ?? '-',
            $tendik->alamat ?? '-',
            $riwayatGolongan ?: '-',
            $tendik->keterangan ?? '-',
            // Tambahan status file
            $tendik->file_ktp ? 'ADA' : 'TIDAK ADA',
            $tendik->file_kk ? 'ADA' : 'TIDAK ADA',
            $tendik->file_ijazah_s1 ? 'ADA' : 'TIDAK ADA',
            $tendik->file_transkrip_s1 ? 'ADA' : 'TIDAK ADA',
            $tendik->file_ijazah_s2 ? 'ADA' : 'TIDAK ADA',
            $tendik->file_transkrip_s2 ? 'ADA' : 'TIDAK ADA',
            $tendik->file_ijazah_s3 ? 'ADA' : 'TIDAK ADA',
            $tendik->file_transkrip_s3 ? 'ADA' : 'TIDAK ADA',
            $tendik->file_perjanjian_kerja ? 'ADA' : 'TIDAK ADA',
            $tendik->file_sk ? 'ADA' : 'TIDAK ADA',
            $tendik->file_surat_tugas ? 'ADA' : 'TIDAK ADA',
            $tendik->file ? 'ADA' : 'TIDAK ADA'
        ];
    }

    /**
     * Konversi status kepegawaian ke label
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'KONTRAK' => 'KONTRAK',
            'TETAP' => 'TETAP'
        ];

        return $labels[$status] ?? $status;
    }

    /**
     * Konversi jenis kelamin ke label
     */
    private function getJenisKelaminLabel($jenisKelamin)
    {
        $labels = [
            'laki-laki' => 'Laki-laki',
            'perempuan' => 'Perempuan'
        ];

        return $labels[$jenisKelamin] ?? $jenisKelamin;
    }

    /**
     * Lebar kolom
     */
    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama Tenaga Pendidik
            'C' => 12,  // Gelar Depan
            'D' => 12,  // Gelar Belakang
            'E' => 25,  // Posisi/Jabatan Struktural
            'F' => 20,  // Program Studi
            'G' => 20,  // Fakultas
            'H' => 15,  // Status Kepegawaian
            'I' => 12,  // Jenis Kelamin
            'J' => 15,  // Tempat Lahir
            'K' => 12,  // Tanggal Lahir
            'L' => 12,  // TMT Kerja
            'M' => 20,  // Pendidikan Terakhir
            'N' => 15,  // NIP/NIK
            'O' => 25,  // Email
            'P' => 15,  // No HP
            'Q' => 30,  // Alamat
            'R' => 25,  // Riwayat Golongan
            'S' => 30,  // Keterangan
            // Lebar kolom untuk status file
            'T' => 8,   // File KTP
            'U' => 8,   // File KK
            'V' => 10,  // File Ijazah S1
            'W' => 12,  // File Transkrip S1
            'X' => 10,  // File Ijazah S2
            'Y' => 12,  // File Transkrip S2
            'Z' => 10,  // File Ijazah S3
            'AA' => 12, // File Transkrip S3
            'AB' => 12, // File Perjanjian Kerja
            'AC' => 8,  // File SK
            'AD' => 12, // File Surat Tugas
            'AE' => 12, // File Dokumen Lainnya
        ];
    }

    /**
     * Styling untuk Excel
     */
    public function styles(Worksheet $sheet)
    {
        // Dapatkan jumlah baris
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Style untuk header (baris 1)
        $sheet->getStyle('A1:AE1')->applyFromArray([
            'font' => [
                'bold' => true, 
                'size' => 10,
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID,
                'startColor' => ['rgb' => '3B82F6'] // Biru
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
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
        $sheet->getStyle('A2:AE' . $highestRow)
              ->applyFromArray([
                  'alignment' => [
                      'vertical' => Alignment::VERTICAL_TOP,
                      'wrapText' => true
                  ],
                  'borders' => [
                      'allBorders' => [
                          'borderStyle' => Border::BORDER_THIN
                      ]
                  ]
              ]);

        // Border untuk semua data
        $sheet->getStyle('A1:AE' . $highestRow)
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        // Auto filter
        $sheet->setAutoFilter('A1:AE' . $highestRow);

        // Set wrap text untuk kolom tertentu yang butuh
        $sheet->getStyle('R2:R' . $highestRow)
              ->getAlignment()
              ->setWrapText(true);
        $sheet->getStyle('S2:S' . $highestRow)
              ->getAlignment()
              ->setWrapText(true);

        // Style untuk kolom tertentu
        $sheet->getStyle('A2:A' . $highestRow)
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        
        $sheet->getStyle('K2:L' . $highestRow)
              ->getAlignment()
              ->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Style untuk kolom status file (center alignment)
        $fileColumns = ['T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE'];
        foreach ($fileColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . $highestRow)
                  ->getAlignment()
                  ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Freeze pane untuk header
        $sheet->freezePane('A2');

        return [
            1 => [
                'font' => [
                    'bold' => true, 
                    'size' => 10,
                    'color' => ['rgb' => 'FFFFFF']
                ],
            ],
        ];
    }
}