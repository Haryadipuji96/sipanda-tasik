<x-app-layout>
    <div class="p-6 max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-3xl border border-gray-100">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6 border-b pb-4">
                <div class="flex items-center space-x-3">
                    <div class="bg-green-100 text-green-600 p-2 rounded-full">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-semibold text-gray-800">Tambah Arsip Baru</h1>
                </div>
                <a href="{{ route('arsip.index') }}"
                    class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                    <span>Kembali</span>
                </a>
            </div>

            {{-- Tampilkan Error Validasi --}}
            @if ($errors->any())
                <div class="mb-4 text-red-600">
                    <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('arsip.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                {{-- 🔹 Kategori Arsip --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Kategori Arsip <span class="text-red-500">*</span></label>
                    <select name="id_kategori" class="w-full border rounded px-3 py-2" required>
                        <option value="">-- Pilih Kategori --</option>
                        @foreach ($kategori as $k)
                            <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                                {{ $k->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🔹 Program Studi --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Program Studi (Opsional)</label>
                    <select name="id_prodi" class="w-full border rounded px-3 py-2">
                        <option value="">-- Pilih Program Studi --</option>
                        @foreach ($prodi as $p)
                            <option value="{{ $p->id }}" {{ old('id_prodi') == $p->id ? 'selected' : '' }}>
                                {{ $p->nama_prodi }} ({{ $p->fakultas->nama_fakultas }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- 🔹 Judul Dokumen --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Judul Dokumen <span class="text-red-500">*</span></label>
                    <input type="text" name="judul_dokumen" class="w-full border rounded px-3 py-2"
                        placeholder="Masukkan judul dokumen" value="{{ old('judul_dokumen') }}" required>
                </div>

                {{-- 🔹 Nomor & Tanggal Dokumen --}}
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block font-medium mb-1">Nomor Dokumen</label>
                        <input type="text" name="nomor_dokumen" class="w-full border rounded px-3 py-2"
                            placeholder="Contoh: SK-001/IAIT/2025" value="{{ old('nomor_dokumen') }}">
                    </div>
                    <div>
                        <label class="block font-medium mb-1">Tanggal Dokumen</label>
                        <input type="date" name="tanggal_dokumen" class="w-full border rounded px-3 py-2"
                            value="{{ old('tanggal_dokumen') }}">
                    </div>
                </div>

                {{-- 🔹 Tahun --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Tahun Dokumen</label>
                    <input type="text" name="tahun" class="w-full border rounded px-3 py-2"
                        placeholder="Contoh: 2025" maxlength="4" value="{{ old('tahun') }}">
                </div>

                {{-- 🔹 Upload File Dokumen --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Upload File Dokumen</label>
                    <input type="file" name="file_dokumen" class="w-full border rounded px-3 py-2"
                        accept=".pdf,.doc,.docx,.jpg,.png">
                    <p class="text-gray-500 text-sm mt-1">
                        Format diizinkan: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>5MB</b>
                    </p>
                </div>

                {{-- 🔹 Keterangan --}}
                <div class="mb-6">
                    <label class="block font-medium mb-1">Keterangan (Opsional)</label>
                    <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2"
                        placeholder="Tambahkan catatan tambahan...">{{ old('keterangan') }}</textarea>
                </div>

                {{-- 🔹 Tombol Aksi --}}
                <div class="flex justify-end space-x-2">
                    <a href="{{ route('arsip.index') }}"
                        class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                        Batal
                    </a>
                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
