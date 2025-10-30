<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Tambah Arsip Baru</h1>

        <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- 🔹 Kategori Arsip --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori Arsip <span class="text-red-500">*</span></label>
                <select name="id_kategori" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Kategori --</option>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🔹 Program Studi --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi (Opsional)</label>
                <select name="id_prodi" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Program Studi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id_prodi }}">
                            {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- 🔹 Dosen --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Dosen Terkait (Opsional)</label>
                <select name="id_dosen" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id_dosen }}">{{ $d->nama }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 🔹 Judul Dokumen --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                <input type="text" name="judul_dokumen" class="w-full border rounded px-3 py-2"
                       placeholder="Masukkan judul dokumen" required>
            </div>

            {{-- 🔹 Nomor & Tanggal Dokumen --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Nomor Dokumen</label>
                    <input type="text" name="nomor_dokumen" class="w-full border rounded px-3 py-2"
                           placeholder="Contoh: SK-001/IAIT/2025">
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Dokumen</label>
                    <input type="date" name="tanggal_dokumen" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            {{-- 🔹 Tahun --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Tahun Dokumen</label>
                <input type="text" name="tahun" class="w-full border rounded px-3 py-2"
                       placeholder="Contoh: 2025" maxlength="4">
            </div>

            {{-- 🔹 Upload File Dokumen --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Upload File Dokumen <span class="text-red-500">*</span></label>
                <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2"
                       accept=".pdf,.doc,.docx,.jpg,.png" required>
                <p class="text-gray-500 text-sm mt-1">
                    Format diizinkan: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>5MB</b>
                </p>
            </div>

            {{-- 🔹 Keterangan --}}
            <div class="mb-6">
                <label class="block font-medium mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2"
                          placeholder="Tambahkan catatan tambahan..."></textarea>
            </div>

            {{-- 🔹 Tombol Aksi --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('arsip.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                    Batal
                </a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</x-app-layout>
