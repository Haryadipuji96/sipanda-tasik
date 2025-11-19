<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Arsip Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-2xl p-4 sm:p-6 md:p-8 w-full border border-gray-100">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-4 border-b">
                        <div class="flex items-center space-x-3 mb-3 sm:mb-0">
                            <div class="bg-green-100 text-blue-600 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Arsip Baru</h1>
                        </div>
                        <a href="{{ route('arsip.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1 self-start sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>

                    {{-- Tampilkan Error Validasi --}}
                    @if ($errors->any())
                        <div class="mb-4 p-3 bg-red-50 border border-red-200 rounded text-red-600 text-sm">
                            <ul class="list-disc pl-5 space-y-1">
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
                            <label class="block font-medium mb-1 text-sm sm:text-base">Kategori Arsip <span class="text-red-500">*</span></label>
                            <select name="id_kategori" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $k)
                                    <option value="{{ $k->id }}" {{ old('id_kategori') == $k->id ? 'selected' : '' }}>
                                        {{ $k->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>


                        {{-- 🔹 Judul Dokumen --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Judul Dokumen <span class="text-red-500">*</span></label>
                            <input type="text" name="judul_dokumen" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="Masukkan judul dokumen" value="{{ old('judul_dokumen') }}" required>
                        </div>

                        {{-- 🔹 Nomor & Tanggal Dokumen --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Nomor Dokumen</label>
                                <input type="text" name="nomor_dokumen" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                    placeholder="Contoh: SK-001/IAIT/2025" value="{{ old('nomor_dokumen') }}">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Tanggal Dokumen</label>
                                <input type="date" name="tanggal_dokumen" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                    value="{{ old('tanggal_dokumen') }}">
                            </div>
                        </div>

                        {{-- 🔹 Tahun --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Tahun Dokumen</label>
                            <input type="text" name="tahun" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="Contoh: 2025" maxlength="4" value="{{ old('tahun') }}">
                        </div>

                        {{-- 🔹 Upload File Dokumen --}}
                        <div class="mb-4">
                            <label for="file_dokumen" class="block font-medium mb-1 text-sm sm:text-base">
                                Upload File Dokumen
                            </label>
                            <div class="flex flex-col w-full">
                                <input type="file" name="file_dokumen" id="file_dokumen"
                                    class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                    accept=".pdf,.doc,.docx,.jpg,.png" />
                                <p class="text-gray-500 text-xs mt-1">
                                    Format diizinkan: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>5MB</b>
                                </p>
                            </div>
                        </div>

                        {{-- 🔹 Keterangan --}}
                        <div class="mb-6">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="3" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="Tambahkan catatan tambahan...">{{ old('keterangan') }}</textarea>
                        </div>

                        {{-- 🔹 Tombol Aksi --}}
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route('arsip.index') }}"
                                class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 text-center transition">
                                Batal
                            </a>
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                                Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>