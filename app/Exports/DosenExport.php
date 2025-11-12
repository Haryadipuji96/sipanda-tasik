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
            'Tempat Lahir',
            'Tanggal Lahir',
            'NIDN',
            'NUPTK',
            'Pendidikan Terakhir',
            'Jenjang Pendidikan',
            'Prodi/Jurusan',
            'Tahun Lulus',
            'Universitas',
            'Jabatan',
            'TMT Kerja',
            'Masa Kerja (Tahun)',
            'Masa Kerja (Bulan)',
            'Pangkat/Golongan',
            'Jabatan Fungsional',
            'Masa Kerja Gol (Tahun)',
            'Masa Kerja Gol (Bulan)',
            'No SK',
            'JaFung (No SK)',
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
        $rows = [];
        $pendidikan = $dosen->pendidikan_array ?? [];
        
        // Jika tidak ada pendidikan, buat 1 baris
        if (empty($pendidikan)) {
            $no++;
            $rows[] = $this->createRow($no, $dosen, [
                'jenjang' => '-',
                'prodi' => '-',
                'tahun_lulus' => '-',
                'universitas' => '-'
            ]);
        } else {
            // Buat baris untuk setiap pendidikan
            foreach ($pendidikan as $index => $pend) {
                $no++;
                $rows[] = $this->createRow(
                    $index === 0 ? $no : '', // Hanya tampilkan nomor di baris pertama
                    $dosen, 
                    $pend,
                    $index === 0 // Hanya tampilkan data dosen di baris pertama
                );
            }
        }
        
        return $rows;
    }

    private function createRow($no, $dosen, $pendidikan, $showDosenData = true)
    {
        if ($showDosenData) {
            return [
                $no,
                $dosen->nama,
                $dosen->gelar_depan ?? '-',
                $dosen->gelar_belakang ?? '-',
                $dosen->prodi->nama_prodi ?? '-',
                $dosen->prodi->fakultas->nama_fakultas ?? '-',
                $dosen->tempat_lahir ?? '-',
                $dosen->tanggal_lahir ? \Carbon\Carbon::parse($dosen->tanggal_lahir)->format('d-m-Y') : '-',
                $dosen->nik ?? '-',
                $dosen->nuptk ?? '-',
                $dosen->pendidikan_terakhir ?? '-',
                $pendidikan['jenjang'] ?? '-',
                $pendidikan['prodi'] ?? '-',
                $pendidikan['tahun_lulus'] ?? '-',
                $pendidikan['universitas'] ?? '-',
                $dosen->jabatan ?? '-',
                $dosen->tmt_kerja ? \Carbon\Carbon::parse($dosen->tmt_kerja)->format('d-m-Y') : '-',
                $dosen->masa_kerja_tahun ?? 0,
                $dosen->masa_kerja_bulan ?? 0,
                $dosen->pangkat_golongan ?? '-',
                $dosen->jabatan_fungsional ?? '-',
                $dosen->masa_kerja_golongan_tahun ?? 0,
                $dosen->masa_kerja_golongan_bulan ?? 0,
                $dosen->no_sk ?? '-',
                $dosen->no_sk_jafung ?? '-',
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
        } else {
            // Baris tambahan untuk pendidikan, data dosen dikosongkan
            return [
                '', // No
                '', // Nama
                '', // Gelar Depan
                '', // Gelar Belakang
                '', // Prodi
                '', // Fakultas
                '', // Tempat Lahir
                '', // Tanggal Lahir
                '', // NIDN
                '', // NUPTK
                '', // Pendidikan Terakhir
                $pendidikan['jenjang'] ?? '-',
                $pendidikan['prodi'] ?? '-',
                $pendidikan['tahun_lulus'] ?? '-',
                $pendidikan['universitas'] ?? '-',
                '', // Jabatan
                '', // TMT Kerja
                '', // Masa Kerja Thn
                '', // Masa Kerja Bln
                '', // Pangkat
                '', // JaFung
                '', // MK Gol Thn
                '', // MK Gol Bln
                '', // No SK
                '', // JaFung SK
                '', // Sertifikasi
                '', // File Sertifikasi
                '', // Inpasing
                '', // File Inpasing
                '', // File KTP
                '', // File Ijazah S1
                '', // File Transkrip S1
                '', // File Ijazah S2
                '', // File Transkrip S2
                '', // File Ijazah S3
                '', // File Transkrip S3
                '', // File Jafung
                '', // File KK
                '', // File Perjanjian Kerja
                '', // File SK Pengangkatan
                '', // File Surat Pernyataan
                '', // File SKTP
                '', // File Surat Tugas
                '', // File SK Aktif
            ];
        }
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
            'G' => 15,  // Tempat Lahir
            'H' => 12,  // Tanggal Lahir
            'I' => 15,  // NIDN
            'J' => 15,  // NUPTK
            'K' => 18,  // Pendidikan Terakhir
            'L' => 12,  // Jenjang Pendidikan
            'M' => 20,  // Prodi/Jurusan
            'N' => 10,  // Tahun Lulus
            'O' => 22,  // Universitas
            'P' => 18,  // Jabatan
            'Q' => 12,  // TMT Kerja
            'R' => 8,   // Masa Kerja Thn
            'S' => 8,   // Masa Kerja Bln
            'T' => 15,  // Pangkat/Golongan
            'U' => 18,  // Jabatan Fungsional
            'V' => 8,   // MK Gol Thn
            'W' => 8,   // MK Gol Bln
            'X' => 15,  // No SK
            'Y' => 15,  // JaFung SK
            'Z' => 10,  // Sertifikasi
            'AA' => 8,  // File Sertifikasi
            'AB' => 10, // Inpasing
            'AC' => 8,  // File Inpasing
            'AD' => 6,  // File KTP
            'AE' => 8,  // File Ijazah S1
            'AF' => 10, // File Transkrip S1
            'AG' => 8,  // File Ijazah S2
            'AH' => 10, // File Transkrip S2
            'AI' => 8,  // File Ijazah S3
            'AJ' => 10, // File Transkrip S3
            'AK' => 7,  // File Jafung
            'AL' => 6,  // File KK
            'AM' => 12, // File Perjanjian Kerja
            'AN' => 12, // File SK Pengangkatan
            'AO' => 12, // File Surat Pernyataan
            'AP' => 7,  // File SKTP
            'AQ' => 10, // File Surat Tugas
            'AR' => 12, // File SK Aktif
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // Style untuk header
        $sheet->getStyle('A1:AR1')->applyFromArray([
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
        $sheet->getStyle('A2:AR' . ($sheet->getHighestRow()))
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
        $fileColumns = ['Z', 'AB', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR'];
        foreach ($fileColumns as $col) {
            $sheet->getStyle($col . '2:' . $col . ($sheet->getHighestRow()))
                  ->getAlignment()
                  ->setHorizontal(Alignment::HORIZONTAL_CENTER);
        }

        // Auto filter
        $sheet->setAutoFilter('A1:AR' . ($sheet->getHighestRow()));

        // Freeze pane untuk header
        $sheet->freezePane('A2');

        return [
            1 => ['font' => ['bold' => true]]
        ];
    }
}