<?php

namespace App\Http\Controllers;

use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Illuminate\Http\Request;

class TenagaPendidikController extends Controller
{
    public function index(Request $request)
    {
        $query = TenagaPendidik::with('prodi')->oldest();

        if ($search = $request->search) {
            $query->where('nama_tendik', 'like', "%{$search}%")
                ->orWhere('jabatan', 'like', "%{$search}%")
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
        $prodi = Prodi::all();
        return view('page.tenaga_pendidik.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'nama_tendik' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip',
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'required|in:PNS,Honorer,Kontrak',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|max:20|unique:tenaga_pendidik,no_hp',
            'email' => 'nullable|email|unique:tenaga_pendidik,email',
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('file');

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        TenagaPendidik::create($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, TenagaPendidik $tenagaPendidik)
    {
        $request->validate([
            'id_prodi' => 'required|exists:prodi,id',
            'nama_tendik' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50|unique:tenaga_pendidik,nip,' . $tenagaPendidik->id,
            'jabatan' => 'nullable|string|max:100',
            'status_kepegawaian' => 'required|in:PNS,Honorer,Kontrak',
            'pendidikan_terakhir' => 'nullable|string|max:100',
            'jenis_kelamin' => 'required|in:laki-laki,perempuan',
            'no_hp' => 'nullable|string|max:20|unique:tenaga_pendidik,no_hp,' . $tenagaPendidik->id,
            'email' => 'nullable|email|unique:tenaga_pendidik,email,' . $tenagaPendidik->id,
            'alamat' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string|max:255',
            'file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = $request->except('file');

        // 🔹 Update file jika diupload
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
                unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
            }

            // Upload file baru
            $file = $request->file('file');
            $filename = now()->format('YmdHis') . '-Tendik.' . $file->getClientOriginalExtension();
            $file->move(public_path('dokumen_tendik'), $filename);
            $data['file'] = $filename;
        }

        $tenagaPendidik->update($data);

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy(TenagaPendidik $tenagaPendidik)
    {
        if ($tenagaPendidik->file && file_exists(public_path('dokumen_tendik/' . $tenagaPendidik->file))) {
            unlink(public_path('dokumen_tendik/' . $tenagaPendidik->file));
        }

        $tenagaPendidik->delete();

        return redirect()->route('tenaga-pendidik.index')->with('success', 'Data berhasil dihapus.');
    }

    public function show(TenagaPendidik $tenagaPendidik)
    {
        return view('page.tenaga_pendidik.show', compact('tenagaPendidik'));
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
}
