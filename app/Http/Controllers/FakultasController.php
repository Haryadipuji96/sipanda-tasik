<?php

namespace App\Http\Controllers;

use App\Models\Fakultas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FakultasController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->canCrud('fakultas')) {
            abort(403, 'Unauthorized action.');
        }

        $query = Fakultas::query();

        if ($search = $request->search) {
            $query->where('nama_fakultas', 'like', "%{$search}%")
                ->orWhere('dekan', 'like', "%{$search}%");
        }

        $fakultas = $query->oldest()->paginate(20); // <--- pakai $query, bukan Fakultas::latest()

        return view('page.fakultas.index', compact('fakultas'));
    }


    public function create()
    {
        if (!Auth::user()->canCrud('fakultas')) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.fakultas.create');
    }

    public function store(Request $request)
    {

        if (!Auth::user()->canCrud('fakultas')) {
            abort(403, 'Unauthorized action.');
        }

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
        if (!Auth::user()->canCrud('fakultas')) {
            abort(403, 'Unauthorized action.');
        }

        $fakultas = Fakultas::findOrFail($id);
        return view('page.fakultas.edit', compact('fakultas'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->canCrud('fakultas')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'nama_fakultas' => 'required|string|max:255',
            'dekan' => 'nullable|string|max:50',
            'deskripsi' => 'nullable|string',
        ]);

        $fakultas = Fakultas::findOrFail($id);
        $fakultas->update($request->all());

        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil diperbarui.');
    }

    // App/Http/Controllers/FakultasController.php
    public function destroy($id)
    {
        if (!Auth::user()->canCrud('fakultas')) {
            abort(403, 'Unauthorized action.');
        }

        $fakultas = Fakultas::with(['prodi' => function ($query) {
            $query->withCount('dokumenMahasiswa');
        }])->findOrFail($id);

        // Cek apakah fakultas memiliki prodi dengan dokumen mahasiswa
        $hasDokumen = false;
        $totalMahasiswa = 0;

        foreach ($fakultas->prodi as $prodi) {
            if ($prodi->dokumen_mahasiswa_count > 0) {
                $hasDokumen = true;
                $totalMahasiswa += $prodi->dokumen_mahasiswa_count;
            }
        }

        if ($hasDokumen) {
            return redirect()->route('fakultas.index')
                ->with('error', 'Tidak dapat menghapus fakultas karena terdapat ' .
                    $totalMahasiswa . ' data mahasiswa di program studi terkait. ' .
                    'Harap hapus atau pindahkan data mahasiswa terlebih dahulu.');
        }

        $fakultas->delete();
        return redirect()->route('fakultas.index')->with('success', 'Data fakultas berhasil dihapus.');
    }
}
