<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Tambah Dosen</h1>

        <form action="{{ route('dosen.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Program Studi -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi</label>
                <select name="id_prodi" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id_prodi }}">
                            {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <!-- NIK -->
            <div class="mb-4">
                <label class="block font-medium mb-1">NIK</label>
                <input type="text" name="nik" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Pendidikan Terakhir -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Jabatan -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Jabatan</label>
                <input type="text" name="jabatan" class="w-full border rounded px-3 py-2">
            </div>

            <!-- TMT Kerja -->
            <div class="mb-4">
                <label class="block font-medium mb-1">TMT Kerja</label>
                <input type="date" name="tmt_kerja" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Masa Kerja -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Masa Kerja (Tahun)</label>
                    <input type="number" name="masa_kerja_tahun" class="w-full border rounded px-3 py-2" min="0">
                </div>
                <div>
                    <label class="block font-medium mb-1">Masa Kerja (Bulan)</label>
                    <input type="number" name="masa_kerja_bulan" class="w-full border rounded px-3 py-2" min="0" max="11">
                </div>
            </div>

            <!-- Golongan -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Golongan</label>
                <input type="text" name="golongan" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Masa Kerja Golongan -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Masa Kerja Golongan (Tahun)</label>
                    <input type="number" name="masa_kerja_golongan_tahun" class="w-full border rounded px-3 py-2" min="0">
                </div>
                <div>
                    <label class="block font-medium mb-1">Masa Kerja Golongan (Bulan)</label>
                    <input type="number" name="masa_kerja_golongan_bulan" class="w-full border rounded px-3 py-2" min="0" max="11">
                </div>
            </div>

            <!-- Upload File Dokumen -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Upload File Dokumen (opsional)</label>
                <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Tombol Aksi -->
            <div class="flex justify-end space-x-2">
                <a href="{{ route('dosen.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
            </div>
        </form>
    </div>
</x-app-layout>
