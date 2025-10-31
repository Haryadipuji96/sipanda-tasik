<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\KategoriArsip;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index()
    {
        $arsip = Arsip::with(['kategori', 'prodi'])->latest()->paginate(10);
        return view('page.arsip.index', compact('arsip'));
    }

    public function create()
    {
        $kategori = KategoriArsip::all();
        $prodi = Prodi::with('fakultas')->get();
        return view('page.arsip.create', compact('kategori', 'prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id',
            'id_prodi' => 'required|exists:prodi,id',
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/arsip', $filename);
            $data['file_dokumen'] = $filename;
        }

        Arsip::create($data);
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $arsip = Arsip::findOrFail($id);
        $kategori = KategoriArsip::all();
        $prodi = Prodi::with('fakultas')->get();
        return view('page.arsip.edit', compact('arsip', 'kategori', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id',
            'id_prodi' => 'required|exists:prodi,id',
            'judul_dokumen' => 'required|string|max:255',
            'nomor_dokumen' => 'nullable|string|max:100',
            'tanggal_dokumen' => 'nullable|date',
            'tahun' => 'nullable|integer|min:1900|max:2100',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $data = $request->all();

        if ($request->hasFile('file_dokumen')) {
            if ($arsip->file_dokumen) {
                Storage::delete('public/arsip/' . $arsip->file_dokumen);
            }
            $file = $request->file('file_dokumen');
            $filename = time().'_'.$file->getClientOriginalName();
            $file->storeAs('public/arsip', $filename);
            $data['file_dokumen'] = $filename;
        }

        $arsip->update($data);
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $arsip = Arsip::findOrFail($id);
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus.');
    }
}
