<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::with('fakultas')->latest()->paginate(10);
        return view('page.prodi.index', compact('prodi'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        return view('page.prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $prodi = Prodi::findOrFail($id);
        $fakultas = Fakultas::all();
        return view('page.prodi.edit', compact('prodi', 'fakultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id_fakultas',
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $prodi = Prodi::findOrFail($id);
        $prodi->update($request->all());

        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil dihapus.');
    }
}
