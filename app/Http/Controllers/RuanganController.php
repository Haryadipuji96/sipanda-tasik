<?php

namespace App\Http\Controllers;

use App\Models\DataSarpras;
use App\Models\Ruangan;
use App\Models\Fakultas;
use App\Models\Prodi;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Auth;

class RuanganController extends Controller
{
    public function index(Request $request)
    {
        if (!Auth::user()->hasPermission('ruangan')) {
            abort(403, 'Unauthorized action.');
        }


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

        // Filter by tipe ruangan - DIUBAH
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
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $fakultas = Fakultas::all();
        $prodi = Prodi::whereNotNull('id_fakultas')->with('fakultas')->get();

        return view('page.ruangan.create', compact('fakultas', 'prodi'));
    }

    public function createSarana() // DIUBAH
    {
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $fakultas = Fakultas::all();
        $prodi = Prodi::whereNotNull('id_fakultas')->with('fakultas')->get();

        return view('page.ruangan.create-sarana', compact('fakultas', 'prodi')); // DIUBAH
    }

    public function createPrasarana() // DIUBAH
    {

           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        return view('page.ruangan.create-prasarana'); // DIUBAH
    }

    public function store(Request $request)
    {
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi berdasarkan tipe ruangan - DIUBAH
        if ($request->tipe_ruangan === 'sarana') { // DIUBAH
            $request->validate([
                'tipe_ruangan' => 'required|in:sarana', // DIUBAH
                'id_fakultas' => 'required|exists:fakultas,id',
                'id_prodi' => 'required|exists:prodi,id',
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            ]);

            $data = [
                'nama_ruangan' => $request->nama_ruangan,
                'kondisi_ruangan' => 'Baik',
                'tipe_ruangan' => 'sarana', // DIUBAH
                'id_prodi' => $request->id_prodi,
                'unit_prasarana' => null, // DIUBAH
            ];
        } else {
            $request->validate([
                'tipe_ruangan' => 'required|in:prasarana', // DIUBAH
                'unit_prasarana' => 'required|string|max:255', // DIUBAH
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan',
            ]);

            // Jika memilih Lainnya, gunakan nilai dari unit_lainnya
            $unitPrasarana = $request->unit_prasarana; // DIUBAH
            if ($request->unit_prasarana === 'Lainnya' && $request->unit_lainnya) { // DIUBAH
                $unitPrasarana = $request->unit_lainnya;
            }

            $data = [
                'nama_ruangan' => $request->nama_ruangan,
                'kondisi_ruangan' => 'Baik',
                'tipe_ruangan' => 'prasarana', // DIUBAH
                'id_prodi' => null,
                'unit_prasarana' => $unitPrasarana, // DIUBAH
            ];
        }

        Ruangan::create($data);

        return redirect()->route('ruangan.index')
            ->with('success', 'Data ruangan berhasil ditambahkan.');
    }

