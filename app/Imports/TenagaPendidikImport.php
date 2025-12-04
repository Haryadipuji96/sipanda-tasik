<?php

namespace App\Imports;

use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Illuminate\Support\Facades\Log;

class TenagaPendidikImport implements ToModel, WithHeadingRow, WithValidation, SkipsEmptyRows, SkipsOnError
{
    use SkipsErrors;

    protected $prodiCache = [];
    protected $importedCount = 0;
    protected $errors = [];

    public function model(array $row)
    {
        try {
            // Skip jika row kosong atau tidak ada nama_tendik
            if ($this->isEmptyRow($row)) {
                Log::debug('Skipping empty row', ['row' => $row]);
                return null;
            }

            // Validasi dasar untuk required fields
            if (empty($row['nama_tendik']) || empty($row['status_kepegawaian']) || empty($row['jenis_kelamin'])) {
                Log::warning('Missing required fields', ['row' => $row]);
                return null;
            }

            Log::debug('Processing row', ['row' => $row]);

            // Konversi jenis kelamin
            $jenisKelamin = $this->convertJenisKelamin($row['jenis_kelamin'] ?? '');

            // Cari ID prodi
            $prodiId = $this->findProdiId($row['program_studi'] ?? null);

            // Handle riwayat golongan
            $golonganHistory = $this->parseRiwayatGolongan($row['riwayat_golongan'] ?? '');

            // PERBAIKAN: Konversi NIP dan No HP ke string
            $nip = $this->convertToString($row['nip'] ?? null);
            $noHp = $this->convertToString($row['no_hp'] ?? null);

            $tenagaPendidik = new TenagaPendidik([
                'gelar_depan' => $row['gelar_depan'] ?? null,
                'nama_tendik' => trim($row['nama_tendik']),
                'gelar_belakang' => $row['gelar_belakang'] ?? null,
                'id_prodi' => $prodiId,
                'jabatan_struktural' => $row['jabatan_struktural'] ?? null,
                'status_kepegawaian' => strtoupper(trim($row['status_kepegawaian'])),
                'jenis_kelamin' => $jenisKelamin,
                'tempat_lahir' => $row['tempat_lahir'] ?? null,
                'tanggal_lahir' => $this->parseDate($row['tanggal_lahir'] ?? null),
                'tmt_kerja' => $this->parseDate($row['tmt_kerja'] ?? null),
                'masa_kerja_tahun' => $this->cleanNumber($row['masa_kerja_tahun'] ?? 0),
                'masa_kerja_bulan' => $this->cleanNumber($row['masa_kerja_bulan'] ?? 0),
                'masa_kerja_golongan_tahun' => $this->cleanNumber($row['masa_kerja_golongan_tahun'] ?? 0),
                'masa_kerja_golongan_bulan' => $this->cleanNumber($row['masa_kerja_golongan_bulan'] ?? 0),
                'gol' => $row['gol'] ?? null,
                'knp_yad' => $this->parseDate($row['knp_yad'] ?? null),
                'nip' => $nip, // PERBAIKAN: Gunakan yang sudah dikonversi
                'email' => $row['email'] ?? null,
                'no_hp' => $noHp, // PERBAIKAN: Gunakan yang sudah dikonversi
                'alamat' => $row['alamat'] ?? null,
                'pendidikan_terakhir' => $row['pendidikan_terakhir'] ?? null,
                'keterangan' => $row['keterangan'] ?? null,
                'golongan_history' => $golonganHistory,
            ]);

            $this->importedCount++;

            Log::info('Data imported successfully', [
                'name' => $row['nama_tendik'],
                'count' => $this->importedCount
            ]);

            return $tenagaPendidik;
        } catch (\Exception $e) {
            Log::error('Error importing row', [
                'row' => $row,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $this->errors[] = [
                'row' => $this->importedCount + 1,
                'message' => $e->getMessage(),
                'data' => [
                    'nama' => $row['nama_tendik'] ?? 'Unknown',
                    'status' => $row['status_kepegawaian'] ?? 'Unknown'
                ]
            ];

            return null;
        }
    }

    public function rules(): array
    {
        return [
            'nama_tendik' => 'required|string|max:255',
            'status_kepegawaian' => 'required|in:KONTRAK,TETAP',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'program_studi' => 'nullable|exists:prodi,nama_prodi',
            'tanggal_lahir' => 'nullable|date_format:Y-m-d',
            'tmt_kerja' => 'nullable|date_format:Y-m-d',
            'knp_yad' => 'nullable|date_format:Y-m-d',
            'masa_kerja_tahun' => 'nullable|integer|min:0|max:100',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0|max:100',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'gol' => 'nullable|string|max:20',
            'pendidikan_terakhir' => 'nullable|in:SMA/Sederajat,D1,D2,D3,D4,S1,S2,S3,Profesi,Spesialis',

            // PERBAIKAN: Custom validation untuk handle number/string
            'nip' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Terima semua nilai, akan dikonversi di model
                    if ($value === null || $value === '') {
                        return;
                    }
                    
                    // Cek jika terlalu panjang
                    if (is_string($value) && strlen($value) > 50) {
                        $fail('NIP maksimal 50 karakter.');
                    }
                    
                    if (is_numeric($value) && strlen((string)$value) > 50) {
                        $fail('NIP maksimal 50 karakter.');
                    }
                },
                'unique:tenaga_pendidik,nip'
            ],

            'email' => 'nullable|email|max:255|unique:tenaga_pendidik,email',

            'no_hp' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    // Terima semua nilai, akan dikonversi di model
                    if ($value === null || $value === '') {
                        return;
                    }
                    
                    // Cek jika terlalu panjang
                    if (is_string($value) && strlen($value) > 20) {
                        $fail('No HP maksimal 20 karakter.');
                    }
                    
                    if (is_numeric($value) && strlen((string)$value) > 20) {
                        $fail('No HP maksimal 20 karakter.');
                    }
                },
                'unique:tenaga_pendidik,no_hp'
            ],
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'nama_tendik.required' => 'Kolom nama tenaga pendidik harus diisi',
            'status_kepegawaian.required' => 'Kolom status kepegawaian harus diisi',
            'status_kepegawaian.in' => 'Status kepegawaian harus KONTRAK atau TETAP',
            'jenis_kelamin.required' => 'Kolom jenis kelamin harus diisi',
            'jenis_kelamin.in' => 'Jenis kelamin harus Laki-laki atau Perempuan',
            'program_studi.exists' => 'Program studi tidak ditemukan dalam sistem',
            'tanggal_lahir.date_format' => 'Format tanggal lahir harus YYYY-MM-DD',
            'tmt_kerja.date_format' => 'Format TMT kerja harus YYYY-MM-DD',
            'knp_yad.date_format' => 'Format KNP YAD harus YYYY-MM-DD',
            'masa_kerja_bulan.max' => 'Masa kerja bulan maksimal 11',
            'masa_kerja_golongan_bulan.max' => 'Masa kerja golongan bulan maksimal 11',
            'nip.unique' => 'NIP sudah terdaftar',
            'email.unique' => 'Email sudah terdaftar',
            'email.email' => 'Format email tidak valid',
            'no_hp.unique' => 'No HP sudah terdaftar',
            'pendidikan_terakhir.in' => 'Pendidikan terakhir tidak valid',
        ];
    }

    // PERBAIKAN: Tambahkan method convertToString
    private function convertToString($value)
    {
        if ($value === null || $value === '' || $value === '-') {
            return null;
        }
        
        // Jika sudah string, kembalikan setelah trim
        if (is_string($value)) {
            return trim($value);
        }
        
        // Jika numeric, convert ke string
        if (is_numeric($value)) {
            // Untuk angka besar, hindari scientific notation
            if (is_float($value) && $value > 999999999) {
                return number_format($value, 0, '.', '');
            }
            return (string) $value;
        }
        
        // Untuk tipe data lainnya, convert ke string
        return (string) $value;
    }

    private function isEmptyRow($row)
    {
        // Skip jika semua kolom kosong
        $allEmpty = true;
        foreach ($row as $value) {
            if (!empty($value) && trim($value) !== '') {
                $allEmpty = false;
                break;
            }
        }

        if ($allEmpty) {
            return true;
        }

        // Cek required fields
        $requiredFields = ['nama_tendik', 'status_kepegawaian', 'jenis_kelamin'];

        foreach ($requiredFields as $field) {
            if (!isset($row[$field]) || empty(trim($row[$field]))) {
                return true;
            }
        }

        return false;
    }

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
                Log::warning('Prodi not found', ['prodi_name' => $cleanName]);
                // Return null jika prodi tidak ditemukan, import tetap lanjut
            }

            $this->prodiCache[$cleanName] = $prodi ? $prodi->id : null;
        }

        return $this->prodiCache[$cleanName];
    }

    private function convertJenisKelamin($value)
    {
        $value = strtolower(trim($value));

        if ($value === 'laki-laki' || $value === 'laki laki' || $value === 'l') {
            return 'laki-laki';
        } elseif ($value === 'perempuan' || $value === 'p') {
            return 'perempuan';
        }

        return $value;
    }

    private function parseDate($date)
    {
        if (empty($date) || $date === '' || $date === '-' || strtolower($date) === 'null') {
            return null;
        }

        // Coba parse dari berbagai format
        try {
            // Jika sudah format Y-m-d
            if (preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) {
                return \Carbon\Carbon::createFromFormat('Y-m-d', $date);
            }

            // Coba parse dengan Carbon
            return \Carbon\Carbon::parse($date);
        } catch (\Exception $e) {
            Log::warning('Date parsing error', ['date' => $date, 'error' => $e->getMessage()]);
            return null;
        }
    }

    private function cleanNumber($value)
    {
        if (empty($value) || $value === '' || $value === '-' || strtolower($value) === 'null') {
            return 0;
        }

        // Hapus karakter non-numeric
        $cleanValue = preg_replace('/[^0-9]/', '', $value);

        if (is_numeric($cleanValue)) {
            $intValue = (int) $cleanValue;
            return max(0, min($intValue, 100)); // Batasi 0-100
        }

        return 0;
    }

    private function parseRiwayatGolongan($value)
    {
        if (empty($value) || $value === '' || $value === '-' || strtolower($value) === 'null') {
            return null;
        }

        $golonganArray = [];
        $items = explode('|', $value);

        foreach ($items as $item) {
            $parts = explode(';', $item);
            if (count($parts) === 2) {
                $tahun = trim($parts[0]);
                $golongan = trim($parts[1]);

                // Validasi tahun 4 digit
                if (preg_match('/^\d{4}$/', $tahun) && !empty($golongan)) {
                    $golonganArray[] = [
                        'tahun' => $tahun,
                        'golongan' => $golongan
                    ];
                }
            }
        }

        return !empty($golonganArray) ? json_encode($golonganArray) : null;
    }

    public function getImportedCount()
    {
        return $this->importedCount;
    }

    public function getErrors()
    {
        // Pastikan semua error dalam format yang benar
        $cleanedErrors = [];
        
        foreach ($this->errors as $error) {
            if (is_array($error)) {
                // Jika message adalah array, convert ke string
                if (isset($error['message']) && is_array($error['message'])) {
                    $error['message'] = implode(', ', $error['message']);
                }
                $cleanedErrors[] = $error;
            } else {
                $cleanedErrors[] = ['message' => (string) $error];
            }
        }
        
        return $cleanedErrors;
    }

    public function onError(\Throwable $e)
    {
        Log::error('Import error in onError', [
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ]);

        $this->errors[] = [
            'row' => 'unknown',
            'message' => $e->getMessage(),
            'data' => []
        ];
    }
}