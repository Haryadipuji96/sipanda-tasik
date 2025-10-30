<?php

namespace App\Http\Controllers;

use App\Models\DataSarpras;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DataSarprasController extends Controller
{
    public function index()
    {
        $sarpras = DataSarpras::with('prodi')->latest()->paginate(10);
        return view('page.sarpras.index', compact('sarpras'));
    }

    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('page.sarpras.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id_prodi',
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

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/sarpras', $filename);
            $validated['file_dokumen'] = $filename;
        }

        DataSarpras::create($validated);
        return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil ditambahkan.');
    }

    // GANTI METHOD EDIT - gunakan route model binding dengan ID
    public function edit($id)
    {
        $sarpras = DataSarpras::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        return view('page.sarpras.edit', compact('sarpras', 'prodi'));
    }

    // GANTI METHOD UPDATE - gunakan parameter ID
    public function update(Request $request, $id)
    {
        $sarpras = DataSarpras::findOrFail($id);
        
        $validated = $request->validate([
            'id_prodi' => 'nullable|exists:prodi,id_prodi',
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

        if ($request->hasFile('file_dokumen')) {
            if ($sarpras->file_dokumen) {
                Storage::delete('public/sarpras/' . $sarpras->file_dokumen);
            }
            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/sarpras', $filename);
            $validated['file_dokumen'] = $filename;
        }

        $sarpras->update($validated);

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
}