    public function show($id)
    {
        if (!Auth::user()->hasPermission('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($id);
        return view('page.ruangan.show', compact('ruangan'));
    }

    public function edit(Ruangan $ruangan) // PERBAIKAN: Route model binding
    {
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $ruangan->load(['prodi.fakultas']);
        $fakultas = Fakultas::all();
        $prodi = Prodi::with('fakultas')->get();

        return view('page.ruangan.edit', compact('ruangan', 'fakultas', 'prodi'));
    }

    public function update(Request $request, Ruangan $ruangan) // PERBAIKAN: Route model binding
    {
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi berdasarkan tipe ruangan
        if ($ruangan->tipe_ruangan == 'sarana') {
            $request->validate([
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id,
                'id_prodi' => 'required|exists:prodi,id',
                'kondisi_ruangan' => 'required|string|max:255',
            ]);
        } else {
            $request->validate([
                'nama_ruangan' => 'required|string|max:255|unique:ruangan,nama_ruangan,' . $ruangan->id,
                'unit_prasarana' => 'required|string|max:255',
                'kondisi_ruangan' => 'required|string|max:255',
            ]);
        }

        try {
            // Update data dasar
            $updateData = [
                'nama_ruangan' => $request->nama_ruangan,
                'kondisi_ruangan' => $request->kondisi_ruangan,
            ];

            // Update field berdasarkan tipe ruangan
            if ($ruangan->tipe_ruangan == 'sarana') {
                $updateData['id_prodi'] = $request->id_prodi;
                $updateData['unit_prasarana'] = null;
            } else {
                $updateData['unit_prasarana'] = $request->unit_prasarana;
                $updateData['id_prodi'] = null;
            }

            $ruangan->update($updateData);

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
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

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
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $ids = $request->selected_ruangan;
        $forceDelete = $request->force_delete ?? false;

        if ($ids) {
            // Cek apakah ada ruangan yang digunakan
            $usedRooms = Ruangan::whereIn('id', $ids)
                ->whereHas('sarpras')
                ->withCount('sarpras')
                ->get();

            if ($usedRooms->count() > 0 && !$forceDelete) {
                $roomNames = $usedRooms->pluck('nama_ruangan')->implode(', ');
                $totalItems = $usedRooms->sum('sarpras_count');

                return redirect()->route('ruangan.index')
                    ->with(
                        'warning',
                        $usedRooms->count() . ' ruangan memiliki data barang sarpras: ' .
                            $roomNames . ' (total ' . $totalItems . ' barang). ' .
                            'Hapus barang terlebih dahulu atau gunakan opsi hapus paksa.'
                    );
            }

            // Jika force delete, hapus juga data sarpras nya
            if ($forceDelete) {
                foreach ($ids as $id) {
                    $ruangan = Ruangan::with('sarpras')->find($id);
                    if ($ruangan) {
                        // Hapus semua barang di ruangan tersebut
                        $ruangan->sarpras()->delete();
                        $ruangan->delete();
                    }
                }
            } else {
                // Hapus hanya ruangan yang tidak punya barang
                Ruangan::whereIn('id', $ids)->whereDoesntHave('sarpras')->delete();
            }

            $deletedCount = Ruangan::whereIn('id', $ids)->count();

            return redirect()->route('ruangan.index')
                ->with(
                    'success',
                    ($forceDelete ? 'Data ruangan dan barang terkait berhasil dihapus paksa.' : 'Data ruangan terpilih berhasil dihapus.') .
                        ' (' . $deletedCount . ' data dihapus)'
                );
        }

        return redirect()->route('ruangan.index')
            ->with('error', 'Tidak ada data yang dipilih untuk dihapus.');
    }

    public function checkUsedRooms(Request $request)
    {
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $roomIds = $request->room_ids;

        $usedRooms = Ruangan::whereIn('id', $roomIds)
            ->whereHas('sarpras')
            ->withCount('sarpras')
            ->get();

        return response()->json([
            'has_used_rooms' => $usedRooms->count() > 0,
            'used_rooms' => $usedRooms->pluck('nama_ruangan')->toArray(),
            'total_items' => $usedRooms->sum('sarpras_count')
        ]);
    }

    public function getProdiByFakultas($id_fakultas)
    {
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

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
           if (!Auth::user()->canCrud('ruangan')) {
            abort(403, 'Unauthorized action.');
        }

        $ruangan = Ruangan::where('id_prodi', $id_prodi)
            ->get(['id', 'nama_ruangan']);

        return response()->json($ruangan);
    }

    public function showBarang($ruanganId, $barangId)
    {
        // Find the ruangan
        $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($ruanganId);

        // Find the barang and ensure it belongs to the ruangan
        $barang = DataSarpras::where('id', $barangId)
            ->where('ruangan_id', $ruanganId)
            ->firstOrFail();

        // Return view detail (bukan show)
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

            // HANDLE FILE UPLOAD KE PUBLIC
            if ($request->hasFile('file_dokumen')) {
                // Hapus file lama jika ada
                if ($barang->file_dokumen) {
                    $oldFilePath = public_path('dokumen_sarpras/' . $barang->file_dokumen);
                    if (file_exists($oldFilePath)) {
                        unlink($oldFilePath);
                    }
                }

                $file = $request->file('file_dokumen');

                // Generate unique filename
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                // Pastikan folder public/dokumen_sarpras ada
                $folderPath = public_path('dokumen_sarpras');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                // Pindahkan file ke public/dokumen_sarpras
                $file->move($folderPath, $fileName);

                $data['file_dokumen'] = $fileName;

                \Log::info("File updated: {$fileName} to public/dokumen_sarpras/");
            }

            $barang->update($data);

            return redirect()->route('ruangan.show', $ruanganId)
                ->with('success', 'Data barang berhasil diperbarui!');
        } catch (\Exception $e) {
            \Log::error('Error updateBarang: ' . $e->getMessage());
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
            // Hapus file dokumen dari public jika ada
            if ($barang->file_dokumen) {
                $filePath = public_path('dokumen_sarpras/' . $barang->file_dokumen);
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $barang->delete();

            return redirect()->route('ruangan.show', $ruanganId)
                ->with('success', 'Barang berhasil dihapus!');
        } catch (\Exception $e) {
            \Log::error('Error destroyBarang: ' . $e->getMessage());
            return redirect()->route('ruangan.show', $ruanganId)
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function tambahBarang($ruanganId)
    {
        $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($ruanganId);
        return view('page.ruangan.tambah-barang', compact('ruangan'));
    }

    public function simpanBarang(Request $request, $ruanganId)
    {
        $ruangan = Ruangan::findOrFail($ruanganId);

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
                'ruangan_id' => $ruanganId,
            ];

            // HANDLE FILE UPLOAD KE PUBLIC
            if ($request->hasFile('file_dokumen')) {
                $file = $request->file('file_dokumen');

                // Generate unique filename
                $fileName = time() . '_' . str_replace(' ', '_', $file->getClientOriginalName());

                // Pastikan folder public/dokumen_sarpras ada
                $folderPath = public_path('dokumen_sarpras');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0755, true);
                }

                // Pindahkan file ke public/dokumen_sarpras
                $file->move($folderPath, $fileName);

                $data['file_dokumen'] = $fileName;

                \Log::info("File uploaded: {$fileName} to public/dokumen_sarpras/");
            }

            DataSarpras::create($data);

            // Cek apakah user ingin tambah lagi atau tidak
            if ($request->has('add_another')) {
                return redirect()->route('ruangan.tambah-barang', $ruanganId)
                    ->with('success', 'Barang berhasil ditambahkan! Silakan tambah barang lainnya.');
            }

            return redirect()->route('ruangan.show', $ruanganId)
                ->with('success', 'Barang berhasil ditambahkan ke ruangan!');
        } catch (\Exception $e) {
            \Log::error('Error simpanBarang: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage())
                ->withInput();
        }
    }
}
