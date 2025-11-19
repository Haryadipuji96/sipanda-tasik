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
            $query->where(function ($q) use ($search) {
                $q->where('nama_tendik', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('jabatan_struktural', 'like', "%{$search}%") // TAMBAH INI
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
            'Posisi/Jabatan Struktural',
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
            $golonganArray = is_array($tendik->golongan_history) 
                ? $tendik->golongan_history 
                : json_decode($tendik->golongan_history, true);
            
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
            $tendik->jabatan_struktural ?? '-',
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
            'Non PNS Tetap' => 'Non PNS Tetap',
            'Non PNS Tidak Tetap' => 'Non PNS Tidak Tetap'
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
            'C' => 25,  // Posisi/Jabatan Struktural
            'D' => 12,  // Gelar Depan
            'E' => 12,  // Gelar Belakang
            'F' => 20,  // Program Studi
            'G' => 20,  // Fakultas
            'H' => 15,  // NIP
            'I' => 15,  // Status Kepegawaian
            'J' => 12,  // Jenis Kelamin
            'K' => 15,  // Tempat Lahir
            'L' => 12,  // Tanggal Lahir
            'M' => 12,  // TMT Kerja
            'N' => 20,  // Pendidikan Terakhir
            'O' => 25,  // Email
            'P' => 15,  // No HP
            'Q' => 30,  // Alamat
            'R' => 25,  // Riwayat Golongan
            'S' => 30,  // Keterangan
        ];
    }

    /**
     * Styling untuk Excel - PERBAIKAN DI SINI
     */
    public function styles(Worksheet $sheet)
    {
        // Dapatkan jumlah baris
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();

        // Style untuk header (baris 1) - PERBAIKAN RANGE MENJADI A1:S1
        $sheet->getStyle('A1:S1')->applyFromArray([
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

        // Style untuk data - PERBAIKAN RANGE MENJADI A2:S
        $sheet->getStyle('A2:S' . $highestRow)
              ->getAlignment()
              ->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP)
              ->setWrapText(true);

        // Border untuk semua data - PERBAIKAN RANGE MENJADI A1:S
        $sheet->getStyle('A1:S' . $highestRow)
              ->getBorders()
              ->getAllBorders()
              ->setBorderStyle(Border::BORDER_THIN);

        // Auto filter - PERBAIKAN RANGE MENJADI A1:S
        $sheet->setAutoFilter('A1:S' . $highestRow);

        // Set wrap text untuk kolom tertentu yang butuh
        $sheet->getStyle('R2:R' . $highestRow)
              ->getAlignment()
              ->setWrapText(true);
        $sheet->getStyle('S2:S' . $highestRow)
              ->getAlignment()
              ->setWrapText(true);

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