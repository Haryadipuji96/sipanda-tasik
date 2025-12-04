<?php

namespace App\Http\Controllers;

use App\Exports\TemplateTenagaPendidikExport;
use App\Exports\TenagaPendidikExport;
use App\Imports\TenagaPendidikImport;
use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class TenagaPendidikController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

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
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        $prodi = Prodi::with('fakultas')->get();
        $jabatanOptions = TenagaPendidik::getJabatanStrukturalOptions(); // OPTION BARU
        return view('page.tenaga_pendidik.create', compact('prodi', 'jabatanOptions'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id',
            'nama_tendik' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'tmt_kerja' => 'nullable|date',
            'masa_kerja_tahun' => 'nullable|numeric|min:0',
            'masa_kerja_bulan' => 'nullable|numeric|min:0|max:11',
            'masa_kerja_golongan_tahun' => 'nullable|numeric|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|numeric|min:0|max:11',
            'gol' => 'nullable|string|max:20',
            'knp_yad' => 'nullable|date',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip',
            'status_kepegawaian' => 'required|in:KONTRAK,TETAP',
            'jabatan_struktural' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|unique:tenaga_pendidik,no_hp',
            'email' => 'nullable|email|unique:tenaga_pendidik,email',
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'jabatan_lainnya' => 'nullable|string|max:255',
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
        ], [
            // Custom error messages untuk file upload
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            'file.mimes' => 'Format file harus PDF, JPG, PNG, DOC, atau DOCX.',
            'file_ktp.max' => 'Ukuran file KTP tidak boleh lebih dari 2MB.',
            'file_ktp.mimes' => 'Format file KTP harus PDF, JPG, atau PNG.',
            'file_ijazah_s1.max' => 'Ukuran file Ijazah S1 tidak boleh lebih dari 2MB.',
            'file_ijazah_s1.mimes' => 'Format file Ijazah S1 harus PDF, JPG, atau PNG.',
            'file_transkrip_s1.max' => 'Ukuran file Transkrip S1 tidak boleh lebih dari 2MB.',
            'file_transkrip_s1.mimes' => 'Format file Transkrip S1 harus PDF, JPG, atau PNG.',
            'file_ijazah_s2.max' => 'Ukuran file Ijazah S2 tidak boleh lebih dari 2MB.',
            'file_ijazah_s2.mimes' => 'Format file Ijazah S2 harus PDF, JPG, atau PNG.',
            'file_transkrip_s2.max' => 'Ukuran file Transkrip S2 tidak boleh lebih dari 2MB.',
            'file_transkrip_s2.mimes' => 'Format file Transkrip S2 harus PDF, JPG, atau PNG.',
            'file_ijazah_s3.max' => 'Ukuran file Ijazah S3 tidak boleh lebih dari 2MB.',
            'file_ijazah_s3.mimes' => 'Format file Ijazah S3 harus PDF, JPG, atau PNG.',
            'file_transkrip_s3.max' => 'Ukuran file Transkrip S3 tidak boleh lebih dari 2MB.',
            'file_transkrip_s3.mimes' => 'Format file Transkrip S3 harus PDF, JPG, atau PNG.',
            'file_kk.max' => 'Ukuran file KK tidak boleh lebih dari 2MB.',
            'file_kk.mimes' => 'Format file KK harus PDF, JPG, atau PNG.',
            'file_perjanjian_kerja.max' => 'Ukuran file Perjanjian Kerja tidak boleh lebih dari 2MB.',
            'file_perjanjian_kerja.mimes' => 'Format file Perjanjian Kerja harus PDF, JPG, atau PNG.',
            'file_sk.max' => 'Ukuran file SK tidak boleh lebih dari 2MB.',
            'file_sk.mimes' => 'Format file SK harus PDF, JPG, atau PNG.',
            'file_surat_tugas.max' => 'Ukuran file Surat Tugas tidak boleh lebih dari 2MB.',
            'file_surat_tugas.mimes' => 'Format file Surat Tugas harus PDF, JPG, atau PNG.',
            'nama_tendik.required' => 'Nama Tenaga Pendidik wajib diisi.',
            'status_kepegawaian.required' => 'Status Kepegawaian wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih.',
        ]);

        $data = $request->except([
            'file',
            'golongan',
            'jabatan_lainnya',
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

        // Handle jabatan struktural
        if ($request->jabatan_struktural === 'Lainnya' && $request->filled('jabatan_lainnya')) {
            $data['jabatan_struktural'] = $request->jabatan_lainnya;
        }

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

        // Handle file upload utama dengan validasi tambahan
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Validasi tambahan untuk memastikan ukuran file
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ukuran file tidak boleh lebih dari 2MB. File Anda: ' .
                        round($file->getSize() / (1024 * 1024), 2) . 'MB');
            }

            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        // Handle upload berkas baru dengan validasi tambahan
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

                // Validasi tambahan untuk memastikan ukuran file
                if ($file->getSize() > 2 * 1024 * 1024) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Ukuran file ' . $field . ' tidak boleh lebih dari 2MB. File Anda: ' .
                            round($file->getSize() / (1024 * 1024), 2) . 'MB');
                }

                $filename = now()->format('YmdHis') . '-' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('dokumen_tendik'), $filename);
                $data[$field] = $filename;
            }
        }

        TenagaPendidik::create($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        $tenagaPendidik = TenagaPendidik::findOrFail($id);

        // PERBAIKAN: Gunakan ignore() untuk validasi unique
        $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id',
            'nama_tendik' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'tmt_kerja' => 'nullable|date',
            'masa_kerja_tahun' => 'nullable|numeric|min:0',
            'masa_kerja_bulan' => 'nullable|numeric|min:0|max:11',
            'masa_kerja_golongan_tahun' => 'nullable|numeric|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|numeric|min:0|max:11',
            'gol' => 'nullable|string|max:20',
            'knp_yad' => 'nullable|date',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip,' . $id, // PERBAIKAN
            'status_kepegawaian' => 'required|in:KONTRAK,TETAP',
            'jabatan_struktural' => 'nullable|string|max:255',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|unique:tenaga_pendidik,no_hp,' . $id, // PERBAIKAN
            'email' => 'nullable|email|unique:tenaga_pendidik,email,' . $id, // PERBAIKAN
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'jabatan_lainnya' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
            // Validasi upload berkas baru
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
        ], [
            // Custom error messages untuk file upload
            'file.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            'file.mimes' => 'Format file harus PDF, JPG, PNG, DOC, atau DOCX.',
            'file_ktp.max' => 'Ukuran file KTP tidak boleh lebih dari 2MB.',
            'file_ktp.mimes' => 'Format file KTP harus PDF, JPG, atau PNG.',
            'file_ijazah_s1.max' => 'Ukuran file Ijazah S1 tidak boleh lebih dari 2MB.',
            'file_ijazah_s1.mimes' => 'Format file Ijazah S1 harus PDF, JPG, atau PNG.',
            'file_transkrip_s1.max' => 'Ukuran file Transkrip S1 tidak boleh lebih dari 2MB.',
            'file_transkrip_s1.mimes' => 'Format file Transkrip S1 harus PDF, JPG, atau PNG.',
            'file_ijazah_s2.max' => 'Ukuran file Ijazah S2 tidak boleh lebih dari 2MB.',
            'file_ijazah_s2.mimes' => 'Format file Ijazah S2 harus PDF, JPG, atau PNG.',
            'file_transkrip_s2.max' => 'Ukuran file Transkrip S2 tidak boleh lebih dari 2MB.',
            'file_transkrip_s2.mimes' => 'Format file Transkrip S2 harus PDF, JPG, atau PNG.',
            'file_ijazah_s3.max' => 'Ukuran file Ijazah S3 tidak boleh lebih dari 2MB.',
            'file_ijazah_s3.mimes' => 'Format file Ijazah S3 harus PDF, JPG, atau PNG.',
            'file_transkrip_s3.max' => 'Ukuran file Transkrip S3 tidak boleh lebih dari 2MB.',
            'file_transkrip_s3.mimes' => 'Format file Transkrip S3 harus PDF, JPG, atau PNG.',
            'file_kk.max' => 'Ukuran file KK tidak boleh lebih dari 2MB.',
            'file_kk.mimes' => 'Format file KK harus PDF, JPG, atau PNG.',
            'file_perjanjian_kerja.max' => 'Ukuran file Perjanjian Kerja tidak boleh lebih dari 2MB.',
            'file_perjanjian_kerja.mimes' => 'Format file Perjanjian Kerja harus PDF, JPG, atau PNG.',
            'file_sk.max' => 'Ukuran file SK tidak boleh lebih dari 2MB.',
            'file_sk.mimes' => 'Format file SK harus PDF, JPG, atau PNG.',
            'file_surat_tugas.max' => 'Ukuran file Surat Tugas tidak boleh lebih dari 2MB.',
            'file_surat_tugas.mimes' => 'Format file Surat Tugas harus PDF, JPG, atau PNG.',
            'nama_tendik.required' => 'Nama Tenaga Pendidik wajib diisi.',
            'status_kepegawaian.required' => 'Status Kepegawaian wajib dipilih.',
            'jenis_kelamin.required' => 'Jenis Kelamin wajib dipilih.',
        ]);

        $data = $request->except([
            'file',
            'golongan',
            'jabatan_lainnya',
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

        // Handle jabatan struktural
        if ($request->jabatan_struktural === 'Lainnya' && $request->filled('jabatan_lainnya')) {
            $data['jabatan_struktural'] = $request->jabatan_lainnya;
        }


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

        // Handle file upload utama dengan validasi tambahan
        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Validasi tambahan untuk memastikan ukuran file
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ukuran file tidak boleh lebih dari 2MB. File Anda: ' .
                        round($file->getSize() / (1024 * 1024), 2) . 'MB');
            }

            if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
                unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
            }

            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        // Handle upload berkas baru dengan validasi tambahan
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

                // Validasi tambahan untuk memastikan ukuran file
                if ($file->getSize() > 2 * 1024 * 1024) {
                    return redirect()->back()
                        ->withInput()
                        ->with('error', 'Ukuran file ' . $field . ' tidak boleh lebih dari 2MB. File Anda: ' .
                            round($file->getSize() / (1024 * 1024), 2) . 'MB');
                }

                // Hapus file lama jika ada
                if ($tenagaPendidik->$field && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->$field))) {
                    unlink(public_path('dokumen_tendik/' . $tenagaPendidik->$field));
                }

                $filename = now()->format('YmdHis') . '-' . $field . '.' . $file->getClientOriginalExtension();
                $file->move(public_path('dokumen_tendik'), $filename);
                $data[$field] = $filename;
            }
        }

        $tenagaPendidik->update($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil diperbarui.');
    }

    // Method show() TETAP SAMA
    public function show($id)
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);
        return view('page.tenaga_pendidik.show', compact('tenagaPendidik'));
    }

    public function edit($id)
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        $tendik = TenagaPendidik::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        $jabatanOptions = TenagaPendidik::getJabatanStrukturalOptions(); // OPTION BARU
        return view('page.tenaga_pendidik.edit', compact('tendik', 'prodi', 'jabatanOptions'));
    }



    // Method destroy() dan lainnya TETAP SAMA...
    // Hanya perlu menambahkan penghapusan file berkas baru
    public function destroy($id)
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }


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
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized action.'
                ], 403);
            }
            abort(403, 'Unauthorized action.');
        }

        try {
            $ids = $request->input('selected_tendik', []);

            \Log::info('Delete selected tendik attempt', ['ids' => $ids, 'user_id' => Auth::id()]);

            if (empty($ids)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Tidak ada data yang dipilih untuk dihapus.'
                    ], 400);
                }
                return redirect()->route('tenaga-pendidik.index')
                    ->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
            }

            // Validasi IDs
            $validIds = array_filter($ids, function ($id) {
                return is_numeric($id) && $id > 0;
            });

            $items = TenagaPendidik::whereIn('id', $validIds)->get();
            $deletedCount = 0;

            foreach ($items as $tendik) {
                try {
                    // Delete file jika ada
                    if ($tendik->file && file_exists(public_path('dokumen_tendik/' . $tendik->file))) {
                        unlink(public_path('dokumen_tendik/' . $tendik->file));
                    }

                    // Delete record
                    $tendik->delete();
                    $deletedCount++;
                } catch (\Exception $e) {
                    \Log::error('Error deleting tendik: ' . $e->getMessage(), [
                        'tendik_id' => $tendik->id,
                        'error' => $e->getMessage()
                    ]);
                    continue;
                }
            }

            if ($deletedCount === 0) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Gagal menghapus data yang dipilih.'
                    ], 500);
                }
                return redirect()->route('tenaga-pendidik.index')
                    ->with('error', 'Gagal menghapus data yang dipilih.');
            }

            $message = "Berhasil menghapus {$deletedCount} data tenaga pendidik.";
            \Log::info('Bulk delete tendik successful', ['deleted_count' => $deletedCount]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => $message,
                    'deleted_count' => $deletedCount
                ]);
            }

            return redirect()->route('tenaga-pendidik.index')
                ->with('success', $message);
        } catch (\Exception $e) {
            \Log::error('Bulk delete tendik error: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem: ' . $e->getMessage()
                ], 500);
            }

            return redirect()->route('tenaga-pendidik.index')
                ->with('error', 'Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    // DI CONTROLLER - PERBAIKI METHOD INI
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
                    ->orWhere('jabatan_struktural', 'like', "%{$search}%")
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

        // PERBAIKAN: Gunakan file preview.blade.php yang sudah ada
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
                    ->orWhere('jabatan_struktural', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        $tenaga = $query->orderBy('nama_tendik')->get();

        // PERBAIKAN: Gunakan view yang benar - pdf-all.blade.php
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

        // PERBAIKAN: Pastikan menggunakan variabel yang sama dengan view
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

        // PERBAIKAN: Pastikan menggunakan variabel yang sama dengan view
        $pdf = Pdf::loadView('page.tenaga_pendidik.pdf', compact('tenagaPendidik'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Detail_Tenaga_Pendidik_' . $tenagaPendidik->nama_tendik . '_' . date('Y-m-d_His') . '.pdf');
    }

    public function showImportForm()
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.tenaga_pendidik.import');
    }

    /**
     * Process import
     */
    public function import(Request $request)
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:5120' // max 5MB
        ]);

        try {
            // Clear output buffer
            if (ob_get_length()) ob_end_clean();

            \Log::info('Import tenaga pendidik dimulai', [
                'user_id' => Auth::id(),
                'file_name' => $request->file('file')->getClientOriginalName(),
                'file_size' => $request->file('file')->getSize(),
                'mime_type' => $request->file('file')->getMimeType()
            ]);

            // Deteksi file type
            $fileExtension = strtolower($request->file('file')->getClientOriginalExtension());

            $import = new TenagaPendidikImport;

            if ($fileExtension === 'csv') {
                // Import CSV dengan delimiter yang tepat
                Excel::import($import, $request->file('file'), null, \Maatwebsite\Excel\Excel::CSV);
            } else {
                // Import Excel
                Excel::import($import, $request->file('file'));
            }

            $importedCount = $import->getImportedCount();
            $importErrors = $import->getErrors();

            \Log::info('Import tenaga pendidik selesai', [
                'imported_count' => $importedCount,
                'errors_count' => count($importErrors)
            ]);

            if ($importedCount === 0 && empty($importErrors)) {
                return redirect()->back()
                    ->with('warning', 'Tidak ada data yang diimport. Pastikan file tidak kosong dan format sesuai template.')
                    ->withInput();
            }

            $successMessage = "Berhasil mengimport {$importedCount} data tenaga pendidik.";

            if (!empty($importErrors)) {
                $errorCount = count($importErrors);
                $successMessage .= " ({$errorCount} data gagal diimport)";

                // Simpan error untuk ditampilkan - PASTIKAN INI ARRAY
                session()->flash('import_errors', $importErrors);
            }

            return redirect()->route('tenaga-pendidik.index')
                ->with('success', $successMessage);
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            \Log::error('Import validation error', [
                'errors' => $e->errors(),
                'failures' => $e->failures()
            ]);

            $failures = $e->failures();
            $errorMessages = [];
            $failureDetails = [];

            foreach ($failures as $failure) {
                $row = $failure->row();
                $attribute = $failure->attribute();
                $errors = implode(', ', $failure->errors());
                $values = $failure->values();

                // Format pesan error sebagai STRING
                $errorMessages[] = "Baris {$row} ({$attribute}): {$errors} - Nilai: " . (is_array($values[$attribute] ?? null) ? json_encode($values[$attribute]) : ($values[$attribute] ?? 'kosong'));

                // Simpan detail sebagai array
                $failureDetails[] = [
                    'row' => $row,
                    'attribute' => $attribute,
                    'errors' => $failure->errors(), // Array dari errors
                    'values' => $values // Array dari values
                ];
            }

            return redirect()->back()
                ->with('error', 'Validasi data gagal. Silakan perbaiki data berikut:')
                ->with('error_details', $errorMessages) // Array of strings
                ->with('validation_failures', $failureDetails) // Array of arrays
                ->withInput();
        } catch (\Maatwebsite\Excel\Exceptions\NoTypeDetectedException $e) {
            \Log::error('File type detection error', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'Format file tidak dikenali. Pastikan file berformat Excel (.xlsx atau .xls)')
                ->withInput();
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            \Log::error('Spreadsheet reader error', ['error' => $e->getMessage()]);

            return redirect()->back()
                ->with('error', 'File Excel corrupt atau tidak bisa dibaca. Pastikan file tidak rusak.')
                ->withInput();
        } catch (\Illuminate\Database\QueryException $e) {
            \Log::error('Database query error during import', ['error' => $e->getMessage()]);

            // Check for duplicate entry error
            if (str_contains($e->getMessage(), 'Duplicate entry')) {
                return redirect()->back()
                    ->with('error', 'Data duplikat ditemukan. Pastikan NIP/Email/No HP unik.')
                    ->withInput();
            }

            return redirect()->back()
                ->with('error', 'Kesalahan database: ' . $e->getMessage())
                ->withInput();
        } catch (\Exception $e) {
            \Log::error('General import error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorMessage = 'Terjadi kesalahan saat mengimport file.';

            // Pesan error yang lebih spesifik
            if (str_contains($e->getMessage(), 'Undefined array key')) {
                $errorMessage = 'Format file tidak sesuai template. Pastikan menggunakan template yang benar.';
            } elseif (str_contains($e->getMessage(), 'Could not find')) {
                $errorMessage = 'File tidak ditemukan atau corrupt.';
            } elseif (str_contains($e->getMessage(), 'failed to open stream')) {
                $errorMessage = 'File tidak dapat dibaca. Pastikan file tidak sedang digunakan.';
            } elseif (str_contains($e->getMessage(), 'Invalid file type')) {
                $errorMessage = 'Format file tidak didukung. Gunakan .xlsx, .xls, atau .csv';
            }

            return redirect()->back()
                ->with('error', $errorMessage)
                ->withInput();
        }
    }
    /**
     * Download template
     */
    public function downloadTemplate()
    {
        if (!Auth::user()->canCrud('tenaga-pendidik')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            // Clear output buffer
            if (ob_get_length()) ob_end_clean();

            // Generate filename dengan timestamp
            $filename = 'template_import_tenaga_pendidik_' . date('Ymd_His') . '.xlsx';

            // Header untuk force download
            return Excel::download(
                new TemplateTenagaPendidikExport(),
                $filename,
                \Maatwebsite\Excel\Excel::XLSX,
                [
                    'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    'Content-Disposition' => 'attachment; filename="' . $filename . '"'
                ]
            );
        } catch (\Exception $e) {
            \Log::error('Template download error: ' . $e->getMessage());

            // Fallback: generate CSV jika Excel error
            return $this->downloadTemplateAsCsv();
        }
    }

    // Fallback method untuk CSV
    private function downloadTemplateAsCsv()
    {
        $headers = [
            'Content-Type' => 'text/csv; charset=utf-8',
            'Content-Disposition' => 'attachment; filename="template_tenaga_pendidik_' . date('Ymd') . '.csv"',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');

            // Headers sesuai dengan form
            fputcsv($file, [
                'gelar_depan',
                'nama_tendik*',
                'gelar_belakang',
                'program_studi',
                'jabatan_struktural',
                'status_kepegawaian*',
                'jenis_kelamin*',
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
            ]);

            // Contoh data
            fputcsv($file, [
                'Dr.',
                'Ahmad Fauzi',
                'S.Pd., M.Kom.',
                'Teknik Informatika',
                'Kepala Program Studi',
                'TETAP',
                'Laki-laki',
                'Tasikmalaya',
                '1990-05-15',
                '2015-08-01',
                '10',
                '3',
                '8',
                '2',
                'IV/A',
                '2025-12-31',
                '1987654321',
                'ahmad.fauzi@email.com',
                '081234567890',
                'Jl. Contoh No. 123, Tasikmalaya',
                'S2',
                'Tenaga pendidik aktif mengajar',
                '2023;IV/A|2020;III/B|2017;II/A'
            ]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
