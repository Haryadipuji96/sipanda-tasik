<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Edit Data Dosen</h1>

        <form action="{{ route('dosen.update', $dosen->id_dosen) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi</label>
                <select name="id_prodi" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id_prodi }}" {{ $p->id_prodi == $dosen->id_prodi ? 'selected' : '' }}>
                            {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Nama -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="{{ $dosen->nama }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <!-- Tempat & Tanggal Lahir -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Tempat Lahir</label>
                    <input type="text" name="tempat_lahir" value="{{ $dosen->tempat_lahir}}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" value="{{$dosen->tanggal_lahir}}" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            <!-- NIK -->
            <div class="mb-4">
                <label class="block font-medium mb-1">NIK</label>
                <input type="text" name="nik" value="{{$dosen->nik}}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Pendidikan Terakhir -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Pendidikan Terakhir</label>
                <input type="text" name="pendidikan_terakhir" value="{{$dosen->pendidikan_terakhir}}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Jabatan -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Jabatan</label>
                <input type="text" name="jabatan" value="{{$dosen->jabatan}}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- TMT Kerja -->
            <div class="mb-4">
                <label class="block font-medium mb-1">TMT Kerja</label>
                <input type="date" name="tmt_kerja" value="{{$dosen->tmt_kerja}}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Masa Kerja -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Masa Kerja (Tahun)</label>
                    <input type="number" name="masa_kerja_tahun" value="{{$dosen->masa_kerja_tahun}}" class="w-full border rounded px-3 py-2"
                        min="0">
                </div>
                <div>
                    <label class="block font-medium mb-1">Masa Kerja (Bulan)</label>
                    <input type="number" name="masa_kerja_bulan" value="{{$dosen->masa_kerja_bulan}}" class="w-full border rounded px-3 py-2" min="0"
                        max="11">
                </div>
            </div>

            <!-- Golongan -->
            <div class="mb-4">
                <label class="block font-medium mb-1">Golongan</label>
                <input type="text" name="golongan" value="{{$dosen->golongan}}" class="w-full border rounded px-3 py-2">
            </div>

            <!-- Masa Kerja Golongan -->
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Masa Kerja Golongan (Tahun)</label>
                    <input type="number" name="masa_kerja_golongan_tahun" value="{{$dosen->masa_kerja_golongan_tahun}}" class="w-full border rounded px-3 py-2"
                        min="0">
                </div>
                <div>
                    <label class="block font-medium mb-1">Masa Kerja Golongan (Bulan)</label>
                    <input type="number" name="masa_kerja_golongan_bulan" value="{{$dosen->masa_kerja_golongan_bulan}}" class="w-full border rounded px-3 py-2"
                        min="0" max="11">
                </div>
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">File Dokumen Saat Ini</label>
                @if ($dosen->file_dokumen)
                    <div class="flex items-center space-x-3">
                        <a href="{{ asset('storage/dokumen_dosen/' . $dosen->file_dokumen) }}" target="_blank"
                            class="text-blue-600 underline">
                            Lihat Dokumen
                        </a>
                        <span class="text-gray-500 text-sm">(akan diganti jika upload baru)</span>
                    </div>
                @else
                    <p class="text-gray-500 italic">Belum ada file.</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Upload File Dokumen Baru (opsional)</label>
                <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2">
            </div>

            <div class="flex justify-end space-x-2">
                <a href="{{ route('dosen.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>





