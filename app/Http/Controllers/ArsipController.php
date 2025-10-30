<?php

namespace App\Http\Controllers;

use App\Models\Arsip;
use App\Models\KategoriArsip;
use App\Models\Prodi;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArsipController extends Controller
{
    public function index()
    {
        $arsip = Arsip::with(['kategori', 'prodi', 'dosen'])->latest()->paginate(10);
        return view('page.arsip.index', compact('arsip'));
    }

    public function create()
    {
        $kategori = KategoriArsip::all();
        $prodi = Prodi::with('fakultas')->get();
        $dosen = Dosen::all();
        return view('page.arsip.create', compact('kategori', 'prodi', 'dosen'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id_kategori',
            'judul_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
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
        $dosen = Dosen::all();
        return view('page.arsip.edit', compact('arsip', 'kategori', 'prodi', 'dosen'));
    }

    public function update(Request $request, $id)
    {
        $arsip = Arsip::findOrFail($id);

        $request->validate([
            'id_kategori' => 'required|exists:kategori_arsip,id_kategori',
            'judul_dokumen' => 'required|string|max:255',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
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
        if ($arsip->file_dokumen) {
            Storage::delete('public/arsip/'.$arsip->file_dokumen);
        }
        $arsip->delete();
        return redirect()->route('arsip.index')->with('success', 'Data arsip berhasil dihapus.');
    }
}
