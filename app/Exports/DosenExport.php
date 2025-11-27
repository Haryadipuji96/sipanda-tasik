<?php

namespace App\Exports;

use App\Models\Dosen;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class DosenExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithColumnWidths
{
    protected $search;

    public function __construct($search = '')
    {
        $this->search = $search;
    }

    public function collection()
    {
        $query = Dosen::with(['prodi.fakultas']);

        if (!empty($this->search)) {
            $search = $this->search;
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('jabatan', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('nuptk', 'like', "%{$search}%")
                  ->orWhere('gelar_depan', 'like', "%{$search}%")
                  ->orWhere('gelar_belakang', 'like', "%{$search}%")
                  ->orWhereHas('prodi', function($q) use ($search) {
                      $q->where('nama_prodi', 'like', "%{$search}%");
                  });
            });
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama Lengkap',
            'Gelar Depan',
            'Gelar Belakang',
            'Program Studi', 
            'Fakultas',
            'Tempat/Tanggal Lahir',
            'NIDN',
            'NUPTK',
            'Pendidikan Terakhir',
            'Jabatan',
            'TMT Kerja',
            'Masa Kerja (Tahun)',
            'Masa Kerja (Bulan)',
            'Pangkat/Golongan',
            'Jabatan Fungsional',
            'Masa Kerja Golongan (Tahun)',
            'Masa Kerja Golongan (Bulan)',
            'No SK',
            'JaFung (No SK)',
            'Status Dosen',
            'Sertifikasi',
            'File Sertifikasi',
            'Inpasing',
            'File Inpasing',
            'File KTP',
            'File Ijazah S1',
            'File Transkrip S1',
            'File Ijazah S2', 
            'File Transkrip S2',
            'File Ijazah S3',
            'File Transkrip S3',
            'File Jafung',
            'File KK',
            'File Perjanjian Kerja',
            'File SK Pengangkatan',
            'File Surat Pernyataan',
            'File SKTP',
            'File Surat Tugas',
            'File SK Aktif Tridharma',
        ];
    }

    public function map($dosen): array
    {
        static $no = 0;
        $no++;

        // Format tempat/tanggal lahir sesuai dengan show
        $tempatTanggalLahir = $dosen->tempat_tanggal_lahir ?? '-';

        // Status dosen text
        $statusDosenText = $dosen->status_dosen_text ?? '-';

        return [
            $no,
            $dosen->nama,
            $dosen->gelar_depan ?? '-',
            $dosen->gelar_belakang ?? '-',
            $dosen->prodi->nama_prodi ?? '-',
            $dosen->prodi->fakultas->nama_fakultas ?? '-',
            $tempatTanggalLahir,
            $dosen->nik ?? '-',
            $dosen->nuptk ?? '-',
            $dosen->pendidikan_terakhir ?? '-',
            $dosen->jabatan ?? '-',
            $dosen->tmt_kerja ?? '-',
            $dosen->masa_kerja_tahun ?? 0,
            $dosen->masa_kerja_bulan ?? 0,
            $dosen->pangkat_golongan ?? '-',
            $dosen->jabatan_fungsional ?? '-',
            $dosen->masa_kerja_golongan_tahun ?? 0,
            $dosen->masa_kerja_golongan_bulan ?? 0,
            $dosen->no_sk ?? '-',
            $dosen->no_sk_jafung ?? '-',
            $statusDosenText,
            $dosen->sertifikasi ?? '-',
            $dosen->file_sertifikasi ? 'ADA' : 'TIDAK ADA',
            $dosen->inpasing ?? '-',
            $dosen->file_inpasing ? 'ADA' : 'TIDAK ADA',
            $dosen->file_ktp ? 'ADA' : 'TIDAK ADA',
            $dosen->file_ijazah_s1 ? 'ADA' : 'TIDAK ADA',
            $dosen->file_transkrip_s1 ? 'ADA' : 'TIDAK ADA',
            $dosen->file_ijazah_s2 ? 'ADA' : 'TIDAK ADA',
            $dosen->file_transkrip_s2 ? 'ADA' : 'TIDAK ADA',
            $dosen->file_ijazah_s3 ? 'ADA' : 'TIDAK ADA',
            $dosen->file_transkrip_s3 ? 'ADA' : 'TIDAK ADA',
            $dosen->file_jafung ? 'ADA' : 'TIDAK ADA',
            $dosen->file_kk ? 'ADA' : 'TIDAK ADA',
            $dosen->file_perjanjian_kerja ? 'ADA' : 'TIDAK ADA',
            $dosen->file_sk_pengangkatan ? 'ADA' : 'TIDAK ADA',
            $dosen->file_surat_pernyataan ? 'ADA' : 'TIDAK ADA',
            $dosen->file_sktp ? 'ADA' : 'TIDAK ADA',
            $dosen->file_surat_tugas ? 'ADA' : 'TIDAK ADA',
            $dosen->file_sk_aktif ? 'ADA' : 'TIDAK ADA',
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 25,  // Nama Lengkap
            'C' => 12,  // Gelar Depan
            'D' => 15,  // Gelar Belakang
            'E' => 20,  // Program Studi
            'F' => 20,  // Fakultas
            'G' => 20,  // Tempat/Tanggal Lahir
            'H' => 15,  // NIDN
            'I' => 15,  // NUPTK
            'J' => 18,  // Pendidikan Terakhir
            'K' => 18,  // Jabatan
            'L' => 12,  // TMT Kerja
            'M' => 8,   // Masa Kerja Thn
            'N' => 8,   // Masa Kerja Bln
            'O' => 15,  // Pangkat/Golongan
            'P' => 18,  // Jabatan Fungsional
            'Q' => 8,   // MK Gol Thn
            'R' => 8,   // MK Gol Bln
            'S' => 15,  // No SK
            'T' => 15,  // JaFung SK
            'U' => 15,  // Status Dosen
            'V' => 10,  // Sertifikasi
            'W' => 8,   // File Sertifikasi
            'X' => 10,  // Inpasing
            'Y' => 8,   // File Inpasing
            'Z' => 6,   // File KTP
            'AA' => 8,  // File Ijazah S1
            'AB' => 10, // File Transkrip S1
            'AC' => 8,  // File Ijazah S2
            'AD' => 10, // File Transkrip S2
            'AE' => 8,  // File Ijazah S3
            'AF' => 10, // File Transkrip S3
            'AG' => 7,  // File Jafung
            'AH' => 6,  // File KK
            'AI' => 12, // File Perjanjian Kerja
            'AJ' => 12, // File SK Pengangkatan
            'AK' => 12, // File Surat Pernyataan
            'AL' => 7,  // File SKTP
            'AM' => 10, // File Surat Tugas
            'AN' => 12, // File SK Aktif
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Dapatkan jumlah baris
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Style untuk header
        $sheet->getStyle('A1:AN1')->applyFromArray([
            'font' => [
                'bold' => true, 
                'size' => 10, 
                'color' => ['rgb' => 'FFFFFF']
            ],
            'fill' => [
                'fillType' => Fill::FILL_SOLID, 
                'startColor' => ['rgb' => '3B82F6']
            ],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER,
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN
                ]
            ],
        ]);

        // Style untuk data
        $sheet->getStyle('A2:AN' . $highestRow)
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

        // Style khusus untuk kolom status file
        $fileColumns = ['W', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN'];
        foreach ($fileColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . $highestRow)
                  ->getAlignment()
                  ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Auto filter
        $sheet->setAutoFilter('A1:AN' . $highestRow);

        // Freeze pane untuk header
        $sheet->freezePane('A2');

        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}