<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Tambah Data Sarpras</h1>

        <form action="{{ route('sarpras.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Prodi --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi (Opsional)</label>
                <select name="id_prodi" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id_prodi }}">{{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})</option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Barang --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Kategori & Kondisi --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Kategori</label>
                    <input type="text" name="kategori" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Kondisi</label>
                    <input type="text" name="kondisi" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            {{-- Jumlah & Tanggal Pengadaan --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="w-full border rounded px-3 py-2" min="1" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Pengadaan</label>
                    <input type="date" name="tanggal_pengadaan" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>

            {{-- Spesifikasi --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Spesifikasi Barang</label>
                <textarea name="spesifikasi" rows="3" class="w-full border rounded px-3 py-2" required></textarea>
            </div>

            {{-- Kode Seri & Sumber --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Kode / Seri Barang</label>
                    <input type="text" name="kode_seri" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Sumber Barang</label>
                    <select name="sumber" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Sumber --</option>
                        <option value="HIBAH">HIBAH</option>
                        <option value="LEMBAGA">LEMBAGA</option>
                        <option value="YAYASAN">YAYASAN</option>
                    </select>
                </div>
            </div>

            {{-- Lokasi Lain --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Lokasi Lain (Opsional)</label>
                <input type="text" name="lokasi_lain" class="w-full border rounded px-3 py-2" placeholder="Misal: Gedung C Lantai 2">
            </div>

            {{-- File Dokumen --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Upload File Dokumen</label>
                <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2" accept=".pdf,.jpg,.png">
                <small class="text-gray-500 text-sm">Format: PDF, JPG, PNG — Maksimal 2MB</small>
            </div>

            {{-- Keterangan --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('sarpras.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
