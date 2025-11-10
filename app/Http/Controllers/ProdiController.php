<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use Illuminate\Http\Request;

class ProdiController extends Controller
{
    public function index()
    {
        $prodi = Prodi::with('fakultas')->latest()->paginate(15);
        $fakultas = Fakultas::all(); // <-- tambahkan ini
        return view('page.prodi.index', compact('prodi', 'fakultas'));
    }


    public function create()
    {
        $fakultas = Fakultas::all();
        return view('page.prodi.create', compact('fakultas'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id',
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
        try {
            $request->validate([
                'id_fakultas' => 'required|exists:fakultas,id', // PERBAIKAN: exists:fakultas,id
                'nama_prodi' => 'required|string|max:255',
                'jenjang' => 'nullable|string|max:50',
                'deskripsi' => 'nullable|string',
            ]);

            $prodi = Prodi::findOrFail($id);
            $prodi->update($request->all());

            return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        $prodi = Prodi::findOrFail($id);
        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil dihapus.');
    }
}
