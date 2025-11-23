<x-app-layout>
    <x-slot name="title">Tambah Barang - {{ $ruangan->nama_ruangan }}</x-slot>

    <style>
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
            background-color: #6b7280;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #4b5563;
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
    </style>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <!-- Header -->
                <div class="flex items-center justify-between mb-6 pb-4 border-b">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">Tambah Barang ke Ruangan</h1>
                        <p class="text-gray-600 mt-1">
                            <strong>Ruangan:</strong> {{ $ruangan->nama_ruangan }}
                            @if ($ruangan->prodi)
                                | <strong>Prodi:</strong> {{ $ruangan->prodi->nama_prodi }}
                                | <strong>Fakultas:</strong> {{ $ruangan->prodi->fakultas->nama_fakultas }}
                            @else
                                | <strong>Unit Umum</strong>
                            @endif
                        </p>
                    </div>
                    <a href="{{ route('ruangan.show', $ruangan->id) }}"
                        class="text-gray-600 hover:text-gray-800 transition flex items-center space-x-1">
                        <i class="fas fa-arrow-left mr-1"></i>
                        <span>Kembali ke Ruangan</span>
                    </a>
                </div>

                <!-- Form -->
                <form action="{{ route('ruangan.simpan-barang', $ruangan->id) }}" method="POST"
                    enctype="multipart/form-data" id="formTambahBarang">
                    @csrf

                    <!-- Informasi Ruangan (Readonly) -->
                    <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <h3 class="text-lg font-semibold text-blue-800 mb-2">
                            <i class="fas fa-map-marker-alt mr-2"></i>Informasi Ruangan
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-blue-700 mb-1">Nama Ruangan</label>
                                <input type="text" value="{{ $ruangan->nama_ruangan }}"
                                    class="w-full bg-blue-100 border border-blue-300 rounded px-3 py-2" readonly>
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
                        <h3 class="text-lg font-semibold text-green-800 mb-4">
                            <i class="fas fa-box mr-2"></i>Data Barang
                        </h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Nama Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-tag mr-1 text-blue-500"></i>Nama Barang <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: Meja Kantor, Kursi Plastik, PC Desktop" required>
                                @error('nama_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kategori Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-list mr-1 text-blue-500"></i>Kategori Barang <span class="text-red-500">*</span>
                                </label>
                                <select name="kategori_barang"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                    <option value="">-- Pilih Kategori Barang --</option>
                                    <option value="PERABOTAN & FURNITURE" {{ old('kategori_barang') == 'PERABOTAN & FURNITURE' ? 'selected' : '' }}>
                                        PERABOTAN & FURNITURE (Meja, Kursi, Lemari, Rak, Sofa, dll)
                                    </option>
                                    <option value="ELEKTRONIK & TEKNOLOGI" {{ old('kategori_barang') == 'ELEKTRONIK & TEKNOLOGI' ? 'selected' : '' }}>
                                        ELEKTRONIK & TEKNOLOGI (Komputer, Laptop, Printer, Proyektor, AC, TV, Lampu, dll)
                                    </option>
                                    <option value="PERALATAN LABORATORIUM" {{ old('kategori_barang') == 'PERALATAN LABORATORIUM' ? 'selected' : '' }}>
                                        PERALATAN LABORATORIUM (Mikroskop, Alat Kimia, Alat Biologi, Alat Fisika, dll)
                                    </option>
                                    <option value="PERALATAN KANTOR" {{ old('kategori_barang') == 'PERALATAN KANTOR' ? 'selected' : '' }}>
                                        PERALATAN KANTOR (Mesin Ketik, Mesin Fax, Mesin Fotocopy, Stapler, Calculator, dll)
                                    </option>
                                    <option value="ALAT KOMUNIKASI" {{ old('kategori_barang') == 'ALAT KOMUNIKASI' ? 'selected' : '' }}>
                                        ALAT KOMUNIKASI (Telepon, Handy Talky, Pager, dll)
                                    </option>
                                    <option value="LAINNYA" {{ old('kategori_barang') == 'LAINNYA' ? 'selected' : '' }}>
                                        LAINNYA (Barang tidak termasuk kategori di atas)
                                    </option>
                                </select>
                                @error('kategori_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Merk Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-barcode mr-1 text-blue-500"></i>Merk Barang
                                </label>
                                <input type="text" name="merk_barang" value="{{ old('merk_barang') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: Samsung, IKEA, Local Brand">
                                @error('merk_barang')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Harga Barang -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-money-bill-wave mr-1 text-blue-500"></i>Harga Barang (Rp)
                                </label>
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
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-calculator mr-1 text-blue-500"></i>Jumlah <span class="text-red-500">*</span>
                                </label>
                                <input type="number" name="jumlah" value="{{ old('jumlah', 1) }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    min="1" required>
                                @error('jumlah')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Satuan -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-balance-scale mr-1 text-blue-500"></i>Satuan <span class="text-red-500">*</span>
                                </label>
                                <select name="satuan"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                    <option value="">-- Pilih Satuan --</option>
                                    <option value="unit" {{ old('satuan') == 'unit' ? 'selected' : '' }}>Unit</option>
                                    <option value="buah" {{ old('satuan') == 'buah' ? 'selected' : '' }}>Buah</option>
                                    <option value="set" {{ old('satuan') == 'set' ? 'selected' : '' }}>Set</option>
                                    <option value="lusin" {{ old('satuan') == 'lusin' ? 'selected' : '' }}>Lusin</option>
                                    <option value="paket" {{ old('satuan') == 'paket' ? 'selected' : '' }}>Paket</option>
                                </select>
                                @error('satuan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Kondisi -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-heartbeat mr-1 text-blue-500"></i>Kondisi <span class="text-red-500">*</span>
                                </label>
                                <select name="kondisi"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                    <option value="">-- Pilih Kondisi --</option>
                                    <option value="Baik Sekali" {{ old('kondisi') == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                                    <option value="Baik" {{ old('kondisi') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="Cukup" {{ old('kondisi') == 'Cukup' ? 'selected' : '' }}>Cukup</option>
                                    <option value="Rusak Ringan" {{ old('kondisi') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                    <option value="Rusak Berat" {{ old('kondisi') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                                </select>
                                @error('kondisi')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                            <!-- Tanggal Pengadaan -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-calendar-alt mr-1 text-blue-500"></i>Tanggal Pengadaan <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="tanggal_pengadaan"
                                    value="{{ old('tanggal_pengadaan') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                @error('tanggal_pengadaan')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sumber -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-gift mr-1 text-blue-500"></i>Sumber Barang <span class="text-red-500">*</span>
                                </label>
                                <select name="sumber"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    required>
                                    <option value="">-- Pilih Sumber --</option>
                                    <option value="HIBAH" {{ old('sumber') == 'HIBAH' ? 'selected' : '' }}>HIBAH</option>
                                    <option value="LEMBAGA" {{ old('sumber') == 'LEMBAGA' ? 'selected' : '' }}>LEMBAGA</option>
                                    <option value="YAYASAN" {{ old('sumber') == 'YAYASAN' ? 'selected' : '' }}>YAYASAN</option>
                                </select>
                                @error('sumber')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Spesifikasi -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-gray-700">
                                <i class="fas fa-info-circle mr-1 text-blue-500"></i>Spesifikasi Barang <span class="text-red-500">*</span>
                            </label>
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
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-hashtag mr-1 text-blue-500"></i>Kode / Seri Barang <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="kode_seri" value="{{ old('kode_seri') }}"
                                    class="w-full border rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500"
                                    placeholder="Contoh: PC-001, FURN-2024" required>
                                @error('kode_seri')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Lokasi Lain -->
                            <div>
                                <label class="block font-medium mb-1 text-gray-700">
                                    <i class="fas fa-map-marker-alt mr-1 text-blue-500"></i>Lokasi Lain (Opsional)
                                </label>
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
                            <label class="block font-medium mb-1 text-gray-700">
                                <i class="fas fa-file-upload mr-1 text-blue-500"></i>File Dokumen
                            </label>
                            <input type="file" name="file_dokumen" id="file_dokumen"
                                class="flex w-full rounded-md border border-blue-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                            <p class="text-gray-500 text-xs mt-1">
                                Format: PDF, DOC, DOCX, JPG, JPEG, PNG | Maksimal: 5MB
                            </p>
                            @error('file_dokumen')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-4">
                            <label class="block font-medium mb-1 text-gray-700">
                                <i class="fas fa-sticky-note mr-1 text-blue-500"></i>Keterangan (Opsional)
                            </label>
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
                            class="btn-secondary px-6 py-2 text-center transition order-2 sm:order-1">
                            <i class="fas fa-times mr-2"></i>Batal
                        </a>
                        <button type="submit" name="add_another" value="1"
                            class="btn-success px-6 py-2 transition flex items-center justify-center order-1 sm:order-2 mb-2 sm:mb-0">
                            <i class="fas fa-plus-circle mr-2"></i>Simpan & Tambah Lagi
                        </button>
                        <button type="submit"
                            class="btn-primary px-6 py-2 transition flex items-center justify-center order-3">
                            <i class="fas fa-save mr-2"></i>Simpan Barang
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // NOTIFIKASI SUKSES
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            // NOTIFIKASI ERROR
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: "{{ session('error') }}",
                    timer: 4000,
                    showConfirmButton: true
                });
            @endif

            // VALIDASI FORM SEBELUM SUBMIT
            const form = document.getElementById('formTambahBarang');
            form.addEventListener('submit', function(e) {
                const requiredFields = form.querySelectorAll('[required]');
                let isValid = true;
                
                requiredFields.forEach(field => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add('border-red-500');
                    } else {
                        field.classList.remove('border-red-500');
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
                }
            });
        });
    </script>
</x-app-layout>