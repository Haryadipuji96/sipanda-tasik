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
            $query->where(function($q) use ($search) {
                $q->where('nama_tendik', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('status_kepegawaian', 'like', "%{$search}%")
                  ->orWhereHas('prodi', function($q) use ($search) {
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
            'Program Studi',
            'Fakultas',
            'NIP',
            'Status Kepegawaian',
            'Jenis Kelamin',
            'Tempat Lahir',
            'Tanggal Lahir',
            'TMT Kerja',
            'Pendidikan Terakhir',
            'Email',
            'No HP',
            'Alamat',
            'Riwayat Golongan',
            'Keterangan'
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
        if (!empty($tendik->golongan_history)) {
            $golonganArray = json_decode($tendik->golongan_history, true);
            foreach ($golonganArray as $index => $gol) {
                $riwayatGolongan .= ($index + 1) . ". " . ($gol['golongan'] ?? '-') . " (" . ($gol['tahun'] ?? '-') . ")\n";
            }
        }

        return [
            $no,
            $tendik->nama_tendik,
            $tendik->gelar_depan ?? '-',
            $tendik->gelar_belakang ?? '-',
            $tendik->prodi->nama_prodi ?? '-',
            $tendik->prodi->fakultas->nama_fakultas ?? '-',
            $tendik->nip ?? '-',
            $this->getStatusLabel($tendik->status_kepegawaian),
            $this->getJenisKelaminLabel($tendik->jenis_kelamin),
            $tendik->tempat_lahir ?? '-',
            $tendik->tanggal_lahir ? \Carbon\Carbon::parse($tendik->tanggal_lahir)->format('d-m-Y') : '-',
            $tendik->tmt_kerja ? \Carbon\Carbon::parse($tendik->tmt_kerja)->format('d-m-Y') : '-',
            $tendik->pendidikan_terakhir ?? '-',
            $tendik->email ?? '-',
            $tendik->no_hp ?? '-',
            $tendik->alamat ?? '-',
            $riwayatGolongan ?: '-',
            $tendik->keterangan ?? '-'
        ];
    }

    /**
     * Konversi status kepegawaian ke label
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'PNS' => 'PNS',
            'Honorer' => 'Honorer',
            'Kontrak' => 'Kontrak'
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
            'E' => 20,  // Program Studi
            'F' => 20,  // Fakultas
            'G' => 15,  // NIP
            'H' => 15,  // Status Kepegawaian
            'I' => 12,  // Jenis Kelamin
            'J' => 15,  // Tempat Lahir
            'K' => 12,  // Tanggal Lahir
            'L' => 12,  // TMT Kerja
            'M' => 20,  // Pendidikan Terakhir
            'N' => 25,  // Email
            'O' => 15,  // No HP
            'P' => 30,  // Alamat
            'Q' => 25,  // Riwayat Golongan
            'R' => 30,  // Keterangan
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

        // Border untuk semua data
        $sheet->getStyle('A1:R' . ($sheet->getHighestRow()))
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        // Auto filter
        $sheet->setAutoFilter('A1:R' . ($sheet->getHighestRow()));

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