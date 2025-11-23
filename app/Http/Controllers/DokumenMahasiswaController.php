<?php

namespace App\Http\Controllers;

use App\Exports\TemplateMahasiswaExport;
use App\Imports\DokumenMahasiswaImport;
use App\Models\DokumenMahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DokumenMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        // ✅ PERBAIKI: Gunakan hasPermission() untuk view-only access
        if (!Auth::user()->hasPermission('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $query = DokumenMahasiswa::with(['prodi.fakultas']);

        // Filter pencarian
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nim', 'like', "%{$search}%")
                    ->orWhere('nama_lengkap', 'like', "%{$search}%");
            });
        }

        // Filter prodi
        if ($request->has('prodi_id') && $request->prodi_id != '') {
            $query->where('prodi_id', $request->prodi_id);
        }

        // Filter status mahasiswa
        if ($request->has('status_mahasiswa') && $request->status_mahasiswa != '') {
            $query->where('status_mahasiswa', $request->status_mahasiswa);
        }

        $dokumenMahasiswa = $query->latest()->paginate(10);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.dokumen-mahasiswa.index', compact('dokumenMahasiswa', 'prodi'));
    }

    public function create()
    {
        // ✅ BENAR: Gunakan canCrud() untuk create
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $prodi = Prodi::with('fakultas')->get();
        return view('page.dokumen-mahasiswa.create', compact('prodi'));
    }
    public function store(Request $request)
    {
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $currentYear = date('Y');

        $request->validate([
            'nim' => 'required|string|max:20|unique:dokumen_mahasiswa,nim',
            'nama_lengkap' => 'required|string|max:255',
            'prodi_id' => 'required|exists:prodi,id',
            'tahun_masuk' => 'required|integer|min:2000|max:' . ($currentYear + 1),
            'tahun_keluar' => 'nullable|integer|min:2000|max:' . ($currentYear + 1), // Diperbaiki
            'status_mahasiswa' => 'required|in:Aktif,Lulus,Cuti,Drop Out',
            'file_ijazah' => 'nullable|file|mimes:pdf|max:5120',
            'file_transkrip' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        try {
            $data = $request->only([
                'nim',
                'nama_lengkap',
                'prodi_id',
                'tahun_masuk',
                'status_mahasiswa'
            ]);

            // Handle tahun_keluar - hanya diisi jika status Lulus
            if ($request->status_mahasiswa === 'Lulus' && $request->tahun_keluar) {
                $data['tahun_keluar'] = $request->tahun_keluar;
            }

            // Upload file logic...
            if ($request->hasFile('file_ijazah')) {
                $fileIjazah = $request->file('file_ijazah');
                $fileNameIjazah = 'ijazah_' . $request->nim . '_' . time() . '.' . $fileIjazah->getClientOriginalExtension();

                if (!file_exists(public_path('dokumen_mahasiswa/ijazah'))) {
                    mkdir(public_path('dokumen_mahasiswa/ijazah'), 0755, true);
                }

                $fileIjazah->move(public_path('dokumen_mahasiswa/ijazah'), $fileNameIjazah);
                $data['file_ijazah'] = 'dokumen_mahasiswa/ijazah/' . $fileNameIjazah;
            }

            if ($request->hasFile('file_transkrip')) {
                $fileTranskrip = $request->file('file_transkrip');
                $fileNameTranskrip = 'transkrip_' . $request->nim . '_' . time() . '.' . $fileTranskrip->getClientOriginalExtension();

                if (!file_exists(public_path('dokumen_mahasiswa/transkrip'))) {
                    mkdir(public_path('dokumen_mahasiswa/transkrip'), 0755, true);
                }

                $fileTranskrip->move(public_path('dokumen_mahasiswa/transkrip'), $fileNameTranskrip);
                $data['file_transkrip'] = 'dokumen_mahasiswa/transkrip/' . $fileNameTranskrip;
            }

            DokumenMahasiswa::create($data);

            return redirect()->route('dokumen-mahasiswa.index')
                ->with('success', 'Data dokumen mahasiswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show($id)
    {
        // ✅ BENAR: Gunakan hasPermission() untuk view-only
        if (!Auth::user()->hasPermission('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $dokumenMahasiswa = DokumenMahasiswa::with('prodi.fakultas')->findOrFail($id);
        return view('page.dokumen-mahasiswa.show', compact('dokumenMahasiswa'));
    }

    public function edit($id)
    {
        // ✅ BENAR: Gunakan canCrud() untuk edit
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $dokumen = DokumenMahasiswa::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dokumen-mahasiswa.edit', compact('dokumen', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        // ✅ BENAR: Gunakan canCrud() untuk update
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $dokumen = DokumenMahasiswa::findOrFail($id);

        $request->validate([
            'nim' => 'required|unique:dokumen_mahasiswa,nim,' . $id . '|max:20',
            'nama_lengkap' => 'required|max:255',
            'prodi_id' => 'required|exists:prodi,id',
            'tahun_masuk' => 'required|digits:4|integer|min:2000|max:' . (date('Y') + 1),
            'tahun_keluar' => 'nullable|digits:4|integer|min:2000|max:' . (date('Y') + 5),
            'status_mahasiswa' => 'required|in:Aktif,Lulus,Cuti,Drop Out',
            'file_ijazah' => 'nullable|file|mimes:pdf|max:5120',
            'file_transkrip' => 'nullable|file|mimes:pdf|max:5120',
        ]);

        try {
            $data = $request->only([
                'nim',
                'nama_lengkap',
                'prodi_id',
                'tahun_masuk',
                'tahun_keluar',
                'status_mahasiswa'
            ]);

            // Upload file ijazah baru ke public folder
            if ($request->hasFile('file_ijazah')) {
                // Hapus file lama
                if ($dokumen->file_ijazah && file_exists(public_path('dokumen_mahasiswa/ijazah/' . $dokumen->file_ijazah))) {
                    unlink(public_path('dokumen_mahasiswa/ijazah/' . $dokumen->file_ijazah));
                }

                $fileIjazah = $request->file('file_ijazah');
                $fileNameIjazah = 'ijazah_' . $request->nim . '_' . time() . '.' . $fileIjazah->getClientOriginalExtension();

                // Simpan di public/dokumen_mahasiswa/ijazah/
                $fileIjazah->move(public_path('dokumen_mahasiswa/ijazah'), $fileNameIjazah);
                $data['file_ijazah'] = $fileNameIjazah;
            }

            // Upload file transkrip baru ke public folder
            if ($request->hasFile('file_transkrip')) {
                // Hapus file lama
                if ($dokumen->file_transkrip && file_exists(public_path('dokumen_mahasiswa/transkrip/' . $dokumen->file_transkrip))) {
                    unlink(public_path('dokumen_mahasiswa/transkrip/' . $dokumen->file_transkrip));
                }

                $fileTranskrip = $request->file('file_transkrip');
                $fileNameTranskrip = 'transkrip_' . $request->nim . '_' . time() . '.' . $fileTranskrip->getClientOriginalExtension();

                // Simpan di public/dokumen_mahasiswa/transkrip/
                $fileTranskrip->move(public_path('dokumen_mahasiswa/transkrip'), $fileNameTranskrip);
                $data['file_transkrip'] = $fileNameTranskrip;
            }

            $dokumen->update($data);

            return redirect()->route('dokumen-mahasiswa.index')
                ->with('success', 'Data dokumen mahasiswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        // ✅ BENAR: Gunakan canCrud() untuk destroy
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $dokumen = DokumenMahasiswa::findOrFail($id);

        try {
            // Hapus file dari public folder
            if ($dokumen->file_ijazah && file_exists(public_path('dokumen_mahasiswa/ijazah/' . $dokumen->file_ijazah))) {
                unlink(public_path('dokumen_mahasiswa/ijazah/' . $dokumen->file_ijazah));
            }
            if ($dokumen->file_transkrip && file_exists(public_path('dokumen_mahasiswa/transkrip/' . $dokumen->file_transkrip))) {
                unlink(public_path('dokumen_mahasiswa/transkrip/' . $dokumen->file_transkrip));
            }

            $dokumen->delete();

            return redirect()->route('dokumen-mahasiswa.index')
                ->with('success', 'Data dokumen mahasiswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('dokumen-mahasiswa.index')
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function showImportForm()
    {
        // ✅ BENAR: Gunakan canCrud() untuk import form
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.dokumen-mahasiswa.import');
    }

    public function import(Request $request)
    {
        // ✅ BENAR: Gunakan canCrud() untuk import process
        if (!Auth::user()->canCrud('dokumen-mahasiswa')) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240' // max 10MB
        ]);

        try {
            Excel::import(new DokumenMahasiswaImport, $request->file('file'));

            return redirect()->route('dokumen-mahasiswa.index')
                ->with('success', 'Data mahasiswa berhasil diimport!');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan dalam import data.')
                ->with('import_errors', $failures);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new TemplateMahasiswaExport, 'template_import_mahasiswa.xlsx');
    }
}
