<?php

namespace App\Http\Controllers;

use App\Models\DataSarpras;
use App\Models\Ruangan;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use PDF;
use Storage;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        $query = Ruangan::with(['prodi.fakultas'])->latest();

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_ruangan', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%")
                            ->orWhereHas('fakultas', function ($q) use ($search) {
                                $q->where('nama_fakultas', 'like', "%{$search}%");
                            });
                    });
            });
        }

        // Filter by tipe ruangan
        if ($request->filled('tipe_ruangan')) {
            $query->where('tipe_ruangan', $request->tipe_ruangan);
        }

        // Filter by prodi
        if ($request->filled('prodi')) {
            $query->where('id_prodi', $request->prodi);
        }

        $ruangan = $query->paginate(15);
        $fakultas = Fakultas::all();
        $prodi = Prodi::with('fakultas')->get();

        return view('page.ruangan.index', compact('ruangan', 'fakultas', 'prodi'));
    }

    public function create()
    {
        $fakultas = Fakultas::all();
        $prodi = Prodi::whereNotNull('id_fakultas')->with('fakultas')->get();

        return view('page.ruangan.create', compact('fakultas', 'prodi'));
    }

    public function createAkademik()
    {
        $fakultas = Fakultas::all();
        $prodi = Prodi::whereNotNull('id_fakultas')->with('fakultas')->get();

        return view('page.ruangan.create-akademik', compact('fakultas', 'prodi'));
    }

    public function createUmum()
    {
        return view('page.ruangan.create-umum');
    }

    public function store(Request $request)
    {
        // Validasi berdasarkan tipe ruangan
        if ($request->tipe_ruangan === 'akademik') {
            $request->validate([
                'tipe_ruangan' => 'required|in:akademik',
                'id_fakultas' => 'required|exists:fakultas,id',
                'id_prodi' => 'required|exists:prodi,id',
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            ]);

            $data = [
                'nama_ruangan' => $request->nama_ruangan,
                'kondisi_ruangan' => 'Baik',
                'tipe_ruangan' => 'akademik',
                'id_prodi' => $request->id_prodi,
                'unit_umum' => null,
            ];
        } else {
            $request->validate([
                'tipe_ruangan' => 'required|in:umum',
                'unit_umum' => 'required|string|max:255',
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            ]);

            // Jika memilih Lainnya, gunakan nilai dari unit_lainnya
            $unitUmum = $request->unit_umum;
            if ($request->unit_umum === 'Lainnya' && $request->unit_lainnya) {
                $unitUmum = $request->unit_lainnya;
            }

            $data = [
                'nama_ruangan' => $request->nama_ruangan,
                'kondisi_ruangan' => 'Baik',
                'tipe_ruangan' => 'umum',
                'id_prodi' => null,
                'unit_umum' => $unitUmum,
            ];
        }

        Ruangan::create($data);

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function show($id)
    {
        $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($id);
        return view('page.ruangan.show', compact('ruangan'));
    }

    public function edit($id)
    {
        $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($id);
        $fakultas = Fakultas::all();
        $prodi = Prodi::all();

        return view('page.ruangan.edit', compact('ruangan', 'fakultas', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        $ruangan = Ruangan::findOrFail($id);

        // Validasi berdasarkan tipe ruangan
        if ($ruangan->tipe_ruangan == 'akademik') {
            $request->validate([
                'nama_ruangan' => 'required|string|max:255',
                'prodi_id' => 'required|exists:prodi,id',
                'kondisi_ruangan' => 'required|string|max:50',
                'keterangan' => 'nullable|string',
            ]);
        } else {
            $request->validate([
                'nama_ruangan' => 'required|string|max:255',
                'unit_umum' => 'required|string|max:255',
                'kondisi_ruangan' => 'required|string|max:50',
                'keterangan' => 'nullable|string',
            ]);
        }

        try {
            $ruangan->update([
                'nama_ruangan' => $request->nama_ruangan,
                'kondisi_ruangan' => $request->kondisi_ruangan,
                'keterangan' => $request->keterangan,
            ]);

            // Update prodi_id hanya untuk ruangan akademik
            if ($ruangan->tipe_ruangan == 'akademik') {
                $ruangan->update(['prodi_id' => $request->prodi_id]);
            } else {
                $ruangan->update(['unit_umum' => $request->unit_umum]);
            }

            return redirect()->route('ruangan.index')
                ->with('success', 'Data ruangan berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);

        // Cek apakah ruangan digunakan di data sarpras
        if ($ruangan->sarpras()->exists()) {
            return redirect()->route('ruangan.index')
                ->with('error', 'Ruangan tidak dapat dihapus karena sudah digunakan dalam data sarpras.');
        }

        $ruangan->delete();

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->selected_ruangan;

        if ($ids) {
            // Cek apakah ada ruangan yang digunakan
            $usedRooms = Ruangan::whereIn('id', $ids)
                ->whereHas('sarpras')
                ->count();

            if ($usedRooms > 0) {
                return redirect()->route('ruangan.index')
                    ->with('error', 'Beberapa ruangan tidak dapat dihapus karena sudah digunakan dalam data sarpras.');
            }

            Ruangan::whereIn('id', $ids)->delete();
        }

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan terpilih berhasil dihapus.');
    }

    public function getProdiByFakultas($id_fakultas)
    {
        try {
            \Log::info('getProdiByFakultas called with id:', ['id_fakultas' => $id_fakultas]);

            // Validasi input
            if (!is_numeric($id_fakultas)) {
                return response()->json(['error' => 'Invalid fakultas ID'], 400);
            }

            // Pastikan hanya mengambil prodi yang memiliki fakultas
            $prodi = Prodi::where('id_fakultas', $id_fakultas)
                ->whereNotNull('id_fakultas')
                ->get(['id', 'nama_prodi', 'jenjang']);

            \Log::info('Prodi found:', ['count' => $prodi->count()]);

            return response()->json($prodi);
        } catch (\Exception $e) {
            \Log::error('Error in getProdiByFakultas:', [
                'error' => $e->getMessage(),
                'id_fakultas' => $id_fakultas
            ]);

            return response()->json(['error' => 'Internal server error'], 500);
        }
    }

    public function getRuanganByProdi($id_prodi)
    {
        $ruangan = Ruangan::where('id_prodi', $id_prodi)
            ->get(['id', 'nama_ruangan']);

        return response()->json($ruangan);
    }

    public function showBarang($ruanganId, $barangId)
    {
        // Find the barang and ensure it belongs to the ruangan
        $barang = DataSarpras::where('id', $barangId)
            ->where('ruangan_id', $ruanganId)
            ->firstOrFail();

        $ruangan = Ruangan::findOrFail($ruanganId);

        return view('page.ruangan.detail', compact('barang', 'ruangan'));
    }

    public function downloadPdf($ruanganId)
    {
        $ruangan = Ruangan::with(['prodi.fakultas', 'sarpras'])->findOrFail($ruanganId);

        $data = [
            'namaRuangan' => $ruangan->nama_ruangan,
            'prodi' => $ruangan->prodi,
            'sarpras' => $ruangan->sarpras,
            'totalBarang' => $ruangan->sarpras->count(),
            'totalUnit' => $ruangan->sarpras->sum('jumlah'),
            'totalNilai' => $ruangan->sarpras->sum('harga'),
        ];

        $pdf = PDF::loadView('page.ruangan.pdf', $data);
        return $pdf->download('laporan-ruangan-' . $ruangan->nama_ruangan . '.pdf');
    }

    public function editBarang($ruanganId, $barangId)
    {
        $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($ruanganId);
        $barang = DataSarpras::where('id', $barangId)
            ->where('ruangan_id', $ruanganId)
            ->firstOrFail();

        return view('page.ruangan.edit-barang', compact('ruangan', 'barang'));
    }

    public function updateBarang(Request $request, $ruanganId, $barangId)
    {
        $barang = DataSarpras::where('id', $barangId)
            ->where('ruangan_id', $ruanganId)
            ->firstOrFail();

        $request->validate([
            'nama_barang' => 'required|string|max:255',
            'kategori_barang' => 'required|string|max:255',
            'merk_barang' => 'nullable|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'satuan' => 'required|string|max:50',
            'harga' => 'nullable|numeric|min:0',
            'kondisi' => 'required|string|max:50',
            'tanggal_pengadaan' => 'required|date',
            'sumber' => 'required|string|max:50',
            'kode_seri' => 'required|string|max:255',
            'lokasi_lain' => 'nullable|string|max:255',
            'spesifikasi' => 'required|string',
            'keterangan' => 'nullable|string',
            'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
        ]);

        try {
            $data = [
                'nama_barang' => $request->nama_barang,
                'kategori_barang' => $request->kategori_barang,
                'merk_barang' => $request->merk_barang,
                'jumlah' => $request->jumlah,
                'satuan' => $request->satuan,
                'harga' => $request->harga,
                'kondisi' => $request->kondisi,
                'tanggal_pengadaan' => $request->tanggal_pengadaan,
                'sumber' => $request->sumber,
                'kode_seri' => $request->kode_seri,
                'lokasi_lain' => $request->lokasi_lain,
                'spesifikasi' => $request->spesifikasi,
                'keterangan' => $request->keterangan,
            ];

            // Handle file upload
            if ($request->hasFile('file_dokumen')) {
                // Hapus file lama jika ada
                if ($barang->file_dokumen) {
                    Storage::disk('public')->delete('dokumen_sarpras/' . $barang->file_dokumen);
                }

                $file = $request->file('file_dokumen');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->storeAs('dokumen_sarpras', $fileName, 'public');
                $data['file_dokumen'] = $fileName;
            }

            $barang->update($data);

            return redirect()->route('ruangan.show', $ruanganId)
                ->with('success', 'Data barang berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroyBarang($ruanganId, $barangId)
    {
        $barang = DataSarpras::where('id', $barangId)
            ->where('ruangan_id', $ruanganId)
            ->firstOrFail();

        try {
            // Hapus file dokumen jika ada
            if ($barang->file_dokumen) {
                Storage::disk('public')->delete('dokumen_sarpras/' . $barang->file_dokumen);
            }

            $barang->delete();

            return redirect()->route('ruangan.show', $ruanganId)
                ->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->route('ruangan.show', $ruanganId)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
