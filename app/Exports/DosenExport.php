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
            'Nama',
            'Program Studi',
            'Fakultas',
            'Tempat/Tgl Lahir',
            'NIDN',
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
            'Inpasing',
        ];
    }

    public function map($dosen): array
    {
        static $no = 0;
        $rows = [];
        $pendidikan = $dosen->pendidikan_array ?? [];
        
        // Jika tidak ada pendidikan, buat 1 baris kosong
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
                $dosen->prodi->nama_prodi ?? '-',
                $dosen->prodi->fakultas->nama_fakultas ?? '-',
                $dosen->tempat_tanggal_lahir ?? '-',
                $dosen->nik ?? '-',
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
                $dosen->inpasing ?? '-',
            ];
        } else {
            // Baris tambahan untuk pendidikan, data dosen dikosongkan
            return [
                '', // No
                '', // Nama
                '', // Prodi
                '', // Fakultas
                '', // Tempat/Tgl Lahir
                '', // NIDN
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
                '', // Inpasing
            ];
        }
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,   // No
            'B' => 30,  // Nama
            'C' => 25,  // Prodi
            'D' => 25,  // Fakultas
            'E' => 20,  // Tempat/Tgl Lahir
            'F' => 15,  // NIDN
            'G' => 15,  // Jenjang
            'H' => 25,  // Prodi/Jurusan
            'I' => 12,  // Tahun Lulus
            'J' => 25,  // Universitas
            'K' => 25,  // Jabatan
            'L' => 15,  // TMT Kerja
            'M' => 12,  // Masa Kerja Thn
            'N' => 12,  // Masa Kerja Bln
            'O' => 18,  // Pangkat
            'P' => 20,  // JaFung
            'Q' => 12,  // MK Gol Thn
            'R' => 12,  // MK Gol Bln
            'S' => 20,  // No SK
            'T' => 20,  // JaFung SK
            'U' => 12,  // Sertifikasi
            'V' => 12,  // Inpasing
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:V1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 11, 'color' => ['rgb' => 'FFFFFF']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '3B82F6']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center', 'wrapText' => true],
            'borders' => ['allBorders' => ['borderStyle' => Border::BORDER_THIN]],
        ]);

        $sheet->getStyle('A2:V' . ($sheet->getHighestRow()))
              ->getAlignment()
              ->setVertical('top')
              ->setWrapText(true);

        $sheet->setAutoFilter('A1:V' . ($sheet->getHighestRow()));

        return [1 => ['font' => ['bold' => true]]];
    }
}