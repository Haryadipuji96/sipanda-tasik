<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;

class FakultasController extends Controller
{
    public function index()
    {
        $fakultas = Fakultas::latest()->paginate(10);
        return view('page.fakultas.index', compact('fakultas'));
    }

    public function create()
    {
        return view('page.fakultas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'dekan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        Fakultas::create($request->all());
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        return view('page.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'dekan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $fakultas = Fakultas::findOrFail($id);
        $fakultas->update($request->all());

        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $fakultas = Fakultas::findOrFail($id);
        $fakultas->delete();
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil dihapus.');
    }
}
