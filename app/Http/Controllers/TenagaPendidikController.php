<?php

namespace App\Http\Controllers;

use App\Exports\TenagaPendidikExport;
use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class TenagaPendidikController extends Controller
{
    public function index(Request $request)
    {
        $query = TenagaPendidik::with('prodi.fakultas')->oldest();

        if ($search = $request->search) {
            $query->where('nama_tendik', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('jabatan_struktural', 'like', "%{$search}%") // TAMBAHAN PENCARIAN
                ->orWhereHas('prodi', function ($q) use ($search) {
                    $q->where('nama_prodi', 'like', "%{$search}%");
                });
        }

        $tenaga = $query->paginate(15);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.tenaga_pendidik.index', compact('tenaga', 'prodi'));
    }

    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        $jabatanOptions = TenagaPendidik::getJabatanStrukturalOptions(); // OPTION BARU
        return view('page.tenaga_pendidik.create', compact('prodi', 'jabatanOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id', // UBAH MENJADI NULLABLE
            'nama_tendik' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'tmt_kerja' => 'nullable|date',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip',
            'status_kepegawaian' => 'required|in:PNS,Non PNS Tetap,Non PNS Tidak Tetap', // UBAH OPTION
            'jabatan_struktural' => 'nullable|string|max:255', // VALIDASI BARU
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|unique:tenaga_pendidik,no_hp',
            'email' => 'nullable|email|unique:tenaga_pendidik,email',
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            // VALIDASI UPLOAD BERKAS BARU
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_perjanjian_kerja' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except([
            'file',
            'golongan',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk',
            'file_surat_tugas'
        ]);

        // Handle golongan history dinamis
        if ($request->filled('golongan') && is_array($request->golongan)) {
            $golonganArray = collect($request->golongan)
                ->filter(fn($item) => !empty($item['tahun']) || !empty($item['golongan']))
                ->values()
                ->toArray();

            $data['golongan_history'] = !empty($golonganArray) ? json_encode($golonganArray) : null;
        } else {
            $data['golongan_history'] = null;
        }

        // Handle file upload utama
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        // Handle upload berkas baru
        $berkasFields = [
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk',
            'file_surat_tugas'
        ];

        foreach ($berkasFields as $field) {
            if ($request->hasFile($field)) {
                $file = $request->file($field);
                $filename = now()->format('YmdHis') . '-' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('dokumen_tendik'), $filename);
                $data[$field] = $filename;
            }
        }

        TenagaPendidik::create($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil ditambahkan.');
    }

    // Method show() TETAP SAMA
    public function show($id)
    {
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);
        return view('page.tenaga_pendidik.show', compact('tenagaPendidik'));
    }

    public function edit($id)
    {
        $tenagaPendidik = TenagaPendidik::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        $jabatanOptions = TenagaPendidik::getJabatanStrukturalOptions(); // OPTION BARU
        return view('page.tenaga_pendidik.edit', compact('tenagaPendidik', 'prodi', 'jabatanOptions'));
    }

    public function update(Request $request, $id)
    {
        $tenagaPendidik = TenagaPendidik::findOrFail($id);

        $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id', // UBAH MENJADI NULLABLE
            'nama_tendik' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'tmt_kerja' => 'nullable|date',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip,' . $tenagaPendidik->id,
            'status_kepegawaian' => 'required|in:PNS,Non PNS Tetap,Non PNS Tidak Tetap', // UBAH OPTION
            'jabatan_struktural' => 'nullable|string|max:255', // VALIDASI BARU
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|unique:tenaga_pendidik,no_hp,' . $tenagaPendidik->id,
            'email' => 'nullable|email|unique:tenaga_pendidik,email,' . $tenagaPendidik->id,
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            // VALIDASI UPLOAD BERKAS BARU
            'file_ktp' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s1' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s2' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_ijazah_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_transkrip_s3' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_kk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_perjanjian_kerja' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_sk' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'file_surat_tugas' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except([
            'file',
            'golongan',
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk',
            'file_surat_tugas'
        ]);

        // Handle golongan history dinamis
        if ($request->filled('golongan') && is_array($request->golongan)) {
            $golonganArray = collect($request->golongan)
                ->filter(fn($item) => !empty($item['tahun']) || !empty($item['golongan']))
                ->values()
                ->toArray();

            $data['golongan_history'] = !empty($golonganArray) ? json_encode($golonganArray) : null;
        } else {
            $data['golongan_history'] = null;
        }

        // Handle file upload utama
        if ($request->hasFile('file')) {
            if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
                unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
            }

            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        // Handle upload berkas baru
        $berkasFields = [
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk',
            'file_surat_tugas'
        ];

        foreach ($berkasFields as $field) {
            if ($request->hasFile($field)) {
                // Hapus file lama jika ada
                if ($tenagaPendidik->$field && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->$field))) {
                    unlink(public_path('dokumen_tendik/' . $tenagaPendidik->$field));
                }

                $file = $request->file($field);
                $filename = now()->format('YmdHis') . '-' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('dokumen_tendik'), $filename);
                $data[$field] = $filename;
            }
        }

        $tenagaPendidik->update($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Method destroy() dan lainnya TETAP SAMA...
    // Hanya perlu menambahkan penghapusan file berkas baru
    public function destroy($id)
    {
        $tenagaPendidik = TenagaPendidik::findOrFail($id);

        // Hapus file utama
        if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
            unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
        }

        // Hapus file berkas baru
        $berkasFields = [
            'file_ktp',
            'file_ijazah_s1',
            'file_transkrip_s1',
            'file_ijazah_s2',
            'file_transkrip_s2',
            'file_ijazah_s3',
            'file_transkrip_s3',
            'file_kk',
            'file_perjanjian_kerja',
            'file_sk',
            'file_surat_tugas'
        ];

        foreach ($berkasFields as $field) {
            if ($tenagaPendidik->$field && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->$field))) {
                unlink(public_path('dokumen_tendik/' . $tenagaPendidik->$field));
            }
        }

        $tenagaPendidik->delete();

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->selected_tendik;

        if ($ids) {
            $items = TenagaPendidik::whereIn('id', $ids)->get();

            foreach ($items as $t) {
                if ($t->file && file_exists(public_path('dokumen_tendik/' . $t->file))) {
                    unlink(public_path('dokumen_tendik/' . $t->file));
                }
            }

            TenagaPendidik::whereIn('id', $ids)->delete();
        }

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data tenaga pendidik terpilih berhasil dihapus.');
    }

    public function previewAllPdf(Request $request)
    {
        $query = TenagaPendidik::with('prodi.fakultas');

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tendik', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan status kepegawaian jika ada
        if ($request->has('status_kepegawaian') && $request->status_kepegawaian != '') {
            $query->where('status_kepegawaian', $request->status_kepegawaian);
        }

        // Filter berdasarkan prodi jika ada
        if ($request->has('id_prodi') && $request->id_prodi != '') {
            $query->where('id_prodi', $request->id_prodi);
        }

        $tenaga = $query->orderBy('nama_tendik')->get();
        $prodi = Prodi::with('fakultas')->get();

        // Gunakan file preview-all-pdf.blade.php yang baru
        return view('page.tenaga_pendidik.laporan.preview', compact('tenaga', 'prodi'));
    }

    /**
     * Download PDF - Download semua data tendik dalam format PDF
     */
    public function downloadAllPdf(Request $request)
    {
        $query = TenagaPendidik::with('prodi.fakultas');

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_tendik', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        $tenaga = $query->orderBy('nama_tendik')->get();

        // PERBAIKAN: Hapus spasi dari nama view
        $pdf = Pdf::loadView('page.tenaga_pendidik.pdf-all', compact('tenaga'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Data_Tenaga_Pendidik_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Export ke Excel - Download data tendik dalam format Excel
     */
    public function exportExcel(Request $request)
    {
        $search = $request->get('search', '');

        return Excel::download(
            new TenagaPendidikExport($search),
            'Data_Tenaga_Pendidik_' . date('Y-m-d_His') . '.xlsx'
        );
    }

    // ==========================================
    // EXPORT UNTUK SINGLE DATA TENAGA PENDIDIK
    // ==========================================

    /**
     * Preview PDF Single - Tampilkan 1 data tendik dalam format PDF (dari show)
     */
    public function previewPdf($id)
    {
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);

        $pdf = Pdf::loadView('page.tenaga_pendidik.pdf', compact('tenagaPendidik'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Detail_Tenaga_Pendidik_' . $tenagaPendidik->nama_tendik . '.pdf');
    }

    /**
     * Download PDF Single - Download 1 data tendik dalam format PDF (dari show)
     */
    public function downloadPdf($id)
    {
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);

        $pdf = Pdf::loadView('page.tenaga_pendidik.pdf', compact('tenagaPendidik'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Detail_Tenaga_Pendidik_' . $tenagaPendidik->nama_tendik . '_' . date('Y-m-d_His') . '.pdf');
    }
}
