<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;

class DosenController extends Controller
{
    public function index(Request $request)
    {
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

    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dosen.create', compact('prodi'));
    }

    public function store(Request $request)
    {
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
        $dosen = Dosen::with('prodi.fakultas')->findOrFail($id);
        return view('page.dosen.show', compact('dosen'));
    }

    public function update(Request $request, $id)
    {
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
        $ids = $request->selected_dosen;
        if ($ids) {
            $dosens = Dosen::whereIn('id', $ids)->get();

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

            foreach ($dosens as $d) {
                foreach ($fileFields as $field) {
                    $oldFile = public_path('dokumen_dosen/' . $d->$field);
                    if ($d->$field && file_exists($oldFile)) {
                        unlink($oldFile);
                    }
                }
            }

            Dosen::whereIn('id', $ids)->delete();
        }

        return redirect()->route('dosen.index')->with('success', 'Data dosen terpilih berhasil dihapus.');
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
}
