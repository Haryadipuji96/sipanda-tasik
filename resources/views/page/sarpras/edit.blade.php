<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Edit Data Sarpras</h1>

        <form action="{{ route('sarpras.update', $sarpras) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            {{-- Prodi --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi (Opsional)</label>
                <select name="id_prodi" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id_prodi }}" {{ $sarpras->id_prodi == $p->id_prodi ? 'selected' : '' }}>
                            {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Nama Barang --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Nama Barang</label>
                <input type="text" name="nama_barang" class="w-full border rounded px-3 py-2"
                    value="{{ $sarpras->nama_barang }}" required>
            </div>

            {{-- Kategori & Kondisi --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Kategori</label>
                    <input type="text" name="kategori" class="w-full border rounded px-3 py-2"
                        value="{{ $sarpras->kategori }}" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Kondisi</label>
                    <input type="text" name="kondisi" class="w-full border rounded px-3 py-2"
                        value="{{ $sarpras->kondisi }}" required>
                </div>
            </div>

            {{-- Jumlah & Tanggal Pengadaan --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Jumlah Barang</label>
                    <input type="number" name="jumlah" class="w-full border rounded px-3 py-2"
                        value="{{ $sarpras->jumlah }}" min="1" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Pengadaan</label>
                    <input type="date" name="tanggal_pengadaan" class="w-full border rounded px-3 py-2"
                        value="{{ $sarpras->tanggal_pengadaan }}" required>
                </div>
            </div>

            {{-- Spesifikasi --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Spesifikasi Barang</label>
                <textarea name="spesifikasi" rows="3" class="w-full border rounded px-3 py-2" required>{{ $sarpras->spesifikasi }}</textarea>
            </div>

            {{-- Kode Seri & Sumber --}}
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block font-medium mb-1">Kode / Seri Barang</label>
                    <input type="text" name="kode_seri" class="w-full border rounded px-3 py-2"
                        value="{{ $sarpras->kode_seri }}" required>
                </div>
                <div>
                    <label class="block font-medium mb-1">Sumber Barang</label>
                    <select name="sumber" class="w-full border rounded px-3 py-2" required>
                        <option value="HIBAH" {{ $sarpras->sumber == 'HIBAH' ? 'selected' : '' }}>HIBAH</option>
                        <option value="LEMBAGA" {{ $sarpras->sumber == 'LEMBAGA' ? 'selected' : '' }}>LEMBAGA</option>
                        <option value="YAYASAN" {{ $sarpras->sumber == 'YAYASAN' ? 'selected' : '' }}>YAYASAN</option>
                    </select>
                </div>
            </div>

            {{-- Lokasi Lain --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Lokasi Lain (Opsional)</label>
                <input type="text" name="lokasi_lain" class="w-full border rounded px-3 py-2"
                    value="{{ $sarpras->lokasi_lain }}">
            </div>

            {{-- File Dokumen --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">File Dokumen</label>
                @if ($sarpras->file_dokumen)
                    <p class="text-sm mb-1">
                        File saat ini:
                        <a href="{{ asset('storage/sarpras/' . $sarpras->file_dokumen) }}" target="_blank"
                            class="text-blue-600 underline">
                            {{ $sarpras->file_dokumen }}
                        </a>
                    </p>
                @endif
                <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2"
                    accept=".pdf,.jpg,.png">
            </div>

            {{-- Keterangan --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2">{{ $sarpras->keterangan }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('sarpras.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
