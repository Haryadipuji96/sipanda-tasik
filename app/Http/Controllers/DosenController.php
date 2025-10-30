<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::with('prodi')->latest()->paginate(10);
        return view('page.dosen.index', compact('dosen'));
    }

    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dosen.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|max:20|unique:dosen,nik',
            'pendidikan_terakhir' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'tmt_kerja' => 'required|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'golongan' => 'nullable|string|max:50',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except('file_dokumen');

        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen_dosen', $filename);
            $data['file_dokumen'] = $filename;
        }

        Dosen::create($data);
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $dosen = Dosen::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dosen.edit', compact('dosen', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'id_prodi' => 'required|exists:prodi,id_prodi',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'nik' => 'nullable|string|max:20|unique:dosen,nik,' . $dosen->id_dosen . ',id_dosen',
            'pendidikan_terakhir' => 'required|string|max:100',
            'jabatan' => 'required|string|max:100',
            'tmt_kerja' => 'required|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'golongan' => 'nullable|string|max:50',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except('file_dokumen');

        // 🔹 Hapus file lama jika upload baru
        if ($request->hasFile('file_dokumen')) {
            if ($dosen->file_dokumen && Storage::exists('public/dokumen_dosen/' . $dosen->file_dokumen)) {
                Storage::delete('public/dokumen_dosen/' . $dosen->file_dokumen);
            }

            $file = $request->file('file_dokumen');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->storeAs('public/dokumen_dosen', $filename);
            $data['file_dokumen'] = $filename;
        }

        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        if ($dosen->file_dokumen && Storage::exists('public/dokumen_dosen/' . $dosen->file_dokumen)) {
            Storage::delete('public/dokumen_dosen/' . $dosen->file_dokumen);
        }

        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }
}
