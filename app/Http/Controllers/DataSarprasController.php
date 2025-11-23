<?php

// namespace App\Http\Controllers;

use App\Exports\SarprasExport;
use App\Models\DataSarpras;
use App\Models\Fakultas;
use App\Models\Prodi;
use App\Models\Ruangan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Excel;

// class DataSarprasController extends Controller
// {


//     public function index(Request $request)
//     {
      
//         $query = Ruangan::with(['prodi.fakultas'])
//             ->withCount(['sarpras as total_barang'])
//             ->withSum('sarpras as total_unit', 'jumlah')
//             ->withSum('sarpras as total_nilai', 'harga');

     
//         if ($request->filled('search')) {
//             $search = $request->search;
//             $query->where(function ($q) use ($search) {
//                 $q->where('nama_ruangan', 'like', "%{$search}%")
//                     ->orWhereHas('prodi', function ($q) use ($search) {
//                         $q->where('nama_prodi', 'like', "%{$search}%")
//                             ->orWhereHas('fakultas', function ($q) use ($search) {
//                                 $q->where('nama_fakultas', 'like', "%{$search}%");
//                             });
//                     });
//             });
//         }

  
//         if ($request->filled('kondisi')) {
//             $query->whereHas('sarpras', function ($q) use ($request) {
//                 $q->where('kondisi', $request->kondisi);
//             });
//         }

    
//         if ($request->filled('fakultas')) {
//             $query->whereHas('prodi.fakultas', function ($q) use ($request) {
//                 $q->where('id', $request->fakultas);
//             });
//         }


//         if ($request->filled('tipe_ruangan')) {
//             if ($request->tipe_ruangan == 'akademik') {
//                 $query->whereNotNull('id_prodi');
//             } elseif ($request->tipe_ruangan == 'umum') {
//                 $query->whereNull('id_prodi');
//             }
//         }

//         $ruangan = $query->paginate(15);
//         $fakultas = Fakultas::all();
//         $prodi = Prodi::with('fakultas')->get();

//         return view('page.sarpras.index', compact('ruangan', 'fakultas', 'prodi'));
//     }

//     public function previewHTML(Request $request)
//     {
//         $query = DataSarpras::with(['prodi.fakultas', 'ruangan'])->latest();
//         if ($request->filled('kondisi')) {
//             $query->where('kondisi', $request->kondisi);
//         }

    
//         if ($request->filled('fakultas')) {
//             $query->whereHas('prodi.fakultas', function ($q) use ($request) {
//                 $q->where('id', $request->fakultas);
//             });
//         }

    
//         if ($request->filled('search')) {
//             $search = $request->search;
//             $query->where(function ($q) use ($search) {
//                 $q->where('nama_barang', 'like', "%{$search}%")
//                     ->orWhere('kategori_barang', 'like', "%{$search}%")
//                     ->orWhere('nama_ruangan', 'like', "%{$search}%")
//                     ->orWhereHas('prodi', function ($q) use ($search) {
//                         $q->where('nama_prodi', 'like', "%{$search}%");
//                     });
//             });
//         }


//         if ($request->filled('unit_umum')) {
//             if ($request->unit_umum == 'Lainnya') {
//                 $query->whereHas('ruangan', function ($q) {
//                     $q->where('unit_umum', 'Lainnya')
//                         ->orWhereNotIn('unit_umum', ['Gedung Rektorat', 'Gedung Pascasarjana', 'Gedung Tarbiyah', 'Gedung Yayasan', 'Lainnya'])
//                         ->orWhereNull('unit_umum');
//                 });
//             } else {
//                 $query->whereHas('ruangan', function ($q) use ($request) {
//                     $q->where('unit_umum', $request->unit_umum);
//                 });
//             }
//         }

    
//         if ($request->filled('tipe_ruangan')) {
//             if ($request->tipe_ruangan == 'akademik') {
//                 $query->whereNotNull('id_prodi');
//             } elseif ($request->tipe_ruangan == 'umum') {
//                 $query->whereNull('id_prodi');
//             }
//         }

//         $sarpras = $query->get();
//         $kondisi = $request->kondisi;
//         $search = $request->search;
//         $fakultasId = $request->fakultas;
//         $unitUmum = $request->unit_umum;
//         $tipeRuangan = $request->tipe_ruangan;

//         return view('page.sarpras.preview_html', compact('sarpras', 'kondisi', 'search', 'fakultasId', 'unitUmum', 'tipeRuangan'));
//     }

