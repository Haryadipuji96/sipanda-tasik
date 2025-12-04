<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;
use App\Exports\TemplateDosenExport;
use App\Imports\DosenImport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Dosen::with('prodi.fakultas');

        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('gelar_depan', 'like', "%{$search}%")
                    ->orWhere('gelar_belakang', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        $dosen = $query->paginate(15);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.dosen.index', compact('dosen', 'prodi'));
    }

    public function edit($id)
    {
        if (!Auth::user()->canCrud('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = Dosen::with('prodi.fakultas')->findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.dosen.edit', compact('dosen', 'prodi'));
    }

    public function create()
    {
        if (!Auth::user()->canCrud('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $prodi = Prodi::with('fakultas')->get();
        return view('page.dosen.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canCrud('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'gelar_depan' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'gelar_belakang' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nik' => 'nullable|string|max:20|unique:dosen,nik',
            'nuptk' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'tmt_kerja' => 'nullable|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'pangkat_golongan' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'no_sk' => 'nullable|string|max:100',
            'no_sk_jafung' => 'nullable|string|max:100',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'sertifikasi' => 'required|in:SUDAH,BELUM',
            'inpasing' => 'required|in:SUDAH,BELUM',
            'status_dosen' => 'required|in:DOSEN_TETAP,DOSEN_TIDAK_TETAP,PNS',
            // Validasi file upload
            'file_sertifikasi' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_inpasing' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_jafung' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_perjanjian_kerja' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_pengangkatan' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_pernyataan' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_aktif' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except([
            'pendidikan',
            'file_sertifikasi',
            'file_inpasing',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_jafung',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk_pengangkatan',
            'file_surat_pernyataan',
            'file_sktp',
            'file_surat_tugas',
            'file_sk_aktif',
            'file_dokumen'
        ]);

        // Handle pendidikan dinamis
        if ($request->has('pendidikan')) {
            $pendidikanArray = array_filter($request->pendidikan, function ($item) {
                return !empty($item['jenjang']) || !empty($item['prodi']) || !empty($item['tahun_lulus']) || !empty($item['universitas']);
            });
            $data['pendidikan_data'] = json_encode(array_values($pendidikanArray));
        }

        // Handle file uploads
        $fileFields = [
            'file_sertifikasi',
            'file_inpasing',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_jafung',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk_pengangkatan',
            'file_surat_pernyataan',
            'file_sktp',
            'file_surat_tugas',
            'file_sk_aktif',
            'file_dokumen'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = now()->format('YmdHis') . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('dokumen_dosen'), $filename);
                $data[$field] = $filename;
            }
        }

        Dosen::create($data);
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show($id)
    {
        if (!Auth::user()->hasPermission('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = Dosen::with('prodi.fakultas')->findOrFail($id);
        return view('page.dosen.show', compact('dosen'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->canCrud('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'gelar_depan' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'gelar_belakang' => 'nullable|string|max:100',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nik' => 'nullable|string|max:20|unique:dosen,nik,' . $dosen->id . ',id',
            'nuptk' => 'nullable|string|max:50',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'tmt_kerja' => 'nullable|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'pangkat_golongan' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'no_sk' => 'nullable|string|max:100',
            'no_sk_jafung' => 'nullable|string|max:100',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'sertifikasi' => 'required|in:SUDAH,BELUM',
            'inpasing' => 'required|in:SUDAH,BELUM',
            'status_dosen' => 'required|in:DOSEN_TETAP,DOSEN_TIDAK_TETAP,PNS',
            // Validasi file upload
            'file_sertifikasi' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_inpasing' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_jafung' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_perjanjian_kerja' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_pengangkatan' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_pernyataan' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sk_aktif' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except([
            'pendidikan',
            'file_sertifikasi',
            'file_inpasing',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_jafung',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk_pengangkatan',
            'file_surat_pernyataan',
            'file_sktp',
            'file_surat_tugas',
            'file_sk_aktif',
            'file_dokumen'
        ]);

        // Handle pendidikan dinamis
        if ($request->has('pendidikan')) {
            $pendidikanArray = array_filter($request->pendidikan, function ($item) {
                return !empty($item['jenjang']) || !empty($item['prodi']) || !empty($item['tahun_lulus']) || !empty($item['universitas']);
            });
            $data['pendidikan_data'] = json_encode(array_values($pendidikanArray));
        }

        // Handle file uploads
        $fileFields = [
            'file_sertifikasi',
            'file_inpasing',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_jafung',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk_pengangkatan',
            'file_surat_pernyataan',
            'file_sktp',
            'file_surat_tugas',
            'file_sk_aktif',
            'file_dokumen'
        ];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                $oldFile = $dosen->$field;
                if ($oldFile && file_exists(public_path('dokumen_dosen/' . $oldFile))) {
                    unlink(public_path('dokumen_dosen/' . $oldFile));
                }

                $file = $request->file($field);
                $filename = now()->format('YmdHis') . '_' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('dokumen_dosen'), $filename);
                $data[$field] = $filename;
            }
        }

        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!Auth::user()->canCrud('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        $dosen = Dosen::findOrFail($id);

        // Hapus semua file yang terkait
        $fileFields = [
            'file_sertifikasi',
            'file_inpasing',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_jafung',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk_pengangkatan',
            'file_surat_pernyataan',
            'file_sktp',
            'file_surat_tugas',
            'file_sk_aktif',
            'file_dokumen'
        ];

        foreach ($fileFields as $field) {
            $oldFile = public_path('dokumen_dosen/' . $dosen->$field);
            if ($dosen->$field && file_exists($oldFile)) {
                unlink($oldFile);
            }
        }

        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        if (!Auth::user()->canCrud('dosen')) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized action.'
            ], 403);
        }

        try {
            $ids = $request->input('selected_dosen', []);

            \Log::info('Delete selected attempt', ['ids' => $ids, 'user_id' => Auth::id()]);

            if (empty($ids)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak ada data yang dipilih untuk dihapus.'
                ], 400);
            }

            // Validasi IDs
            $validIds = array_filter($ids, function ($id) {
                return is_numeric($id) && $id > 0;
            });

            if (empty($validIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ID data tidak valid.'
                ], 400);
            }

            $dosens = Dosen::whereIn('id', $validIds)->get();

            if ($dosens->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Data tidak ditemukan.'
                ], 404);
            }

            $fileFields = [
                'file_sertifikasi',
                'file_inpasing',
                'file_ktp',
                'file_ijazah_s1',
                'file_transkrip_s1',
                'file_ijazah_s2',
                'file_transkrip_s2',
                'file_ijazah_s3',
                'file_transkrip_s3',
                'file_jafung',
                'file_kk',
                'file_perjanjian_kerja',
                'file_sk_pengangkatan',
                'file_surat_pernyataan',
                'file_sktp',
                'file_surat_tugas',
                'file_sk_aktif',
                'file_dokumen'
            ];

            $deletedCount = 0;
            $errors = [];

            foreach ($dosens as $dosen) {
                try {
                    // Delete files
                    foreach ($fileFields as $field) {
                        if ($dosen->$field) {
                            $filePath = public_path('dokumen_dosen/' . $dosen->$field);
                            if (file_exists($filePath) && is_file($filePath)) {
                                @unlink($filePath);
                            }
                        }
                    }

                    // Delete record
                    $dosen->delete();
                    $deletedCount++;
                } catch (\Exception $e) {
                    \Log::error('Error deleting dosen: ' . $e->getMessage(), [
                        'dosen_id' => $dosen->id,
                        'error' => $e->getMessage()
                    ]);
                    $errors[] = "Gagal menghapus {$dosen->nama}: " . $e->getMessage();
                    continue;
                }
            }

            if ($deletedCount === 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus semua data yang dipilih. ' . implode(', ', $errors)
                ], 500);
            }

            $message = "Berhasil menghapus {$deletedCount} data dosen.";
            if (!empty($errors)) {
                $message .= " Namun ada beberapa error: " . implode(', ', $errors);
            }

            \Log::info('Bulk delete successful', ['deleted_count' => $deletedCount]);

            return response()->json([
                'success' => true,
                'message' => $message,
                'deleted_count' => $deletedCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Bulk delete error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
            ], 500);
        }
    }

    // ==========================================
    // EXPORT UNTUK SEMUA DATA DOSEN
    // ==========================================

    /**
     * Preview PDF - Tampilkan semua data dosen dalam format PDF
     */
    /**
     * Preview PDF - Tampilkan semua data dosen dalam format PDF
     */
    public function previewAllPdf(Request $request)
    {
        $query = Dosen::with(['prodi.fakultas']);

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('gelar_depan', 'like', "%{$search}%")
                    ->orWhere('gelar_belakang', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan prodi jika ada
        if ($request->has('prodi') && $request->prodi != '') {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('nama_prodi', $request->prodi);
            });
        }

        // Filter berdasarkan sertifikasi jika ada
        if ($request->has('sertifikasi') && $request->sertifikasi != '') {
            $query->where('sertifikasi', $request->sertifikasi);
        }

        // Filter berdasarkan inpasing jika ada
        if ($request->has('inpasing') && $request->inpasing != '') {
            $query->where('inpasing', $request->inpasing);
        }

        $dosen = $query->orderBy('nama')->get();
        $prodi = Prodi::with('fakultas')->get();

        // Hitung statistik tambahan di Controller, bukan di View
        $stats = [
            'total_dosen' => $dosen->count(),
            'sudah_sertifikasi' => $dosen->where('sertifikasi', 'SUDAH')->count(),
            'belum_sertifikasi' => $dosen->where('sertifikasi', 'BELUM')->count(),
            'sudah_inpasing' => $dosen->where('inpasing', 'SUDAH')->count(),
            'punya_nuptk' => $dosen->whereNotNull('nuptk')->count(),
            'punya_gelar' => $dosen->filter(function ($item) {
                return !empty($item->gelar_depan) || !empty($item->gelar_belakang);
            })->count(),
            'file_ktp_ada' => $dosen->whereNotNull('file_ktp')->count(),
            'file_sertif_ada' => $dosen->where('sertifikasi', 'SUDAH')->whereNotNull('file_sertifikasi')->count(),
        ];

        return view('page.dosen.laporan.preview', compact('dosen', 'prodi', 'stats'));
    }

    /**
     * Download PDF - Download semua data dosen dalam format PDF
     */
    /**
     * Download PDF - Download semua data dosen dalam format PDF
     */
    public function downloadAllPdf(Request $request)
    {
        $query = Dosen::with(['prodi.fakultas']);

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('nuptk', 'like', "%{$search}%")
                    ->orWhere('gelar_depan', 'like', "%{$search}%")
                    ->orWhere('gelar_belakang', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan prodi jika ada
        if ($request->has('prodi') && $request->prodi != '') {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('nama_prodi', $request->prodi);
            });
        }

        // Filter berdasarkan sertifikasi jika ada
        if ($request->has('sertifikasi') && $request->sertifikasi != '') {
            $query->where('sertifikasi', $request->sertifikasi);
        }

        // Filter berdasarkan inpasing jika ada
        if ($request->has('inpasing') && $request->inpasing != '') {
            $query->where('inpasing', $request->inpasing);
        }

        $dosen = $query->orderBy('nama')->get();

        $pdf = Pdf::loadView('page.dosen.pdf-preview', compact('dosen'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Data_Dosen_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Export ke Excel - Download data dosen dalam format Excel
     */
    public function exportExcel(Request $request)
    {
        $search = $request->get('search', '');

        return Excel::download(
            new DosenExport($search),
            'Data_Dosen_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    /**
     * Preview PDF Single - Tampilkan 1 data dosen dalam format PDF (dari show)
     */
    public function previewPdfSingle($id)
    {
        $dosen = Dosen::with(['prodi.fakultas'])->findOrFail($id);

        $pdf = Pdf::loadView('page.dosen.pdf', compact('dosen'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Detail_Dosen_' . $dosen->nama . '.pdf');
    }

    /**
     * Download PDF Single - Download 1 data dosen dalam format PDF (dari show)
     */
    public function downloadPdfSingle($id)
    {
        $dosen = Dosen::with(['prodi.fakultas'])->findOrFail($id);

        $pdf = Pdf::loadView('page.dosen.pdf', compact('dosen'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Detail_Dosen_' . $dosen->nama . '_' . date('Y-m-d_His') . '.pdf');
    }

    public function showImportForm()
    {
        if (!Auth::user()->canCrud('dosen')) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.dosen.import');
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required|mimes:xlsx,xls,csv|max:5120',
            ]);

            $file = $request->file('file');

            $import = new DosenImport();

            Excel::import($import, $file);

            $importedCount = $import->getImportedCount();
            $skippedCount = $import->getSkippedCount();
            $errors = $import->getErrors();

            if ($importedCount > 0) {
                if (!empty($errors)) {
                    return redirect()->back()
                        ->with('success', "Berhasil mengimport {$importedCount} data dosen. {$skippedCount} data dilewati karena error.")
                        ->with('imported_count', $importedCount) // TAMBAHKAN INI
                        ->with('skipped_count', $skippedCount)   // TAMBAHKAN INI (optional)
                        ->with('import_errors', $errors);
                }

                return redirect()->back()
                    ->with('success', "Berhasil mengimport {$importedCount} data dosen.")
                    ->with('imported_count', $importedCount); // TAMBAHKAN INI
            } else {
                if (!empty($errors)) {
                    return redirect()->back()
                        ->with('error', 'Tidak ada data yang berhasil diimport.')
                        ->with('import_errors', $errors);
                }

                return redirect()->back()
                    ->with('warning', 'Tidak ada data yang valid untuk diimport.');
            }
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $errorDetails = [];

            foreach ($failures as $failure) {
                $errorDetails[] = [
                    'row' => $failure->row(),
                    'field' => $failure->attribute(),
                    'errors' => $failure->errors(),
                    'value' => $failure->values()[$failure->attribute()] ?? null,
                ];
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan validasi data.')
                ->with('error_details', $errorDetails);
        } catch (\Exception $e) {
            Log::error('Import error:', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download template
     */
    public function downloadTemplate()
    {
        return Excel::download(new TemplateDosenExport(), 'template-import-dosen.xlsx');
    }
}
