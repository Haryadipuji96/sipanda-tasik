<x-app-layout>
    <x-slot name="title">Tambah Barang - {{ $ruangan->nama_ruangan }}</x-slot>

    <style>
        .form-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .info-box {
            background-color: #f0f9ff;
            border: 1px solid #bae6fd;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .btn-primary {
            background-color: #3b82f6;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #2563eb;
        }

        .btn-secondary {
            background-color: #ff0000;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #cc0000;
        }

        .btn-success {
            background-color: #10b981;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-success:hover {
            background-color: #059669;
        }

        .btn-warning {
            background-color: #f59e0b;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-warning:hover {
            background-color: #d97706;
        }

        @media (max-width: 768px) {
            .form-body {
                padding: 1rem;
            }

            .form-header {
                padding: 1rem;
            }
        }
    </style>

    <div class="p-4 sm:p-6">
        <div class="max-w-4xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-box text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Tambah Barang ke Ruangan</h1>
                                <p class="text-blue-100 text-xs sm:text-sm mt-1">
                                    Input data barang untuk ruangan {{ $ruangan->nama_ruangan }}
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('ruangan.show', $ruangan->id) }}"
                            class="text-white hover:text-blue-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali ke Ruangan</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.simpan-barang', $ruangan->id) }}" method="POST"
                    enctype="multipart/form-data" id="formTambahBarang">
                    @csrf

                    <div class="form-body">
                        <!-- Informasi Ruangan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-map-marker-alt mr-2 text-blue-500"></i>
                                Informasi Ruangan
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-blue-800 mb-1 text-sm sm:text-base">Informasi Lokasi
                                        </h4>
                                        <p class="text-blue-700 text-xs sm:text-sm">
                                            • Barang akan ditambahkan ke ruangan:
                                            <strong>{{ $ruangan->nama_ruangan }}</strong><br>
                                            • Lokasi:
                                            <strong>{{ $ruangan->prodi ? $ruangan->prodi->nama_prodi . ' - ' . $ruangan->prodi->fakultas->nama_fakultas : 'Unit Umum' }}</strong><br>
                                            • Field bertanda <span class="text-red-500">*</span> wajib diisi
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <div>
                                    <label class="block text-sm font-medium text-blue-700 mb-1">Nama Ruangan</label>
                                    <input type="text" value="{{ $ruangan->nama_ruangan }}"
                                        class="w-full bg-blue-100 border border-blue-300 rounded-lg px-3 py-2 text-sm"
                                        readonly>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-blue-700 mb-1">Lokasi</label>
                                    <input type="text"
                                        value="{{ $ruangan->prodi ? $ruangan->prodi->nama_prodi . ' - ' . $ruangan->prodi->fakultas->nama_fakultas : 'Unit Umum' }}"
                                        class="w-full bg-blue-100 border border-blue-300 rounded-lg px-3 py-2 text-sm"
                                        readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Data Barang -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Barang
                            </h3>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Nama Barang & Kategori -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nama Barang <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: Meja Kantor, Kursi Plastik, PC Desktop" required>
                                        @error('nama_barang')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Kategori Barang <span class="text-red-500">*</span>
                                        </label>
                                        <select name="kategori_barang"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                            <option value="">-- Pilih Kategori Barang --</option>
                                            <option value="PERABOTAN & FURNITURE"
                                                {{ old('kategori_barang') == 'PERABOTAN & FURNITURE' ? 'selected' : '' }}>
                                                PERABOTAN & FURNITURE
                                            </option>
                                            <option value="ELEKTRONIK & TEKNOLOGI"
                                                {{ old('kategori_barang') == 'ELEKTRONIK & TEKNOLOGI' ? 'selected' : '' }}>
                                                ELEKTRONIK & TEKNOLOGI
                                            </option>
                                            <option value="PERALATAN LABORATORIUM"
                                                {{ old('kategori_barang') == 'PERALATAN LABORATORIUM' ? 'selected' : '' }}>
                                                PERALATAN LABORATORIUM
                                            </option>
                                            <option value="PERALATAN KANTOR"
                                                {{ old('kategori_barang') == 'PERALATAN KANTOR' ? 'selected' : '' }}>
                                                PERALATAN KANTOR
                                            </option>
                                            <option value="ALAT KOMUNIKASI"
                                                {{ old('kategori_barang') == 'ALAT KOMUNIKASI' ? 'selected' : '' }}>
                                                ALAT KOMUNIKASI
                                            </option>
                                            <option value="LAINNYA"
                                                {{ old('kategori_barang') == 'LAINNYA' ? 'selected' : '' }}>
                                                LAINNYA
                                            </option>
                                        </select>
                                        @error('kategori_barang')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Merk & Harga -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Merk Barang
                                        </label>
                                        <input type="text" name="merk_barang" value="{{ old('merk_barang') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: Samsung, IKEA, Local Brand">
                                        @error('merk_barang')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Harga Barang (Rp)
                                        </label>
                                        <input type="number" name="harga" value="{{ old('harga') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="0" min="0" step="0.01">
                                        @error('harga')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Jumlah, Satuan, Kondisi -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Jumlah <span class="text-red-500">*</span>
                                        </label>
                                        <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            min="1" required>
                                        @error('jumlah')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Satuan <span class="text-red-500">*</span>
                                        </label>
                                        <select name="satuan"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                            <option value="">-- Pilih Satuan --</option>
                                            <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit
                                            </option>
                                            <option value="buah" {{ old('satuan') == 'buah' ? 'selected' : '' }}>Buah
                                            </option>
                                            <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set
                                            </option>
                                            <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>
                                                Lusin</option>
                                            <option value="paket" {{ old('satuan') == 'paket' ? 'selected' : '' }}>
                                                Paket</option>
                                        </select>
                                        @error('satuan')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Kondisi <span class="text-red-500">*</span>
                                        </label>
                                        <select name="kondisi"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                            <option value="">-- Pilih Kondisi --</option>
                                            <option value="Baik Sekali"
                                                {{ old('kondisi') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali
                                            </option>
                                            <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>
                                                Baik</option>
                                            <option value="Cukup" {{ old('kondisi') == 'Cukup' ? 'selected' : '' }}>
                                                Cukup</option>
                                            <option value="Rusak Ringan"
                                                {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan
                                            </option>
                                            <option value="Rusak Berat"
                                                {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat
                                            </option>
                                        </select>
                                        @error('kondisi')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tanggal & Tahun Pengadaan -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tanggal Pengadaan
                                        </label>
                                        <input type="date" name="tanggal_pengadaan"
                                            value="{{ old('tanggal_pengadaan') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        @error('tanggal_pengadaan')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tahun Pengadaan
                                        </label>
                                        <input type="text" name="tahun" value="{{ old('tahun') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: 2024" maxlength="4">
                                        @error('tahun')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Sumber Barang -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Sumber Barang <span class="text-red-500">*</span>
                                    </label>
                                    <select name="sumber"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                        <option value="">-- Pilih Sumber --</option>
                                        <option value="HIBAH" {{ old('sumber') == 'HIBAH' ? 'selected' : '' }}>HIBAH
                                        </option>
                                        <option value="LEMBAGA" {{ old('sumber') == 'LEMBAGA' ? 'selected' : '' }}>
                                            LEMBAGA</option>
                                        <option value="YAYASAN" {{ old('sumber') == 'YAYASAN' ? 'selected' : '' }}>
                                            YAYASAN</option>
                                    </select>
                                    @error('sumber')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Spesifikasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Spesifikasi Barang <span class="text-red-500">*</span>
                                    </label>
                                    <textarea name="spesifikasi" rows="3"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                        placeholder="Deskripsikan spesifikasi barang..." required>{{ old('spesifikasi') }}</textarea>
                                    @error('spesifikasi')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Kode Seri & Lokasi Lain -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Kode / Seri Barang <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="kode_seri" value="{{ old('kode_seri') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: PC-001, FURN-2024" required>
                                        @error('kode_seri')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Lokasi Lain (Opsional)
                                        </label>
                                        <input type="text" name="lokasi_lain" value="{{ old('lokasi_lain') }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Misal: Gedung C Lantai 2">
                                        @error('lokasi_lain')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- File Dokumen -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File Dokumen
                                    </label>
                                    <input type="file" name="file_dokumen" id="file_dokumen"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                                    <p class="text-gray-500 text-xs mt-1">
                                        Format: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>2MB</b>
                                    </p>
                                    @error('file_dokumen')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Keterangan -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Keterangan (Opsional)
                                    </label>
                                    <textarea name="keterangan" rows="2"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                        placeholder="Tambahkan keterangan tambahan...">{{ old('keterangan') }}</textarea>
                                    @error('keterangan')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Tambahan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-cogs mr-2 text-green-500"></i>
                                Informasi Tambahan
                            </h3>

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-blue-500 mr-2 text-sm"></i>
                                        <span class="text-gray-600">Dibuat pada:</span>
                                        <span class="ml-2 font-medium">{{ now()->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <i class="fas fa-database text-green-500 mr-2 text-sm"></i>
                                        <span class="text-gray-600">Status:</span>
                                        <span class="ml-2 font-medium text-green-600">Aktif</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-4 sm:pt-6 border-t">
                            <a href="{{ route('ruangan.import-barang-form', $ruangan->id) }}"
                                class="btn-success flex items-center justify-center order-2 sm:order-1 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-file-import mr-2"></i>
                                Import Barang Massal
                            </a>
                            <a href="{{ route('ruangan.index') }}"
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit" name="add_another" value="1"
                                class="btn-warning flex items-center justify-center order-1 sm:order-3 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-plus-circle mr-2"></i>
                                Simpan & Tambah Lagi
                            </button>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-4 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Barang
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // NOTIFIKASI ERROR VALIDATION
            @if ($errors->any())
                let errorMessage = '';
                @foreach ($errors->all() as $error)
                    errorMessage += `• {{ $error }}\n`;
                @endforeach

                Swal.fire({
                    icon: 'error',
                    title: 'Terjadi Kesalahan!',
                    text: errorMessage,
                    confirmButtonColor: '#3b82f6'
                });
            @endif

            // Validasi file upload
            const fileInput = document.getElementById('file_dokumen');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Validate file size (2MB)
                        if (file.size > 2 * 1024 * 1024) {
                            Swal.fire({
                                icon: 'error',
                                title: 'File Terlalu Besar',
                                text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 *
                                    1024)).toFixed(2) + 'MB',
                                confirmButtonColor: '#3b82f6'
                            });
                            this.value = '';
                            return;
                        }

                        // Validate file type
                        const allowedTypes = [
                            'application/pdf',
                            'application/msword',
                            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                            'image/jpeg',
                            'image/jpg',
                            'image/png'
                        ];
                        if (!allowedTypes.includes(file.type)) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Format File Tidak Didukung',
                                text: 'Hanya file PDF, DOC, DOCX, JPG, dan PNG yang diizinkan.',
                                confirmButtonColor: '#3b82f6'
                            });
                            this.value = '';
                            return;
                        }
                    }
                });
            }

            // Validasi form
            const form = document.getElementById('formTambahBarang');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    const requiredFields = form.querySelectorAll('[required]');

                    // Reset error styles
                    requiredFields.forEach(field => {
                        field.classList.remove('border-red-500', 'border-2');
                    });

                    // Check required fields
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500', 'border-2');

                            // Scroll to first error
                            if (!form.querySelector('.border-red-500')) {
                                field.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'warning',
                            title: 'Data Belum Lengkap',
                            text: 'Harap isi semua field yang wajib diisi!',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }

                    // Show loading indicator
                    const submitButton = e.submitter;
                    if (submitButton) {
                        const originalText = submitButton.innerHTML;
                        submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Menyimpan...';
                        submitButton.disabled = true;

                        // Re-enable button after 5 seconds (safety measure)
                        setTimeout(() => {
                            submitButton.innerHTML = originalText;
                            submitButton.disabled = false;
                        }, 5000);
                    }
                });
            }
        });
    </script>
</x-app-layout>