//     public function laporanPDF(Request $request)
//     {
//         $query = DataSarpras::with(['prodi.fakultas', 'ruangan'])->oldest();

    
//         if ($request->filled('kondisi')) {
//             $query->where('kondisi', $request->kondisi);
//         }

    
//         if ($request->filled('fakultas')) {
//             $query->whereHas('prodi.fakultas', function ($q) use ($request) {
//                 $q->where('id', $request->fakultas);
//             });
//         }

    
//         if ($request->filled('search')) {
//             $search = $request->search;
//             $query->where(function ($q) use ($search) {
//                 $q->where('nama_barang', 'like', "%{$search}%")
//                     ->orWhere('kategori_barang', 'like', "%{$search}%")
//                     ->orWhere('nama_ruangan', 'like', "%{$search}%")
//                     ->orWhereHas('prodi', function ($q) use ($search) {
//                         $q->where('nama_prodi', 'like', "%{$search}%");
//                     });
//             });
//         }


//         if ($request->filled('unit_umum')) {
//             if ($request->unit_umum == 'Lainnya') {
//                 $query->whereHas('ruangan', function ($q) {
//                     $q->where('unit_umum', 'Lainnya')
//                         ->orWhereNotIn('unit_umum', ['Gedung Rektorat', 'Gedung Pascasarjana', 'Gedung Tarbiyah', 'Gedung Yayasan', 'Lainnya'])
//                         ->orWhereNull('unit_umum');
//                 });
//             } else {
//                 $query->whereHas('ruangan', function ($q) use ($request) {
//                     $q->where('unit_umum', $request->unit_umum);
//                 });
//             }
//         }

    
//         if ($request->filled('tipe_ruangan')) {
//             if ($request->tipe_ruangan == 'akademik') {
//                 $query->whereNotNull('id_prodi');
//             } elseif ($request->tipe_ruangan == 'umum') {
//                 $query->whereNull('id_prodi');
//             }
//         }

//         $sarpras = $query->get();

    
//         $dataPerRuangan = $sarpras->groupBy('ruangan_id')->filter(function ($items) {
//             return $items->isNotEmpty();
//         });

//         $kondisi = $request->kondisi;
//         $search = $request->search;
//         $fakultasId = $request->fakultas;
//         $unitUmum = $request->unit_umum;
//         $tipeRuangan = $request->tipe_ruangan;

//         $pdf = Pdf::loadView('page.sarpras.laporan_pdf', compact('dataPerRuangan', 'kondisi', 'search', 'fakultasId', 'unitUmum', 'tipeRuangan'))
//             ->setPaper('A4', 'portrait');

    
//         $kondisiLabel = $kondisi ? str_replace(' ', '_', $kondisi) : 'Semua_Kondisi';
//         $searchLabel = $search ? '_' . substr(str_replace(' ', '_', $search), 0, 20) : '';
//         $fakultasLabel = $fakultasId ? '_Fakultas_' . $fakultasId : '';
//         $unitUmumLabel = $unitUmum ? '_Unit_' . str_replace(' ', '_', $unitUmum) : '';
//         $tipeRuanganLabel = $tipeRuangan ? '_Tipe_' . $tipeRuangan : '';

//         $namaFile = 'Laporan_Sarpras_' . $kondisiLabel . $searchLabel . $fakultasLabel . $unitUmumLabel . $tipeRuanganLabel . '.pdf';

//         return $pdf->download($namaFile);
//     }


//     public function ruanganPDF($id)
//     {

//         $sarpras = DataSarpras::with(['prodi.fakultas', 'ruangan'])
//             ->where('ruangan_id', $id)
//             ->oldest()
//             ->get();

    
//         if ($sarpras->isEmpty()) {
//             return redirect()->back()->with('error', 'Tidak ada data sarpras untuk ruangan ini.');
//         }

    
//         $ruangan = $sarpras->first();
//         $namaRuangan = $ruangan->nama_ruangan;
//         $prodi = $ruangan->prodi;

    
//         $totalBarang = $sarpras->count();
//         $totalUnit = $sarpras->sum('jumlah');
//         $totalNilai = $sarpras->sum('harga');

//         $pdf = Pdf::loadView('page.sarpras.ruangan_pdf', compact('sarpras', 'namaRuangan', 'prodi', 'totalBarang', 'totalUnit', 'totalNilai'))
//             ->setPaper('A4', 'portrait');

//         $namaFile = 'Laporan_Sarpras_Ruangan_' . str_replace(' ', '_', $namaRuangan) . '.pdf';

//         return $pdf->download($namaFile);
//     }

//     public function create()
//     {
//         $fakultas = Fakultas::all();
//         $prodi = Prodi::with('fakultas')->get();

    
//         $ruanganAkademik = Ruangan::whereNotNull('id_prodi')
//             ->with(['prodi.fakultas'])
//             ->get();

    
//         $ruanganUmum = Ruangan::where(function ($query) {
//             $query->whereNull('id_prodi')
//                 ->orWhere('id_prodi', '');
//         })->get();

//         return view('page.sarpras.create', compact('fakultas', 'prodi', 'ruanganAkademik', 'ruanganUmum'));
//     }

