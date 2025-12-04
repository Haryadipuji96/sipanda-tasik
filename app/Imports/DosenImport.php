<?php

namespace App\Imports;

use App\Models\Dosen;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class DosenImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError, SkipsOnFailure
{
    use Importable, SkipsErrors;
    
    protected $prodiCache = [];
    protected $importedCount = 0;
    protected $skippedCount = 0;
    protected $errors = [];
    protected $rows = [];

    /**
     * Clean column names
     */
    private function cleanColumnNames(array $row): array
    {
        $cleaned = [];
        foreach ($row as $key => $value) {
            $cleanKey = trim(str_replace('*', '', $key));
            $cleanKey = strtolower(str_replace(' ', '_', $cleanKey));
            $cleaned[$cleanKey] = $value;
        }
        return $cleaned;
    }

    /**
     * Convert value to string
     */
    private function convertToString($value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }
        
        if (is_numeric($value)) {
            if (is_float($value) && $value > 999999999) {
                return number_format($value, 0, '.', '');
            }
            return (string) $value;
        }
        
        if (is_string($value)) {
            return trim($value);
        }
        
        return (string) $value;
    }

    /**
     * @param array $row
     */
    public function model(array $row)
    {
        try {
            // Clean column names
            $row = $this->cleanColumnNames($row);
            
            $currentRow = $this->importedCount + $this->skippedCount + 2;
            Log::info('Processing row:', ['row' => $currentRow, 'data' => $row]);
            
            // Konversi NIK dan NUPTK ke string
            if (isset($row['nik'])) {
                $row['nik'] = $this->convertToString($row['nik']);
            }
            
            if (isset($row['nuptk'])) {
                $row['nuptk'] = $this->convertToString($row['nuptk']);
            }
            
            // Validasi required fields
            $missingFields = [];
            $requiredFields = ['nama', 'program_studi', 'status_dosen', 'sertifikasi', 'inpasing'];
            
            foreach ($requiredFields as $field) {
                if (empty($row[$field] ?? null)) {
                    $missingFields[] = $field;
                }
            }
            
            if (!empty($missingFields)) {
                $this->errors[] = [
                    'row' => $currentRow,
                    'message' => 'Field wajib harus diisi: ' . implode(', ', $missingFields),
                    'data' => $row
                ];
                $this->skippedCount++;
                return null;
            }

            // Cari ID prodi
            $prodiName = $row['program_studi'] ?? '';
            $prodiId = $this->findProdiId($prodiName);
            
            if (!$prodiId) {
                $this->errors[] = [
                    'row' => $currentRow,
                    'message' => 'Program Studi tidak ditemukan: ' . $prodiName,
                    'data' => $row
                ];
                $this->skippedCount++;
                return null;
            }

            // Parse riwayat pendidikan
            $pendidikanData = $this->parseRiwayatPendidikan($row['riwayat_pendidikan'] ?? '');

            // Hapus field yang tidak ada di database
            // Kolom email, no_hp, dan alamat tidak ada di database, jadi tidak disimpan
            
            // Check duplicates hanya untuk NIK dan NUPTK
            $nik = $row['nik'] ?? null;
            $nuptk = $row['nuptk'] ?? null;
            
            if ($nik && Dosen::where('nik', $nik)->exists()) {
                $this->errors[] = [
                    'row' => $currentRow,
                    'message' => 'NIK sudah terdaftar: ' . $nik,
                    'data' => $row
                ];
                $this->skippedCount++;
                return null;
            }

            if ($nuptk && Dosen::where('nuptk', $nuptk)->exists()) {
                $this->errors[] = [
                    'row' => $currentRow,
                    'message' => 'NUPTK sudah terdaftar: ' . $nuptk,
                    'data' => $row
                ];
                $this->skippedCount++;
                return null;
            }

            // Prepare data sesuai struktur database
            $dosenData = [
                'id_prodi' => $prodiId,
                'gelar_depan' => $row['gelar_depan'] ?? null,
                'nama' => trim($row['nama']),
                'gelar_belakang' => $row['gelar_belakang'] ?? null,
                'tempat_lahir' => $row['tempat_lahir'] ?? null,
                'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
                'nik' => $nik,
                'nuptk' => $nuptk,
                'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
                'pendidikan_data' => $pendidikanData,
                'jabatan' => $row['jabatan'] ?? null,
                'tmt_kerja' => $this->parseDate($row['tmt_kerja'] ?? null),
                'masa_kerja_tahun' => $this->cleanNumber($row['masa_kerja_tahun'] ?? 0),
                'masa_kerja_bulan' => $this->cleanNumber($row['masa_kerja_bulan'] ?? 0),
                'pangkat_golongan' => $row['pangkat_golongan'] ?? null,
                'jabatan_fungsional' => $row['jabatan_fungsional'] ?? null,
                'golongan' => $row['golongan'] ?? null,
                'masa_kerja_golongan_tahun' => $this->cleanNumber($row['masa_kerja_golongan_tahun'] ?? 0),
                'masa_kerja_golongan_bulan' => $this->cleanNumber($row['masa_kerja_golongan_bulan'] ?? 0),
                'no_sk' => $row['no_sk'] ?? null,
                'no_sk_jafung' => $row['no_sk_jafung'] ?? null,
                'sertifikasi' => strtoupper(trim($row['sertifikasi'])),
                'inpasing' => strtoupper(trim($row['inpasing'])),
                'status_dosen' => strtoupper(trim($row['status_dosen'])),
                // Tidak termasuk email, no_hp, alamat karena tidak ada di database
            ];

            // Create and save Dosen
            $dosen = new Dosen($dosenData);
            
            try {
                $dosen->save();
                $this->importedCount++;
                
                Log::info('Dosen saved successfully', [
                    'id' => $dosen->id,
                    'name' => $dosen->nama
                ]);
                
                return $dosen;
                
            } catch (\Exception $e) {
                Log::error('Database save error:', [
                    'error' => $e->getMessage(),
                    'data' => $dosenData
                ]);
                
                $this->errors[] = [
                    'row' => $currentRow,
                    'message' => 'Database error: ' . $e->getMessage(),
                    'data' => $row
                ];
                $this->skippedCount++;
                return null;
            }

        } catch (\Exception $e) {
            Log::error('Import error:', [
                'error' => $e->getMessage(),
                'row' => $row
            ]);
            
            $this->errors[] = [
                'row' => $this->importedCount + $this->skippedCount + 2,
                'message' => 'Exception: ' . $e->getMessage(),
                'data' => $row
            ];
            $this->skippedCount++;
            return null;
        }
    }

    /**
     * Validation rules
     */
    public function rules(): array
    {
        return [
            'nama' => 'required|string|max:255',
            'program_studi' => 'required|exists:prodi,nama_prodi',
            'status_dosen' => 'required|in:DOSEN_TETAP,DOSEN_TIDAK_TETAP,PNS',
            'sertifikasi' => 'required|in:SUDAH,BELUM',
            'inpasing' => 'required|in:SUDAH,BELUM',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'tmt_kerja' => 'nullable|date_format:Y-m-d',
            'pendidikan_terakhir' => 'nullable|in:SMA/Sederajat,D1,D2,D3,D4,S1,S2,S3,Profesi,Spesialis',
            'masa_kerja_tahun' => 'nullable|integer|min:0|max:100',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0|max:100',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'nik' => 'nullable|string|max:20',
            'nuptk' => 'nullable|string|max:50',
            // Tidak ada validasi untuk email dan no_hp karena kolom tidak ada
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages(): array
    {
        return [
            'nama.required' => 'Kolom nama harus diisi',
            'program_studi.required' => 'Kolom program studi harus diisi',
            'program_studi.exists' => 'Program studi tidak ditemukan dalam sistem',
            'status_dosen.required' => 'Kolom status dosen harus diisi',
            'status_dosen.in' => 'Status dosen harus DOSEN_TETAP, DOSEN_TIDAK_TETAP, atau PNS',
            'sertifikasi.required' => 'Kolom sertifikasi harus diisi',
            'sertifikasi.in' => 'Sertifikasi harus SUDAH atau BELUM',
            'inpasing.required' => 'Kolom inpasing harus diisi',
            'inpasing.in' => 'Inpasing harus SUDAH atau BELUM',
            'tanggal_lahir.date_format' => 'Format tanggal lahir harus YYYY-MM-DD',
            'tmt_kerja.date_format' => 'Format TMT kerja harus YYYY-MM-DD',
            'nik.string' => 'NIK harus berupa teks',
            'nuptk.string' => 'NUPTK harus berupa teks',
        ];
    }

    /**
     * Find prodi ID by name
     */
    private function findProdiId($prodiName)
    {
        if (empty($prodiName)) {
            return null;
        }

        $cleanName = trim($prodiName);
        
        if ($cleanName === '' || $cleanName === '-') {
            return null;
        }

        if (!isset($this->prodiCache[$cleanName])) {
            $prodi = Prodi::where('nama_prodi', $cleanName)->first();
            
            if (!$prodi) {
                $prodi = Prodi::whereRaw('LOWER(nama_prodi) = ?', [strtolower($cleanName)])->first();
            }
            
            $this->prodiCache[$cleanName] = $prodi ? $prodi->id : null;
        }

        return $this->prodiCache[$cleanName];
    }

    /**
     * Parse date
     */
    private function parseDate($date)
    {
        if (empty($date) || $date === '' || $date === '-' || strtolower($date) === 'null') {
            return null;
        }

        try {
            if (is_numeric($date) && $date > 25569) {
                $unixTimestamp = ($date - 25569) * 86400;
                return \Carbon\Carbon::createFromTimestamp($unixTimestamp);
            }

            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return \Carbon\Carbon::createFromFormat('Y-m-d', $date);
            }
            
            return \Carbon\Carbon::parse($date);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Clean number
     */
    private function cleanNumber($value)
    {
        if (empty($value) || $value === '' || $value === '-' || strtolower($value) === 'null') {
            return 0;
        }

        if (is_numeric($value)) {
            $intValue = (int) $value;
            return max(0, min($intValue, 100));
        }

        return 0;
    }

    /**
     * Parse pendidikan history
     */
    private function parseRiwayatPendidikan($value)
    {
        if (empty($value) || $value === '' || $value === '-' || strtolower($value) === 'null') {
            return null;
        }

        $pendidikanArray = [];
        $items = explode('|', $value);
        
        foreach ($items as $item) {
            $parts = explode(';', $item);
            if (count($parts) === 2) {
                $tahun = trim($parts[0]);
                $jenjang = trim($parts[1]);
                
                if (preg_match('/^\d{4}$/', $tahun) && !empty($jenjang)) {
                    $pendidikanArray[] = [
                        'jenjang' => $jenjang,
                        'tahun_lulus' => $tahun
                    ];
                }
            }
        }

        return !empty($pendidikanArray) ? json_encode($pendidikanArray) : null;
    }

    /**
     * Get import statistics
     */
    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getSkippedCount()
    {
        return $this->skippedCount;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    /**
     * Handle validation failures
     */
    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $values = $failure->values();
            
            // Convert NIK, NUPTK to string
            if (isset($values['nik'])) {
                $values['nik'] = $this->convertToString($values['nik']);
            }
            if (isset($values['nuptk'])) {
                $values['nuptk'] = $this->convertToString($values['nuptk']);
            }
            
            $this->errors[] = [
                'row' => $failure->row(),
                'message' => implode(', ', $failure->errors()),
                'data' => $values
            ];
            $this->skippedCount++;
        }
    }

    /**
     * Handle general errors
     */
    public function onError(\Throwable $e)
    {
        Log::error('Import error:', ['error' => $e->getMessage()]);
        
        $this->errors[] = [
            'row' => 'unknown',
            'message' => $e->getMessage(),
            'data' => []
        ];
        $this->skippedCount++;
    }
}