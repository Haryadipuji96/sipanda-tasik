<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class DosenController extends Controller
{
    public function index(Request $request)
    {
        $query = Dosen::with('prodi.fakultas');

        if ($search = $request->search) {
            $query->where('nama', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%")
                ->orWhereHas('prodi', function ($q) use ($search) {
                    $q->where('nama_prodi', 'like', "%{$search}%");
                });
        }

        $dosen = $query->paginate(15);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.dosen.index', compact('dosen', 'prodi'));
    }

    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dosen.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nik' => 'nullable|string|max:20|unique:dosen,nik',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'tmt_kerja' => 'nullable|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'pangkat_golongan' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'no_sk' => 'nullable|string|max:100',
            'no_sk_jafung' => 'nullable|string|max:100',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'sertifikasi' => 'required|in:SUDAH,BELUM',
            'inpasing' => 'required|in:SUDAH,BELUM',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except(['file_dokumen', 'pendidikan']);

        // Handle pendidikan dinamis
        if ($request->has('pendidikan')) {
            $pendidikanArray = array_filter($request->pendidikan, function($item) {
                return !empty($item['jenjang']) || !empty($item['prodi']) || !empty($item['tahun_lulus']) || !empty($item['universitas']);
            });
            $data['pendidikan_data'] = json_encode(array_values($pendidikanArray));
        }

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $file = $request->file('file_dokumen');
            $filename = now()->format('YmdHis') . '-Dosen.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_dosen'), $filename);
            $data['file_dokumen'] = $filename;
        }

        Dosen::create($data);
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan.');
    }

    public function show($id)
    {
        $dosen = Dosen::with('prodi.fakultas')->findOrFail($id);
        return view('page.dosen.show', compact('dosen'));
    }

    public function update(Request $request, $id)
    {
        $dosen = Dosen::findOrFail($id);

        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'nama' => 'required|string|max:255',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'nik' => 'nullable|string|max:20|unique:dosen,nik,' . $dosen->id . ',id',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jabatan' => 'nullable|string|max:100',
            'tmt_kerja' => 'nullable|date',
            'masa_kerja_tahun' => 'nullable|integer|min:0',
            'masa_kerja_bulan' => 'nullable|integer|min:0|max:11',
            'pangkat_golongan' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'nullable|string|max:100',
            'no_sk' => 'nullable|string|max:100',
            'no_sk_jafung' => 'nullable|string|max:100',
            'masa_kerja_golongan_tahun' => 'nullable|integer|min:0',
            'masa_kerja_golongan_bulan' => 'nullable|integer|min:0|max:11',
            'sertifikasi' => 'required|in:SUDAH,BELUM',
            'inpasing' => 'required|in:SUDAH,BELUM',
            'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ]);

        $data = $request->except(['file_dokumen', 'pendidikan']);

        // Handle pendidikan dinamis
        if ($request->has('pendidikan')) {
            $pendidikanArray = array_filter($request->pendidikan, function($item) {
                return !empty($item['jenjang']) || !empty($item['prodi']) || !empty($item['tahun_lulus']) || !empty($item['universitas']);
            });
            $data['pendidikan_data'] = json_encode(array_values($pendidikanArray));
        }

        // Handle file upload
        if ($request->hasFile('file_dokumen')) {
            $oldFile = $dosen->file_dokumen;

            if ($oldFile && file_exists(public_path('dokumen_dosen/' . $oldFile))) {
                unlink(public_path('dokumen_dosen/' . $oldFile));
            }

            $file = $request->file('file_dokumen');
            $filename = now()->format('YmdHis') . '-Dosen.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_dosen'), $filename);

            $data['file_dokumen'] = $filename;
        }

        $dosen->update($data);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        $oldFile = public_path('dokumen_dosen/' . $dosen->file_dokumen);
        if ($dosen->file_dokumen && file_exists($oldFile)) {
            unlink($oldFile);
        }

        $dosen->delete();
        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->selected_dosen;
        if ($ids) {
            $dosens = Dosen::whereIn('id', $ids)->get();
            foreach ($dosens as $d) {
                if ($d->file_dokumen && file_exists(public_path('dokumen_dosen/' . $d->file_dokumen))) {
                    unlink(public_path('dokumen_dosen/' . $d->file_dokumen));
                }
            }
            Dosen::whereIn('id', $ids)->delete();
        }

        return redirect()->route('dosen.index')->with('success', 'Data dosen terpilih berhasil dihapus.');
    }

    // Preview PDF
    public function previewPDF($id)
    {
        $dosen = Dosen::with('prodi.fakultas')->findOrFail($id);
        $pdf = PDF::loadView('page.dosen.pdf', compact('dosen'));
        return $pdf->stream('Data-Dosen-' . $dosen->nama . '.pdf');
    }

    // Download PDF
    public function downloadPDF($id)
    {
        $dosen = Dosen::with('prodi.fakultas')->findOrFail($id);
        $pdf = PDF::loadView('page.dosen.pdf', compact('dosen'));
        return $pdf->download('Data-Dosen-' . $dosen->nama . '.pdf');
    }
}