//     public function store(Request $request)
//     {
//         $validated = $request->validate([
        
//             'id_ruangan' => 'nullable|exists:ruangan,id',

        
//             'id_fakultas_new' => 'nullable|exists:fakultas,id',
//             'id_prodi_new' => 'nullable|exists:prodi,id',
//             'nama_ruangan_new' => 'nullable|string|max:255',

        
//             'nama_barang' => 'required|string|max:255',
//             'harga' => 'nullable|numeric|min:0',
//             'merk_barang' => 'nullable|string|max:100',
//             'jumlah' => 'required|integer|min:1',
//             'satuan' => 'required|string|max:50',
//             'kategori_barang' => 'required|string|max:100',
//             'kondisi' => 'required|string|max:50',
//             'tanggal_pengadaan' => 'required|date',
//             'spesifikasi' => 'required|string',
//             'kode_seri' => 'required|string|max:100',
//             'sumber' => 'required|in:HIBAH,LEMBAGA,YAYASAN',
//             'keterangan' => 'nullable|string|max:255',
//             'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
//             'lokasi_lain' => 'nullable|string|max:255',
//         ]);

//         $data = [
//             'nama_barang' => $validated['nama_barang'],
//             'harga' => $validated['harga'],
//             'merk_barang' => $validated['merk_barang'],
//             'jumlah' => $validated['jumlah'],
//             'satuan' => $validated['satuan'],
//             'kategori_barang' => $validated['kategori_barang'],
//             'kondisi' => $validated['kondisi'],
//             'tanggal_pengadaan' => $validated['tanggal_pengadaan'],
//             'spesifikasi' => $validated['spesifikasi'],
//             'kode_seri' => $validated['kode_seri'],
//             'sumber' => $validated['sumber'],
//             'keterangan' => $validated['keterangan'],
//             'lokasi_lain' => $validated['lokasi_lain'],
//         ];

//         try {
    
//             if ($request->ruangan_source === 'existing' && $request->id_ruangan) {
            
//                 $ruangan = Ruangan::find($request->id_ruangan);

//                 if (!$ruangan) {
//                     return redirect()->back()->with('error', 'Ruangan tidak ditemukan.');
//                 }

//                 $data['ruangan_id'] = $ruangan->id;
//                 $data['nama_ruangan'] = $ruangan->nama_ruangan;
//                 $data['id_prodi'] = $ruangan->id_prodi;
//             } else {
            
//                 if (empty($request->nama_ruangan_new)) {
//                     return redirect()->back()->with('error', 'Nama ruangan baru harus diisi.');
//                 }

            
//                 $ruanganBaru = Ruangan::create([
//                     'id_prodi' => $request->id_prodi_new,
//                     'nama_ruangan' => $request->nama_ruangan_new
//                 ]);

//                 $data['ruangan_id'] = $ruanganBaru->id;
//                 $data['nama_ruangan'] = $request->nama_ruangan_new;
//                 $data['id_prodi'] = $request->id_prodi_new;
//             }

        
//             if ($request->hasFile('file_dokumen')) {
            
//                 if (isset($sarpras) && $sarpras->file_dokumen) {
//                     if (file_exists(public_path('dokumen_sarpras/' . $sarpras->file_dokumen))) {
//                         unlink(public_path('dokumen_sarpras/' . $sarpras->file_dokumen));
//                     }
//                 }

//                 $file = $request->file('file_dokumen');
//                 $filename = 'sarpras_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            
//                 $file->move(public_path('dokumen_sarpras'), $filename);
//                 $data['file_dokumen'] = $filename;
//             }

//             DataSarpras::create($data);

//             return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil ditambahkan.');
//         } catch (\Exception $e) {
//             return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
//         }
//     }

//     public function update(Request $request, $id)
//     {
//         $sarpras = DataSarpras::findOrFail($id);

//         $validated = $request->validate([
//             'id_prodi' => 'required|exists:prodi,id',
//             'nama_ruangan' => 'required|string|max:255',
//             'nama_barang' => 'required|string|max:255',
//             'harga' => 'nullable|numeric|min:0',
//             'merk_barang' => 'nullable|string|max:100',
//             'jumlah' => 'required|integer|min:1',
//             'satuan' => 'required|string|max:50',
//             'kategori_barang' => 'required|string|max:100',
//             'kondisi' => 'required|string|max:50',
//             'tanggal_pengadaan' => 'required|date',
//             'spesifikasi' => 'required|string',
//             'kode_seri' => 'required|string|max:100',
//             'sumber' => 'required|in:HIBAH,LEMBAGA,YAYASAN',
//             'keterangan' => 'nullable|string|max:255',
//             'file_dokumen' => 'nullable|file|mimes:pdf,jpg,png|max:5120',
//             'lokasi_lain' => 'nullable|string|max:255',
//         ]);

