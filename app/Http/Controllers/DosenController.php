<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DosenExport;

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
            $pendidikanArray = array_filter($request->pendidikan, function ($item) {
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
            $pendidikanArray = array_filter($request->pendidikan, function ($item) {
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

    // ==========================================
    // EXPORT UNTUK SEMUA DATA DOSEN
    // ==========================================

    /**
     * Preview PDF - Tampilkan semua data dosen dalam format PDF
     */
    public function previewAllPdf(Request $request)
    {
        $query = Dosen::with(['prodi.fakultas']);

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan prodi jika ada
        if ($request->has('prodi') && $request->prodi != '') {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('nama_prodi', $request->prodi);
            });
        }

        // Filter berdasarkan sertifikasi jika ada
        if ($request->has('sertifikasi') && $request->sertifikasi != '') {
            $query->where('sertifikasi', $request->sertifikasi);
        }

        // Filter berdasarkan inpasing jika ada
        if ($request->has('inpasing') && $request->inpasing != '') {
            $query->where('inpasing', $request->inpasing);
        }

        $dosen = $query->orderBy('nama')->get();
        $prodi = Prodi::with('fakultas')->get(); // Untuk info filter

        return view('page.dosen.laporan.preview', compact('dosen', 'prodi'));
    }

    /**
     * Download PDF - Download semua data dosen dalam format PDF
     */
    public function downloadAllPdf(Request $request)
    {
        $query = Dosen::with(['prodi.fakultas']);

        // Filter berdasarkan pencarian jika ada
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('jabatan', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhereHas('prodi', function ($q) use ($search) {
                        $q->where('nama_prodi', 'like', "%{$search}%");
                    });
            });
        }

        // Filter berdasarkan prodi jika ada
        if ($request->has('prodi') && $request->prodi != '') {
            $query->whereHas('prodi', function ($q) use ($request) {
                $q->where('nama_prodi', $request->prodi);
            });
        }

        // Filter berdasarkan sertifikasi jika ada
        if ($request->has('sertifikasi') && $request->sertifikasi != '') {
            $query->where('sertifikasi', $request->sertifikasi);
        }

        // Filter berdasarkan inpasing jika ada
        if ($request->has('inpasing') && $request->inpasing != '') {
            $query->where('inpasing', $request->inpasing);
        }

        $dosen = $query->orderBy('nama')->get();

        $pdf = Pdf::loadView('page.dosen.pdf-preview', compact('dosen'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('Data_Dosen_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * Export ke Excel - Download data dosen dalam format Excel
     */
    // Di DosenController, ganti method exportExcel:

    /**
     * Export ke Excel - Download data dosen dalam format Excel
     */
    public function exportExcel(Request $request)
    {
        $search = $request->get('search', '');

        // Pilih salah satu:

        // Option 1: Export dengan kolom pendidikan horizontal
        return Excel::download(
            new DosenExport($search),
            'Data_Dosen_' . date('Y-m-d_His') . '.xlsx'
        );

        // Option 2: Export dengan multiple rows
        // return Excel::download(
        //     new DosenExportMultipleRows($search), 
        //     'Data_Dosen_Multiple_Rows_' . date('Y-m-d_His') . '.xlsx'
        // );
    }

    // Di DosenController, tambahkan method baru:

    /**
     * Preview PDF Single - Tampilkan 1 data dosen dalam format PDF (dari show)
     */
    public function previewPdfSingle($id)
    {
        $dosen = Dosen::with(['prodi.fakultas'])->findOrFail($id);

        // Generate PDF untuk single dosen
        $pdf = Pdf::loadView('page.dosen.pdf', compact('dosen'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Detail_Dosen_' . $dosen->nama . '.pdf');
    }

    /**
     * Download PDF Single - Download 1 data dosen dalam format PDF (dari show)
     */
    public function downloadPdfSingle($id)
    {
        $dosen = Dosen::with(['prodi.fakultas'])->findOrFail($id);

        // Generate dan download PDF untuk single dosen
        $pdf = Pdf::loadView('page.dosen.pdf', compact('dosen'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Detail_Dosen_' . $dosen->nama . '_' . date('Y-m-d_His') . '.pdf');
    }
}
