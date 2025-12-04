<?php

namespace App\Http\Controllers;

use App\Models\KategoriArsip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KategoriArsipController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->canCrud('kategori-arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->get('search');

        $kategori = KategoriArsip::when($search, function ($query) use ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_kategori', 'like', '%' . $search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $search . '%');
            });
        })
            ->oldest()
            ->paginate(20);

        return view('page.kategori_arsip.index', compact('kategori', 'search'));
    }

    public function create()
    {
        if (!Auth::user()->canCrud('kategori-arsip')) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.kategori_arsip.create');
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canCrud('kategori-arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriArsip::create($request->all());
        return redirect()->route('kategori-arsip.index')->with('success', 'Kategori arsip berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!Auth::user()->canCrud('kategori-arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $kategori = KategoriArsip::findOrFail($id);
        return view('page.kategori_arsip.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->canCrud('kategori-arsip')) {
            abort(403, 'Unauthorized action.');
        }

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
        if (!Auth::user()->canCrud('kategori-arsip')) {
            abort(403, 'Unauthorized action.');
        }

        $kategori = KategoriArsip::findOrFail($id);
        $kategori->delete();
        return redirect()->route('kategori-arsip.index')->with('success', 'Kategori arsip berhasil dihapus.');
    }
}
