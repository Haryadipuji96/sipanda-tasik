<?php

namespace App\Http\Controllers;

use App\Models\DokumenMahasiswa;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DokumenMahasiswaController extends Controller
{
    public function index(Request $request)
    {
        $query = DokumenMahasiswa::with(['prodi.fakultas', 'superadminVerifikator']); // GANTI DI SINI

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

        // Filter status verifikasi
        if ($request->has('status_verifikasi') && $request->status_verifikasi != '') {
            $query->where('status_verifikasi', $request->status_verifikasi);
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
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dokumen-mahasiswa.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required|unique:dokumen_mahasiswa,nim|max:20',
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

            // Upload file ijazah ke public folder
            if ($request->hasFile('file_ijazah')) {
                $fileIjazah = $request->file('file_ijazah');
                $fileNameIjazah = 'ijazah_' . $request->nim . '_' . time() . '.' . $fileIjazah->getClientOriginalExtension();

                // Simpan di public/dokumen_mahasiswa/ijazah/
                $fileIjazah->move(public_path('dokumen_mahasiswa/ijazah'), $fileNameIjazah);
                $data['file_ijazah'] = $fileNameIjazah;
            }

            // Upload file transkrip ke public folder
            if ($request->hasFile('file_transkrip')) {
                $fileTranskrip = $request->file('file_transkrip');
                $fileNameTranskrip = 'transkrip_' . $request->nim . '_' . time() . '.' . $fileTranskrip->getClientOriginalExtension();

                // Simpan di public/dokumen_mahasiswa/transkrip/
                $fileTranskrip->move(public_path('dokumen_mahasiswa/transkrip'), $fileNameTranskrip);
                $data['file_transkrip'] = $fileNameTranskrip;
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

    public function edit($id)
    {
        $dokumen = DokumenMahasiswa::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        return view('page.dokumen-mahasiswa.edit', compact('dokumen', 'prodi'));
    }

    public function update(Request $request, $id)
    {
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

    // Method untuk verifikasi dokumen
    public function verifikasi(Request $request, $id)
    {
        $dokumen = DokumenMahasiswa::findOrFail($id);

        $request->validate([
            'status_verifikasi' => 'required|in:Terverifikasi,Ditolak',
            'catatan_verifikasi' => 'required_if:status_verifikasi,Ditolak|nullable|string',
        ]);

        try {
            $dokumen->update([
                'status_verifikasi' => $request->status_verifikasi,
                'catatan_verifikasi' => $request->catatan_verifikasi,
                'superadmin_verifikator_id' => auth()->id(), // GANTI JADI SUPERADMIN
                'tanggal_verifikasi' => now(),
            ]);

            $status = $request->status_verifikasi == 'Terverifikasi' ? 'diverifikasi' : 'ditolak';
            return redirect()->route('dokumen-mahasiswa.index')
                ->with('success', "Dokumen mahasiswa berhasil {$status}!");
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
