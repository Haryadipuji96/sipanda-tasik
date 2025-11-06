<?php

namespace App\Http\Controllers;

use App\Models\DataSarpras;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class DataSarprasController extends Controller
{
    public function index(Request $request)
    {
        $query = DataSarpras::with('prodi')->latest();

        if ($request->filled('search')) {
            $query->where('nama_barang', 'like', "%{$request->search}%")
                ->orWhere('kategori', 'like', "%{$request->search}%")
                ->orWhereHas('prodi', function ($q) use ($request) {
                    $q->where('nama_prodi', 'like', "%{$request->search}%");
                });
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $sarpras = $query->paginate(15);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.sarpras.index', compact('sarpras', 'prodi'));
    }

    // ✅ Satu method untuk PDF, support portrait & landscape
    public function laporanPDF(Request $request)
    {
        $query = DataSarpras::with('prodi')->latest();

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $sarpras = $query->get();
        $kondisi = $request->kondisi; // null atau string kondisi

        // Default portrait, bisa dikasih parameter orientasi jika mau
        $orientation = $request->get('orientation', 'portrait'); // portrait atau landscape

        $pdf = Pdf::loadView('page.sarpras.laporan_pdf', compact('sarpras', 'kondisi'))
            ->setPaper('A4', $orientation);

        $kondisiLabel = $kondisi ?? 'Semua_Kondisi';
        $namaFile = 'Laporan_Sarpras_' . str_replace(' ', '_', $kondisiLabel) . '.pdf';

        return $pdf->download($namaFile);
    }

    // ✅ Preview sebelum download
    public function preview(Request $request)
    {
        $query = DataSarpras::with('prodi')->latest();

        if ($request->filled('kondisi')) {
            $query->where('kondisi', $request->kondisi);
        }

        $sarpras = $query->get();
        $kondisi = $request->kondisi;

        return view('page.sarpras.laporan.preview', compact('sarpras', 'kondisi'));
    }


    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('page.sarpras.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date',
            'spesifikasi' => 'required|string',
            'kode_seri' => 'required|string|max:100',
            'sumber' => 'required|in:HIBAH,LEMBAGA,YAYASAN',
            'keterangan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'lokasi_lain' => 'nullable|string|max:255',
        ]);

        $data = $validated;

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = now()->format('YmdHis') . '-Sarpras.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_sarpras'), $filename);
            $data['file_dokumen'] = $filename;
        }

        DataSarpras::create($data);

        return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil ditambahkan.');
    }



    public function edit($id)
    {
        //
    }

    // GANTI METHOD UPDATE - gunakan parameter ID
    public function update(Request $request, $id)
    {
        $sarpras = DataSarpras::findOrFail($id);

        $validated = $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'kondisi' => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date',
            'spesifikasi' => 'required|string',
            'kode_seri' => 'required|string|max:100',
            'sumber' => 'required|in:HIBAH,LEMBAGA,YAYASAN',
            'keterangan' => 'nullable|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
            'lokasi_lain' => 'nullable|string|max:255',
        ]);

        $data = $validated;

        if ($request->hasFile('file_dokumen')) {
            $oldFile = $sarpras->file_dokumen;
            if ($oldFile && file_exists(public_path('dokumen_sarpras/' . $oldFile))) {
                unlink(public_path('dokumen_sarpras/' . $oldFile));
            }

            $file = $request->file('file_dokumen');
            $filename = now()->format('YmdHis') . '-Sarpras.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_sarpras'), $filename);
            $data['file_dokumen'] = $filename;
        }

        $sarpras->update($data);

        return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil diperbarui.');
    }


    public function show($id)
    {
        $sarpras = DataSarpras::findOrFail($id);
        return view('page.sarpras.show', compact('sarpras'));
    }

    public function destroy($id)
    {
        $sarpras = DataSarpras::findOrFail($id);
        if ($sarpras->file_dokumen) {
            Storage::delete('public/sarpras/' . $sarpras->file_dokumen);
        }
        $sarpras->delete();
        return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->selected_dosen;
        if ($ids) {
            $dosens = DataSarpras::whereIn('id', $ids)->get();
            foreach ($dosens as $d) {
                if ($d->file_dokumen && file_exists(public_path('storage/dokumen_dosen/' . $d->file_dokumen))) {
                    unlink(public_path('storage/dokumen_dosen/' . $d->file_dokumen));
                }
            }
            DataSarpras::whereIn('id', $ids)->delete();
        }

        return redirect()->route('dosen.index')->with('success', 'Data dosen terpilih berhasil dihapus.');
    }
}