//         $data = $validated;

    
//         if ($request->hasFile('file_dokumen')) {
        
//             if ($sarpras->file_dokumen) {
//                 Storage::disk('public')->delete('sarpras/dokumen/' . $sarpras->file_dokumen);
//             }

//             $file = $request->file('file_dokumen');
//             $filename = 'sarpras_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
//             $path = $file->storeAs('sarpras/dokumen', $filename, 'public');
//             $data['file_dokumen'] = $filename;
//         }

//         $sarpras->update($data);

//         return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil diperbarui.');
//     }

//     public function show($id)
//     {
//         $sarpras = DataSarpras::findOrFail($id);
//         return view('page.sarpras.show', compact('sarpras'));
//     }

//     public function destroy($id)
//     {
//         $sarpras = DataSarpras::findOrFail($id);
//         if ($sarpras->file_dokumen) {
//             $filePath = public_path('dokumen_sarpras/' . $sarpras->file_dokumen);
//             if (file_exists($filePath)) {
//                 unlink($filePath);
//             }
//         }
//         $sarpras->delete();
//         return redirect()->route('sarpras.index')->with('success', 'Data sarpras berhasil dihapus.');
//     }

//     public function deleteSelected(Request $request)
//     {
//         $ids = $request->selected_sarpras;
//         if ($ids) {
//             $sarpras = DataSarpras::whereIn('id', $ids)->get();
//             foreach ($sarpras as $s) {
//                 if ($s->file_dokumen) {
//                     $filePath = public_path('dokumen_sarpras/' . $s->file_dokumen);
//                     if (file_exists($filePath)) {
//                         unlink($filePath);
//                     }
//                 }
//             }
//             DataSarpras::whereIn('id', $ids)->delete();
//         }

//         return redirect()->route('sarpras.index')->with('success', 'Data sarpras terpilih berhasil dihapus.');
//     }

//     public function exportExcel(Request $request)
//     {
//         $search = $request->get('search', '');
//         $kondisi = $request->get('kondisi', '');

    
//         $excel = app('excel');

//         return $excel->download(
//             new SarprasExport($search, $kondisi),
//             'Data_Sarpras_' . date('Y-m-d_His') . '.xlsx'
//         );
//     }

//     public function showRuangan($id)
//     {
//         $ruangan = Ruangan::with(['sarpras', 'prodi.fakultas'])->findOrFail($id);

//         return view('page.ruangan.show', compact('ruangan'));
//     }


//     public function createFromRuangan($ruangan_id)
//     {
//         $ruangan = Ruangan::with(['prodi.fakultas'])->findOrFail($ruangan_id);

//         return view('page.sarpras.create_from_ruangan', compact('ruangan'));
//     }


//     public function storeFromRuangan(Request $request, $ruangan_id)
//     {
//         $ruangan = Ruangan::findOrFail($ruangan_id);

//         $validated = $request->validate([
//             'nama_barang' => 'required|string|max:255',
//             'kategori_barang' => 'required|string|max:100',
//             'merk_barang' => 'nullable|string|max:100',
//             'jumlah' => 'required|integer|min:1',
//             'satuan' => 'required|string|max:50',
//             'harga' => 'nullable|numeric|min:0',
//             'kondisi' => 'required|string|max:50',
//             'tanggal_pengadaan' => 'required|date',
//             'spesifikasi' => 'required|string',
//             'kode_seri' => 'required|string|max:100',
//             'sumber' => 'required|in:HIBAH,LEMBAGA,YAYASAN',
//             'keterangan' => 'nullable|string|max:255',
//             'file_dokumen' => 'nullable|file|mimes:pdf,doc,docx,jpg,png|max:5120',
//             'lokasi_lain' => 'nullable|string|max:255',
//         ]);


//         $validated['ruangan_id'] = $ruangan_id;
//         $validated['nama_ruangan'] = $ruangan->nama_ruangan;
//         $validated['id_prodi'] = $ruangan->id_prodi;


//         if ($request->hasFile('file_dokumen')) {
//             $file = $request->file('file_dokumen');
//             $filename = 'sarpras_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
//             $file->move(public_path('dokumen_sarpras'), $filename);
//             $validated['file_dokumen'] = $filename;
//         }

//         DataSarpras::create($validated);

    
//         if ($request->has('add_another')) {
//             return redirect()->route('ruangan.tambah-barang', $ruangan_id)
//                 ->with('success', 'Barang berhasil ditambahkan! Silakan tambah barang lainnya.');
//         }

//         return redirect()->route('ruangan.show', $ruangan_id)
//             ->with('success', 'Barang berhasil ditambahkan ke ruangan ' . $ruangan->nama_ruangan);
//     }
// }
