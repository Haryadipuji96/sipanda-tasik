<?php

namespace App\Http\Controllers;

use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class TenagaPendidikController extends Controller
{
    public function index(Request $request)
    {
        $query = TenagaPendidik::with('prodi.fakultas')->oldest();

        if ($search = $request->search) {
            $query->where('nama_tendik', 'like', "%{$search}%")
                ->orWhere('nip', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhereHas('prodi', function ($q) use ($search) {
                    $q->where('nama_prodi', 'like', "%{$search}%");
                });
        }

        $tenaga = $query->paginate(15);
        $prodi = Prodi::with('fakultas')->get();

        return view('page.tenaga_pendidik.index', compact('tenaga', 'prodi'));
    }

    public function create()
    {
        $prodi = Prodi::with('fakultas')->get();
        return view('page.tenaga_pendidik.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'nama_tendik' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'tmt_kerja' => 'nullable|date',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip',
            'status_kepegawaian' => 'required|in:PNS,Honorer,Kontrak',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|unique:tenaga_pendidik,no_hp',
            'email' => 'nullable|email|unique:tenaga_pendidik,email',
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        $data = $request->except(['file', 'golongan']);

        // Handle golongan history dinamis
        if ($request->filled('golongan') && is_array($request->golongan)) {
            $golonganArray = collect($request->golongan)
                ->filter(fn($item) => !empty($item['tahun']) || !empty($item['golongan']))
                ->values()
                ->toArray();

            $data['golongan_history'] = !empty($golonganArray) ? json_encode($golonganArray) : null;
        } else {
            $data['golongan_history'] = null;
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        TenagaPendidik::create($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function show($id)
    {
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);
        return view('page.tenaga_pendidik.show', compact('tenagaPendidik'));
    }

    public function edit($id)
    {
        $tenagaPendidik = TenagaPendidik::findOrFail($id);
        $prodi = Prodi::with('fakultas')->get();
        return view('page.tenaga_pendidik.edit', compact('tenagaPendidik', 'prodi'));
    }

    public function update(Request $request, $id)
    {
        $tenagaPendidik = TenagaPendidik::findOrFail($id);

        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'nama_tendik' => 'required|string|max:255',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'tempat_lahir' => 'nullable|string|max:100',
            'tanggal_lahir' => 'nullable|date',
            'tmt_kerja' => 'nullable|date',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip,' . $tenagaPendidik->id,
            'status_kepegawaian' => 'required|in:PNS,Honorer,Kontrak',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|unique:tenaga_pendidik,no_hp,' . $tenagaPendidik->id,
            'email' => 'nullable|email|unique:tenaga_pendidik,email,' . $tenagaPendidik->id,
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,jpg,png,doc,docx|max:2048',
        ]);

        $data = $request->except(['file', 'golongan']);

        // Handle golongan history dinamis
        if ($request->filled('golongan') && is_array($request->golongan)) {
            $golonganArray = collect($request->golongan)
                ->filter(fn($item) => !empty($item['tahun']) || !empty($item['golongan']))
                ->values()
                ->toArray();

            $data['golongan_history'] = !empty($golonganArray) ? json_encode($golonganArray) : null;
        } else {
            $data['golongan_history'] = null;
        }

        // Handle file upload
        if ($request->hasFile('file')) {
            if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
                unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
            }

            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        $tenagaPendidik->update($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $tenagaPendidik = TenagaPendidik::findOrFail($id);

        if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
            unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
        }

        $tenagaPendidik->delete();

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil dihapus.');
    }

    public function deleteSelected(Request $request)
    {
        $ids = $request->selected_tendik;

        if ($ids) {
            $items = TenagaPendidik::whereIn('id', $ids)->get();

            foreach ($items as $t) {
                if ($t->file && file_exists(public_path('dokumen_tendik/' . $t->file))) {
                    unlink(public_path('dokumen_tendik/' . $t->file));
                }
            }

            TenagaPendidik::whereIn('id', $ids)->delete();
        }

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data tenaga pendidik terpilih berhasil dihapus.');
    }

    // Preview PDF
    public function previewPDF($id)
    {
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);

        $pdf = PDF::loadView('page.tenaga_pendidik.pdf', compact('tenagaPendidik'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream('Data-Tendik-' . $tenagaPendidik->nama_tendik . '.pdf');
    }

    // Download PDF
    public function downloadPDF($id)
    {
        $tenagaPendidik = TenagaPendidik::with('prodi.fakultas')->findOrFail($id);

        $pdf = PDF::loadView('page.tenaga_pendidik.pdf', compact('tenagaPendidik'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Data-Tendik-' . $tenagaPendidik->nama_tendik . '.pdf');
    }
}
