<?php

namespace App\Http\Controllers;

use App\Models\KategoriArsip;
use Illuminate\Http\Request;

class KategoriArsipController extends Controller
{
    public function index()
    {
        $kategori = KategoriArsip::latest()->paginate(10);
        return view('page.kategori_arsip.index', compact('kategori'));
    }

    public function create()
    {
        return view('page.kategori_arsip.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriArsip::create($request->all());
        return redirect()->route('kategori-arsip.index')->with('success', 'Kategori arsip berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $kategori = KategoriArsip::findOrFail($id);
        return view('page.kategori_arsip.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori = KategoriArsip::findOrFail($id);
        $kategori->update($request->all());

        return redirect()->route('kategori-arsip.index')->with('success', 'Kategori arsip berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $kategori = KategoriArsip::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori-arsip.index')->with('success', 'Kategori arsip berhasil dihapus.');
    }
}
