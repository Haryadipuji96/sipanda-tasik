<?php

namespace App\Http\Controllers;

use App\Models\TenagaPendidik;
use App\Models\Prodi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TenagaPendidikController extends Controller
{
    public function index()
    {
        $tenaga = TenagaPendidik::with('prodi')->latest()->get();
        return view('page.tenaga_pendidik.index', compact('tenaga'));
    }

    public function create()
    {
        $prodi = Prodi::all();
        return view('page.tenaga_pendidik.create', compact('prodi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_prodi'=>'required|exists:prodi,id_prodi',
            'nama_tendik'=>'required|string|max:255',
            'nip'=>'nullable|string|max:50',
            'jabatan'=>'nullable|string|max:100',
            'status_kepegawaian'=>'required|in:PNS,Honorer,Kontrak',
            'pendidikan_terakhir'=>'nullable|string|max:100',
            'jenis_kelamin'=>'required|in:laki-laki,perempuan',
            'no_hp'=>'nullable|string|max:20|unique:tenaga_pendidik,no_hp',
            'email'=>'nullable|email|unique:tenaga_pendidik,email',
            'alamat'=>'nullable|string|max:255',
            'keterangan'=>'nullable|string|max:255',
            'file'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('file')){
            $data['file'] = $request->file('file')->store('tenaga_pendidik','public');
        }

        TenagaPendidik::create($data);

        return redirect()->route('tenaga-pendidik.index')->with('success','Data berhasil ditambahkan.');
    }

    public function edit(TenagaPendidik $tenagaPendidik)
    {
        $prodi = Prodi::all();
        return view('page.tenaga_pendidik.edit', compact('tenagaPendidik','prodi'));
    }

    public function update(Request $request, TenagaPendidik $tenagaPendidik)
    {
        $request->validate([
            'id_prodi'=>'required|exists:prodi,id_prodi',
            'nama_tendik'=>'required|string|max:255',
            'nip'=>'nullable|string|max:50|unique:tenaga_pendidik,nip,'.$tenagaPendidik->id_tenaga_pendidik.',id_tenaga_pendidik',
            'jabatan'=>'nullable|string|max:100',
            'status_kepegawaian'=>'required|in:PNS,Honorer,Kontrak',
            'pendidikan_terakhir'=>'nullable|string|max:100',
            'jenis_kelamin'=>'required|in:laki-laki,perempuan',
            'no_hp'=>'nullable|string|max:20|unique:tenaga_pendidik,no_hp,'.$tenagaPendidik->id_tenaga_pendidik.',id_tenaga_pendidik',
            'email'=>'nullable|email|unique:tenaga_pendidik,email,'.$tenagaPendidik->id_tenaga_pendidik.',id_tenaga_pendidik',
            'alamat'=>'nullable|string|max:255',
            'keterangan'=>'nullable|string|max:255',
            'file'=>'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $data = $request->all();

        if($request->hasFile('file')){
            if($tenagaPendidik->file){
                Storage::disk('public')->delete($tenagaPendidik->file);
            }
            $data['file'] = $request->file('file')->store('tenaga_pendidik','public');
        }

        $tenagaPendidik->update($data);

        return redirect()->route('tenaga-pendidik.index')->with('success','Data berhasil diupdate.');
    }

    public function destroy(TenagaPendidik $tenagaPendidik)
    {
        if($tenagaPendidik->file){
            Storage::disk('public')->delete($tenagaPendidik->file);
        }
        $tenagaPendidik->delete();
        return redirect()->route('tenaga-pendidik.index')->with('success','Data berhasil dihapus.');
    }

    public function show(TenagaPendidik $tenagaPendidik)
    {
        return view('page.tenaga_pendidik.show', compact('tenagaPendidik'));
    }
}
