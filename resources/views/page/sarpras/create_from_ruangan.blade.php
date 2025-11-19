<x-app-layout>
    <x-slot name="title">Tambah Barang - {{ $ruangan->nama_ruangan }}</x-slot>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">Tambah Barang ke Ruangan</h1>
                        <p class="text-gray-600 mt-1">
                            <strong>Ruangan:</strong> {{ $ruangan->nama_ruangan }}
                            @if($ruangan->prodi)
                                | <strong>Prodi:</strong> {{ $ruangan->prodi->nama_prodi }}
                                | <strong>Fakultas:</strong> {{ $ruangan->prodi->fakultas->nama_fakultas }}
                            @else
                                | <strong>Unit Umum</strong>
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('ruangan.show', $ruangan->id) }}"
                        class="text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        <span>Kembali ke Ruangan</span>
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.simpan-barang', $ruangan->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Informasi Ruangan (Readonly) -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">📍 Informasi Ruangan</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-1">Nama Ruangan</label>
                                <input type="text" value="{{ $ruangan->nama_ruangan }}" class="w-full bg-blue-100 border border-blue-300 rounded px-3 py-2" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-1">Lokasi</label>
                                <input type="text" 
                                    value="{{ $ruangan->prodi ? $ruangan->prodi->nama_prodi . ' - ' . $ruangan->prodi->fakultas->nama_fakultas : 'Unit Umum' }}" 
                                    class="w-full bg-blue-100 border border-blue-300 rounded px-3 py-2" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Data Barang -->
                    <div class="mb-6 p-4 bg-green-50 rounded-lg border border-green-200">
                        <h3 class="text-lg font-semibold text-green-800 mb-4">📦 Data Barang</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Nama Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Nama Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: Meja Kantor, Kursi Plastik, PC Desktop" required>
                                @error('nama_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Kategori Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="kategori_barang" value="{{ old('kategori_barang') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: Elektronik, Furniture, Alat Tulis" required>
                                @error('kategori_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Merk Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Merk Barang</label>
                                <input type="text" name="merk_barang" value="{{ old('merk_barang') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: Samsung, IKEA, Local Brand">
                                @error('merk_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Harga Barang (Rp)</label>
                                <input type="number" name="harga" value="{{ old('harga') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="0" min="0" step="0.01">
                                @error('harga')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                            <!-- Jumlah -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Jumlah <span class="text-red-500">*</span></label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    min="1" required>
                                @error('jumlah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Satuan -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Satuan <span class="text-red-500">*</span></label>
                                <select name="satuan" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    <option value="unit">Unit</option>
                                    <option value="buah">Buah</option>
                                    <option value="set">Set</option>
                                    <option value="lusin">Lusin</option>
                                    <option value="paket">Paket</option>
                                </select>
                                @error('satuan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Kondisi <span class="text-red-500">*</span></label>
                                <select name="kondisi" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="Baik Sekali">Baik Sekali</option>
                                    <option value="Baik">Baik</option>
                                    <option value="Cukup">Cukup</option>
                                    <option value="Rusak Ringan">Rusak Ringan</option>
                                    <option value="Rusak Berat">Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Tanggal Pengadaan -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Tanggal Pengadaan <span class="text-red-500">*</span></label>
                                <input type="date" name="tanggal_pengadaan" value="{{ old('tanggal_pengadaan') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                @error('tanggal_pengadaan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sumber -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Sumber Barang <span class="text-red-500">*</span></label>
                                <select name="sumber" class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500" required>
                                    <option value="">-- Pilih Sumber --</option>
                                    <option value="HIBAH">HIBAH</option>
                                    <option value="LEMBAGA">LEMBAGA</option>
                                    <option value="YAYASAN">YAYASAN</option>
                                </select>
                                @error('sumber')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Spesifikasi -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-gray-700">Spesifikasi Barang <span class="text-red-500">*</span></label>
                            <textarea name="spesifikasi" rows="3" 
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Deskripsikan spesifikasi barang..." required>{{ old('spesifikasi') }}</textarea>
                            @error('spesifikasi')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Kode Seri -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Kode / Seri Barang <span class="text-red-500">*</span></label>
                                <input type="text" name="kode_seri" value="{{ old('kode_seri') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: PC-001, FURN-2024" required>
                                @error('kode_seri')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Lain -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">Lokasi Lain (Opsional)</label>
                                <input type="text" name="lokasi_lain" value="{{ old('lokasi_lain') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Misal: Gedung C Lantai 2">
                                @error('lokasi_lain')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- File Dokumen -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-gray-700">File Dokumen</label>
                            <input type="file" name="file_dokumen" id="file_dokumen"
                                class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                accept=".pdf,.doc,.docx,.jpg,.png">
                            <p class="text-gray-500 text-xs mt-1">
                                Format: PDF, DOC, DOCX, JPG, PNG | Maksimal: 5MB
                            </p>
                            @error('file_dokumen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-gray-700">Keterangan (Opsional)</label>
                            <textarea name="keterangan" rows="2" 
                                class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                placeholder="Tambahkan keterangan tambahan...">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Tombol -->
                    <div class="flex flex-col sm:flex-row justify-end gap-2 pt-4 border-t">
                        <a href="{{ route('ruangan.show', $ruangan->id) }}" 
                            class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg text-center transition order-2 sm:order-1">
                            Batal
                        </a>
                        <button type="submit" name="add_another" value="1"
                            class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg transition flex items-center justify-center order-1 sm:order-2 mb-2 sm:mb-0">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            Simpan & Tambah Lagi
                        </button>
                        <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition flex items-center justify-center order-3">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Simpan Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>