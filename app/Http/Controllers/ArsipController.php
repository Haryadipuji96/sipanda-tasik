<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\KategoriArsip;
use Illuminate\Http\Request;
// 👇 TAMBAHKAN 3 BARIS INI
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ArsipExport;

class ArsipController extends Controller
{
    public function index(Request $request)
    {
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
        $kategori = KategoriArsip::all();
        return view('page.arsip.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id',
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data = $request->except('file_dokumen');

        // Jika ada file yang di-upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = now()->format('YmdHis') . '-Arsip.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_arsip'), $filename);
            $data['file_dokumen'] = $filename;
        }

        Arsip::create($data);

        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id',
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Ambil semua data kecuali file
        $data = $request->except('file_dokumen');

        // Simpan nama file lama
        $oldFile = $arsip->file_dokumen;

        // Jika ada file baru
        if ($request->hasFile('file_dokumen')) {
            // Hapus file lama jika ada
            if ($oldFile && file_exists(public_path('dokumen_arsip/' . $oldFile))) {
                unlink(public_path('dokumen_arsip/' . $oldFile));
            }

            // Simpan file baru
            $file = $request->file('file_dokumen');
            $filename = now()->format('YmdHis') . '-Arsip.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_arsip'), $filename);

            // Ganti nama file di data
            $data['file_dokumen'] = $filename;
        } else {
            // Kalau tidak upload file baru, pakai file lama
            $data['file_dokumen'] = $oldFile;
        }

        // Update data ke database
        $arsip->update($data);

        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $arsip = Arsip::findOrFail($id);
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->selected_dosen;
        if ($ids) {
            $dosens = Arsip::whereIn('id', $ids)->get();
            foreach ($dosens as $d) {
                if ($d->file_dokumen && file_exists(public_path('storage/dokumen_dosen/' . $d->file_dokumen))) {
                    unlink(public_path('storage/dokumen_dosen/' . $d->file_dokumen));
                }
            }
            Arsip::whereIn('id', $ids)->delete();
        }

        return redirect()->route('dosen.index')->with('success', 'Data dosen terpilih berhasil dihapus.');
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