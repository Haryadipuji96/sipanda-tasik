<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <h1 class="text-xl font-semibold mb-4">Edit Arsip</h1>

        <form action="{{ route('arsip.update', $arsip->id_arsip) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Kategori Arsip --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Kategori Arsip</label>
                <select name="id_kategori" class="w-full border rounded px-3 py-2" required>
                    @foreach ($kategori as $k)
                        <option value="{{ $k->id_kategori }}" {{ $k->id_kategori == $arsip->id_kategori ? 'selected' : '' }}>
                            {{ $k->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Prodi --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Program Studi</label>
                <select name="id_prodi" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Prodi --</option>
                    @foreach ($prodi as $p)
                        <option value="{{ $p->id_prodi }}" {{ $p->id_prodi == $arsip->id_prodi ? 'selected' : '' }}>
                            {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Dosen --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Dosen Terkait</label>
                <select name="id_dosen" class="w-full border rounded px-3 py-2">
                    <option value="">-- Pilih Dosen --</option>
                    @foreach ($dosen as $d)
                        <option value="{{ $d->id_dosen }}" {{ $d->id_dosen == $arsip->id_dosen ? 'selected' : '' }}>
                            {{ $d->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Judul --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Judul Dokumen</label>
                <input type="text" name="judul_dokumen" value="{{ $arsip->judul_dokumen }}" class="w-full border rounded px-3 py-2" required>
            </div>

            {{-- Nomor & Tanggal --}}
            <div class="mb-4 grid grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Nomor Dokumen</label>
                    <input type="text" name="nomor_dokumen" value="{{ $arsip->nomor_dokumen }}" class="w-full border rounded px-3 py-2">
                </div>
                <div>
                    <label class="block font-medium mb-1">Tanggal Dokumen</label>
                    <input type="date" name="tanggal_dokumen" value="{{ $arsip->tanggal_dokumen }}" class="w-full border rounded px-3 py-2">
                </div>
            </div>

            {{-- Tahun --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Tahun</label>
                <input type="text" name="tahun" value="{{ $arsip->tahun }}" class="w-full border rounded px-3 py-2">
            </div>

            {{-- File --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">File Dokumen Saat Ini</label>
                @if ($arsip->file_dokumen)
                    <a href="{{ asset('storage/arsip/' . $arsip->file_dokumen) }}" target="_blank" class="text-blue-600 underline">
                        {{ $arsip->file_dokumen }}
                    </a>
                    <p class="text-sm text-gray-500 mt-1">Upload file baru untuk mengganti yang lama.</p>
                @else
                    <p class="text-gray-500 italic">Belum ada file.</p>
                @endif
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Upload File Baru (opsional)</label>
                <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2" accept=".pdf,.doc,.docx,.jpg,.png">
            </div>

            {{-- Keterangan --}}
            <div class="mb-4">
                <label class="block font-medium mb-1">Keterangan</label>
                <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2">{{ $arsip->keterangan }}</textarea>
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-2">
                <a href="{{ route('arsip.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Update</button>
            </div>
        </form>
    </div>
</x-app-layout>
