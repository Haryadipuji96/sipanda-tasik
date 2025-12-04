<?php

namespace App\Http\Controllers;

use App\Models\Prodi;
use App\Models\Fakultas;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProdiController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->canCrud('prodi')) {
            abort(403, 'Unauthorized action.');
        }

        $search = $request->get('search');

        $prodi = Prodi::with(['fakultas', 'ketuaProdi'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_prodi', 'like', '%' . $search . '%')
                        ->orWhere('jenjang', 'like', '%' . $search . '%')
                        ->orWhere('deskripsi', 'like', '%' . $search . '%')
                        ->orWhereHas('fakultas', function ($q) use ($search) {
                            $q->where('nama_fakultas', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('ketuaProdi', function ($q) use ($search) {
                            // GANTI 'namaLengkap' dengan nama kolom yang benar
                            $q->where('nama', 'like', '%' . $search . '%'); // atau 'nama_lengkap', 'name', dll
                        });
                });
            })
            ->oldest()
            ->paginate(15);

        $fakultas = Fakultas::all();
        $dosen = Dosen::all();

        return view('page.prodi.index', compact('prodi', 'fakultas', 'dosen', 'search'));
    }


    public function create()
    {
        if (!Auth::user()->canCrud('prodi')) {
            abort(403, 'Unauthorized action.');
        }

        $fakultas = Fakultas::all();
        $dosen = Dosen::all();
        return view('page.prodi.create', compact('fakultas', 'dosen'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->canCrud('prodi')) {
            abort(403, 'Unauthorized action.');
        }


        $request->validate([
            'id_fakultas' => 'required|exists:fakultas,id',
            'nama_prodi' => 'required|string|max:255',
            'jenjang' => 'nullable|string|max:50',
            'ketua_prodi' => 'nullable|exists:dosen,id',
            'deskripsi' => 'nullable|string',
        ]);

        Prodi::create($request->all());
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil ditambahkan.');
    }

    public function edit($id)
    {
        if (!Auth::user()->canCrud('prodi')) {
            abort(403, 'Unauthorized action.');
        }

        $prodi = Prodi::findOrFail($id);
        $fakultas = Fakultas::all();
        $dosen = Dosen::all();
        return view('page.prodi.edit', compact('prodi', 'fakultas', 'dosen'));
    }

    public function update(Request $request, $id)
    {
        if (!Auth::user()->canCrud('prodi')) {
            abort(403, 'Unauthorized action.');
        }

        try {
            $request->validate([
                'id_fakultas' => 'required|exists:fakultas,id', // PERBAIKAN: exists:fakultas,id
                'nama_prodi' => 'required|string|max:255',
                'jenjang' => 'nullable|string|max:50',
                'ketua_prodi' => 'nullable|exists:dosen,id',
                'deskripsi' => 'nullable|string',
            ]);

            $prodi = Prodi::findOrFail($id);
            $prodi->update($request->all());

            return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    // App/Http/Controllers/ProdiController.php
    public function destroy($id)
    {
        if (!Auth::user()->canCrud('prodi')) {
            abort(403, 'Unauthorized action.');
        }

        $prodi = Prodi::withCount('dokumenMahasiswa')->findOrFail($id);

        // Cek apakah prodi memiliki dokumen mahasiswa
        if ($prodi->dokumen_mahasiswa_count > 0) {
            return redirect()->route('prodi.index')
                ->with('error', 'Tidak dapat menghapus program studi karena terdapat ' .
                    $prodi->dokumen_mahasiswa_count . ' data mahasiswa terkait. ' .
                    'Harap hapus atau pindahkan data mahasiswa terlebih dahulu.');
        }

        $prodi->delete();
        return redirect()->route('prodi.index')->with('success', 'Data program studi berhasil dihapus.');
    }
}
