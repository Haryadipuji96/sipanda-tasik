<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Data Sarpras</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="bg-gray-50">
    <div class="min-h-screen">
        <!-- Header/Navbar -->
        <header class="bg-white shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <i class="fas fa-building text-blue-600 text-xl mr-2"></i>
                            <span class="font-semibold text-xl text-gray-800">Sistem Sarpras</span>
                        </div>
                    </div>
                    <div class="flex items-center">
                        <div class="ml-3 relative">
                            <div class="flex items-center space-x-4">
                                <a href="#" class="text-gray-600 hover:text-gray-900">
                                    <i class="fas fa-bell"></i>
                                </a>
                                <div class="flex items-center">
                                    <div
                                        class="h-8 w-8 rounded-full bg-blue-500 flex items-center justify-center text-white font-medium">
                                        U
                                    </div>
                                    <span class="ml-2 text-gray-700 hidden sm:block">User</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="py-6">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-2xl p-4 sm:p-6 md:p-8 w-full border border-gray-100">
                    <!-- Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 pb-4 border-b">
                        <div class="flex items-center space-x-3 mb-3 sm:mb-0">
                            <div class="bg-green-100 text-blue-600 p-2 rounded-full">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 sm:h-6 sm:w-6" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                            <h1 class="text-xl sm:text-2xl font-semibold text-gray-800">Tambah Data Sarpras</h1>
                        </div>
                        <a href="{{ route('sarpras.index') }}"
                            class="text-sm text-gray-600 hover:text-gray-800 transition flex items-center space-x-1 self-start sm:self-auto">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                            <span>Kembali</span>
                        </a>
                    </div>

                    <form action="{{ route('sarpras.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        {{-- Prodi --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Program Studi (Opsional)</label>
                            <select name="id_prodi" class="w-full border rounded px-3 py-2 text-sm sm:text-base">
                                <option value="">-- Pilih Prodi --</option>
                                @foreach ($prodi as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_prodi }}
                                        ({{ $p->fakultas->nama_fakultas }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Nama Barang --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Nama Barang</label>
                            <input type="text" name="nama_barang"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                placeholder="Masukkan nama barang">
                        </div>

                        {{-- Kategori & Kondisi --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Kategori</label>
                                <input type="text" name="kategori"
                                    class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                    placeholder="Masukkan kategori barang">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Kondisi</label>
                                <select name="kondisi" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                    required>
                                    <option value="">-- Pilih Kondisi Barang --</option>
                                    <option value="Baik Sekali">Baik Sekali</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Cukup">Cukup</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                            </div>
                        </div>

                        {{-- Jumlah & Tanggal Pengadaan --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Jumlah Barang</label>
                                <input type="number" name="jumlah"
                                    class="w-full border rounded px-3 py-2 text-sm sm:text-base" min="1" required
                                    placeholder="0">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Tanggal Pengadaan</label>
                                <input type="date" name="tanggal_pengadaan"
                                    class="w-full border rounded px-3 py-2 text-sm sm:text-base" required>
                            </div>
                        </div>

                        {{-- Spesifikasi --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Spesifikasi Barang</label>
                            <textarea name="spesifikasi" rows="3" class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                placeholder="Masukkan spesifikasi barang"></textarea>
                        </div>

                        {{-- Kode Seri & Sumber --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Kode / Seri Barang</label>
                                <input type="text" name="kode_seri"
                                    class="w-full border rounded px-3 py-2 text-sm sm:text-base" required
                                    placeholder="Masukkan kode/seri barang">
                            </div>
                            <div>
                                <label class="block font-medium mb-1 text-sm sm:text-base">Sumber Barang</label>
                                <select name="sumber" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                    required>
                                    <option value="">-- Pilih Sumber --</option>
                                    <option value="HIBAH">HIBAH</option>
                                    <option value="LEMBAGA">LEMBAGA</option>
                                    <option value="YAYASAN">YAYASAN</option>
                                </select>
                            </div>
                        </div>

                        {{-- Lokasi Lain --}}
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Lokasi Lain (Opsional)</label>
                            <input type="text" name="lokasi_lain"
                                class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="Misal: Gedung C Lantai 2">
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

                        {{-- Keterangan --}}
                        <div class="mb-6">
                            <label class="block font-medium mb-1 text-sm sm:text-base">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="2" class="w-full border rounded px-3 py-2 text-sm sm:text-base"
                                placeholder="Tambahkan keterangan tambahan..."></textarea>
                        </div>

                        {{-- Tombol --}}
                        <div class="flex flex-col sm:flex-row justify-end space-y-2 sm:space-y-0 sm:space-x-2">
                            <a href="{{ route('sarpras.index') }}"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded text-center transition">
                                Batal
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">
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
