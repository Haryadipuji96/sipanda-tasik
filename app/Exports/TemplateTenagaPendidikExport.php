<?php

namespace App\Exports;

use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TemplateTenagaPendidikExport implements FromArray, WithHeadings, WithTitle, WithEvents, WithColumnWidths
{
    protected $prodiList;
    protected $jabatanOptions;

    public function __construct()
    {
        $this->prodiList = Prodi::all();
        $this->jabatanOptions = TenagaPendidik::getJabatanStrukturalOptions();
    }

    public function array(): array
    {
        // Data contoh sesuai dengan form
        return [
            // Contoh data 1
            [
                'Dr.',                                 // gelar_depan
                'Ahmad Fauzi',                         // nama_tendik
                'S.Pd., M.Kom.',                       // gelar_belakang
                $this->prodiList->first() ? $this->prodiList->first()->nama_prodi : 'Teknik Informatika', // program_studi
                'Kepala Program Studi',                // jabatan_struktural
                'TETAP',                               // status_kepegawaian
                'Laki-laki',                           // jenis_kelamin
                'Tasikmalaya',                         // tempat_lahir
                '1990-05-15',                          // tanggal_lahir
                '2015-08-01',                          // tmt_kerja
                '10',                                  // masa_kerja_tahun
                '3',                                   // masa_kerja_bulan
                '8',                                   // masa_kerja_golongan_tahun
                '2',                                   // masa_kerja_golongan_bulan
                'IV/A',                                // gol
                '2025-12-31',                          // knp_yad
                '1987654321',                          // nip
                'ahmad.fauzi@email.com',               // email
                '081234567890',                        // no_hp
                'Jl. Contoh No. 123, Tasikmalaya',    // alamat
                'S2',                                  // pendidikan_terakhir
                'Tenaga pendidik aktif mengajar',      // keterangan
                '2023;IV/A|2020;III/B|2017;II/A'      // riwayat_golongan
            ],
            // Contoh data 2
            [
                'Prof.',                               // gelar_depan
                'Siti Rahayu',                         // nama_tendik
                'S.Pd., M.Pd.',                        // gelar_belakang
                $this->prodiList->count() > 1 ? $this->prodiList->get(1)->nama_prodi : 'Pendidikan Bahasa Inggris', // program_studi
                'Dosen',                               // jabatan_struktural
                'KONTRAK',                             // status_kepegawaian
                'Perempuan',                           // jenis_kelamin
                'Bandung',                             // tempat_lahir
                '1985-08-20',                          // tanggal_lahir
                '2018-03-15',                          // tmt_kerja
                '5',                                   // masa_kerja_tahun
                '8',                                   // masa_kerja_bulan
                '4',                                   // masa_kerja_golongan_tahun
                '6',                                   // masa_kerja_golongan_bulan
                'III/B',                               // gol
                '2024-06-30',                          // knp_yad
                '1987654322',                          // nip
                'siti.rahayu@email.com',               // email
                '081298765432',                        // no_hp
                'Jl. Pendidikan No. 45, Bandung',      // alamat
                'S3',                                  // pendidikan_terakhir
                'Spesialis linguistik',                // keterangan
                '2022;III/B|2019;III/A'               // riwayat_golongan
            ],
            // Contoh data 3 (dengan beberapa data kosong)
            [
                '',                                    // gelar_depan
                'Budi Santoso',                        // nama_tendik
                '',                                    // gelar_belakang
                '',                                    // program_studi
                'Tenaga Administrasi',                 // jabatan_struktural
                'KONTRAK',                             // status_kepegawaian
                'Laki-laki',                           // jenis_kelamin
                'Jakarta',                             // tempat_lahir
                '1992-11-30',                          // tanggal_lahir
                '2020-01-01',                          // tmt_kerja
                '2',                                   // masa_kerja_tahun
                '11',                                  // masa_kerja_bulan
                '1',                                   // masa_kerja_golongan_tahun
                '6',                                   // masa_kerja_golongan_bulan
                'III/A',                               // gol
                '2023-12-31',                          // knp_yad
                '',                                    // nip
                '',                                    // email
                '',                                    // no_hp
                '',                                    // alamat
                'S1',                                  // pendidikan_terakhir
                '',                                    // keterangan
                '2020;III/A'                          // riwayat_golongan
            ],
        ];
    }

    public function headings(): array
    {
        return [
            'gelar_depan',
            'nama_tendik',
            'gelar_belakang',
            'program_studi',
            'jabatan_struktural',
            'status_kepegawaian',
            'jenis_kelamin',
            'tempat_lahir',
            'tanggal_lahir',
            'tmt_kerja',
            'masa_kerja_tahun',
            'masa_kerja_bulan',
            'masa_kerja_golongan_tahun',
            'masa_kerja_golongan_bulan',
            'gol',
            'knp_yad',
            'nip',
            'email',
            'no_hp',
            'alamat',
            'pendidikan_terakhir',
            'keterangan',
            'riwayat_golongan'
        ];
    }

    public function title(): string
    {
        return 'Template Tenaga Pendidik';
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,  // gelar_depan
            'B' => 25,  // nama_tendik
            'C' => 20,  // gelar_belakang
            'D' => 30,  // program_studi
            'E' => 25,  // jabatan_struktural
            'F' => 18,  // status_kepegawaian
            'G' => 15,  // jenis_kelamin
            'H' => 20,  // tempat_lahir
            'I' => 15,  // tanggal_lahir
            'J' => 15,  // tmt_kerja
            'K' => 15,  // masa_kerja_tahun
            'L' => 15,  // masa_kerja_bulan
            'M' => 20,  // masa_kerja_golongan_tahun
            'N' => 20,  // masa_kerja_golongan_bulan
            'O' => 12,  // gol
            'P' => 15,  // knp_yad
            'Q' => 20,  // nip
            'R' => 30,  // email
            'S' => 15,  // no_hp
            'T' => 35,  // alamat
            'U' => 20,  // pendidikan_terakhir
            'V' => 30,  // keterangan
            'W' => 25,  // riwayat_golongan
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();
                $lastRow = 100;

                // ========== DROPDOWN PROGRAM STUDI ==========
                $prodiOptions = $this->prodiList->pluck('nama_prodi')->toArray();
                if (!empty($prodiOptions)) {
                    $prodiFormula = implode(',', array_map('trim', $prodiOptions));
                    
                    $validation = $sheet->getDataValidation("D2:D{$lastRow}");
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1($prodiFormula);
                }

                // ========== DROPDOWN JABATAN ==========
                $jabatanOptions = $this->jabatanOptions;
                if (!empty($jabatanOptions)) {
                    $jabatanFormula = implode(',', array_map('trim', $jabatanOptions));
                    
                    $validation = $sheet->getDataValidation("E2:E{$lastRow}");
                    $validation->setType(DataValidation::TYPE_LIST);
                    $validation->setErrorStyle(DataValidation::STYLE_STOP);
                    $validation->setAllowBlank(true);
                    $validation->setShowInputMessage(true);
                    $validation->setShowErrorMessage(true);
                    $validation->setShowDropDown(true);
                    $validation->setFormula1($jabatanFormula);
                }

                // ========== DROPDOWN STATUS KEPEGAWAIAN ==========
                $statusOptions = ['KONTRAK', 'TETAP'];
                $statusFormula = implode(',', $statusOptions);
                
                $validation = $sheet->getDataValidation("F2:F{$lastRow}");
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1($statusFormula);

                // ========== DROPDOWN JENIS KELAMIN ==========
                $genderOptions = ['Laki-laki', 'Perempuan'];
                $genderFormula = implode(',', $genderOptions);
                
                $validation = $sheet->getDataValidation("G2:G{$lastRow}");
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1($genderFormula);

                // ========== DROPDOWN PENDIDIKAN TERAKHIR ==========
                $pendidikanOptions = [
                    'SMA/Sederajat', 'D1', 'D2', 'D3', 'D4', 
                    'S1', 'S2', 'S3', 'Profesi', 'Spesialis'
                ];
                $pendidikanFormula = implode(',', $pendidikanOptions);
                
                $validation = $sheet->getDataValidation("U2:U{$lastRow}");
                $validation->setType(DataValidation::TYPE_LIST);
                $validation->setErrorStyle(DataValidation::STYLE_STOP);
                $validation->setAllowBlank(true);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setFormula1($pendidikanFormula);

                // ========== FORMAT DATE COLUMNS ==========
                $dateColumns = ['I', 'J', 'P']; // tanggal_lahir, tmt_kerja, knp_yad
                foreach ($dateColumns as $col) {
                    $sheet->getStyle("{$col}2:{$col}{$lastRow}")
                        ->getNumberFormat()
                        ->setFormatCode('yyyy-mm-dd');
                }

                // ========== SET NUMBER FORMAT FOR NUMERIC COLUMNS ==========
                $numericColumns = ['K', 'L', 'M', 'N']; // masa kerja columns
                foreach ($numericColumns as $col) {
                    $sheet->getStyle("{$col}2:{$col}{$lastRow}")
                        ->getNumberFormat()
                        ->setFormatCode('0');
                }

                // ========== STYLING HEADER ==========
                $sheet->getStyle('A1:W1')->applyFromArray([
                    'font' => [
                        'bold' => true,
                        'color' => ['rgb' => 'FFFFFF'],
                        'size' => 11
                    ],
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => '3B82F6']
                    ],
                    'alignment' => [
                        'wrapText' => true,
                        'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => '1E40AF']
                        ]
                    ]
                ]);

                // ========== STYLING EXAMPLE ROWS ==========
                $sheet->getStyle('A2:W4')->applyFromArray([
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => 'F0F9FF']
                    ],
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['rgb' => 'DBEAFE']
                        ]
                    ]
                ]);

                // ========== AUTO FILTER ==========
                $sheet->setAutoFilter('A1:W1');

                // ========== SET ROW HEIGHTS ==========
                $sheet->getRowDimension(1)->setRowHeight(25);
                for ($i = 2; $i <= 4; $i++) {
                    $sheet->getRowDimension($i)->setRowHeight(20);
                }
                
                // ========== FREEZE PANE ==========
                $sheet->freezePane('A2');

                // ========== HAPUS INSTRUCTION YANG DI KOLOM Y (OPTIONAL) ==========
                // Untuk mengurangi kompleksitas, hapus dulu instruksi di kolom Y
                // $this->addInstructions($sheet); // COMMENT DULU
            },
        ];
    }

    // Method ini bisa di-uncomment setelah template dasar berhasil
    private function addInstructions($sheet)
    {
        // Untuk sekarang, skip dulu untuk menghindari kompleksitas
        return;
    }
}