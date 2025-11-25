<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\KategoriArsip;
use Illuminate\Http\Request;
// 👇 TAMBAHKAN 3 BARIS INI
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipExport;
use Illuminate\Support\Facades\Auth;


class ArsipController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Arsip::with(['kategori'])->oldest();

        if ($search = $request->search) {
            $query->where('judul_dokumen', 'like', "%{$search}%")
                ->orWhereHas('kategori', function ($q) use ($search) {
                    $q->where('nama_kategori', 'like', "%{$search}%");
                });
        }

        $arsip = $query->paginate(15);
        $kategori = KategoriArsip::all();

        if ($request->ajax()) {
            // return data JSON untuk live search
            $results = $arsip->map(function ($item) {
                return [
                    'id' => $item->id,
                    'judul_dokumen' => $item->judul_dokumen,
                    'kategori' => $item->kategori->nama_kategori ?? null,
                ];
            });
            return response()->json($results);
        }

        return view('page.arsip.index', compact('arsip', 'kategori'));
    }

    public function create()
    {
        if (!Auth::user()->canCrud('arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $kategori = KategoriArsip::all();
        return view('page.arsip.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canCrud('arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id',
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'file_dokumen.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            'file_dokumen.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, atau PNG.',
            'id_kategori.required' => 'Kategori arsip wajib dipilih.',
            'judul_dokumen.required' => 'Judul dokumen wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun tidak boleh kurang dari 1900.',
            'tahun.max' => 'Tahun tidak boleh lebih dari 2100.',
        ]);

        $data = $request->except('file_dokumen');

        // Jika ada file yang di-upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');

            // Validasi tambahan untuk memastikan ukuran file
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ukuran file tidak boleh lebih dari 2MB. File Anda: ' .
                        round($file->getSize() / (1024 * 1024), 2) . 'MB');
            }

            $filename = now()->format('YmdHis') . '-Arsip.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_arsip'), $filename);
            $data['file_dokumen'] = $filename;
        }

        Arsip::create($data);

        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->canCrud('arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $arsip = Arsip::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id',
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
            'keterangan' => 'nullable|string|max:500',
        ], [
            'file_dokumen.max' => 'Ukuran file tidak boleh lebih dari 2MB.',
            'file_dokumen.mimes' => 'Format file harus PDF, DOC, DOCX, JPG, atau PNG.',
            'id_kategori.required' => 'Kategori arsip wajib dipilih.',
            'judul_dokumen.required' => 'Judul dokumen wajib diisi.',
            'tahun.integer' => 'Tahun harus berupa angka.',
            'tahun.min' => 'Tahun tidak boleh kurang dari 1900.',
            'tahun.max' => 'Tahun tidak boleh lebih dari 2100.',
        ]);

        $data = $request->except('file_dokumen');
        $oldFile = $arsip->file_dokumen;

        // Jika ada file baru
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');

            // Validasi tambahan untuk memastikan ukuran file
            if ($file->getSize() > 2 * 1024 * 1024) {
                return redirect()->back()
                    ->withInput()
                    ->with('error', 'Ukuran file tidak boleh lebih dari 2MB. File Anda: ' .
                        round($file->getSize() / (1024 * 1024), 2) . 'MB');
            }

            // Hapus file lama jika ada
            if ($oldFile && file_exists(public_path('dokumen_arsip/' . $oldFile))) {
                unlink(public_path('dokumen_arsip/' . $oldFile));
            }

            // Simpan file baru
            $filename = now()->format('YmdHis') . '-Arsip.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_arsip'), $filename);
            $data['file_dokumen'] = $filename;
        } else {
            $data['file_dokumen'] = $oldFile;
        }

        $arsip->update($data);

        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil diperbarui.');
    }
    public function destroy($id)
    {
        if (!Auth::user()->canCrud('arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $arsip = Arsip::findOrFail($id);
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        if (!Auth::user()->canCrud('arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $ids = $request->selected_arsip;
        if ($ids) {
            $arsips = Arsip::whereIn('id', $ids)->get();
            foreach ($arsips as $arsip) {
                if ($arsip->file_dokumen && file_exists(public_path('dokumen_arsip/' . $arsip->file_dokumen))) {
                    unlink(public_path('dokumen_arsip/' . $arsip->file_dokumen));
                }
            }
            Arsip::whereIn('id', $ids)->delete();
        }

        return redirect()->route('arsip.index')->with('success', 'Data arsip terpilih berhasil dihapus.');
    }

    // ==========================================
    // 👇 TAMBAHKAN 3 METHOD BARU INI DI BAWAH
    // ==========================================

    /**
     * Preview PDF - Tampilkan data arsip dalam format PDF
     */
    public function previewAllPdf(Request $request)
    {

        $query = Arsip::with(['kategori']);

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%")
                    ->orWhere('nomor_dokumen', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // Filter berdasarkan tahun jika ada
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $arsip = $query->orderBy('judul_dokumen')->get();
        $kategori = KategoriArsip::all();

        return view('page.arsip.laporan.preview', compact('arsip', 'kategori'));
    }

    /**
     * Download PDF - Download data arsip dalam format PDF
     */
    public function downloadAllPdf(Request $request)
    {
        $query = Arsip::with(['kategori']);

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('judul_dokumen', 'like', "%{$search}%")
                    ->orWhere('nomor_dokumen', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%")
                    ->orWhereHas('kategori', function ($q) use ($search) {
                        $q->where('nama_kategori', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan kategori jika ada
        if ($request->has('kategori') && $request->kategori != '') {
            $query->whereHas('kategori', function ($q) use ($request) {
                $q->where('nama_kategori', $request->kategori);
            });
        }

        // Filter berdasarkan tahun jika ada
        if ($request->has('tahun') && $request->tahun != '') {
            $query->where('tahun', $request->tahun);
        }

        $arsip = $query->orderBy('judul_dokumen')->get();

        $pdf = Pdf::loadView('page.arsip.pdf-preview', compact('arsip'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Data_Arsip_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Export ke Excel - Download data arsip dalam format Excel
     */
    public function exportExcel(Request $request)
    {
        $search = $request->get('search', '');

        return Excel::download(
            new ArsipExport($search),
            'Data_Arsip_' . date('Y-m-d_His') . '.xlsx'
        );
    }
}
