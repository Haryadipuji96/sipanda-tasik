<x-app-layout>
    <x-slot name="title">Import Barang - {{ $ruangan->nama_ruangan }}</x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3 mb-3 md:mb-0">
                        <div class="bg-green-100 text-green-600 p-3 rounded-full">
                            <i class="fas fa-file-import text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Import Barang ke Ruangan</h1>
                            <p class="text-sm text-gray-500">
                                Upload file Excel untuk import data barang ke 
                                <strong>{{ $ruangan->nama_ruangan }}</strong>
                                @if ($ruangan->prodi)
                                    - {{ $ruangan->prodi->nama_prodi }} 
                                    ({{ $ruangan->prodi->fakultas->nama_fakultas }})
                                @else
                                    - Unit Umum ({{ $ruangan->unit_prasarana }})
                                @endif
                            </p>
                        </div>
                    </div>
                    
                    <div class="flex gap-2">
                        <a href="{{ route('ruangan.download-template-barang', $ruangan->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-download mr-2"></i>
                            Download Template
                        </a>
                        <a href="{{ route('ruangan.show', $ruangan->id) }}"
                           class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Upload Form -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">📋 Petunjuk Import Barang</h3>
                    <ul class="list-disc list-inside text-blue-700 space-y-2 text-sm">
                        <li>Download template Excel terlebih dahulu</li>
                        <li>Isi data barang sesuai dengan kolom yang tersedia</li>
                        <li>Gunakan dropdown untuk memilih Kategori, Satuan, Kondisi, dan Sumber Barang</li>
                        <li>Pastikan format data sesuai dengan contoh</li>
                        <li>File harus berformat .xlsx, .xls, atau .csv</li>
                        <li>Maksimal ukuran file: 10MB</li>
                        <li>Semua barang akan otomatis masuk ke ruangan: <strong>{{ $ruangan->nama_ruangan }}</strong></li>
                    </ul>
                </div>

                <!-- Upload Card -->
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors">
                    <form action="{{ route('ruangan.import-barang', $ruangan->id) }}" method="POST" enctype="multipart/form-data" id="importForm">
                        @csrf
                        
                        <div class="mb-4">
                            <i class="fas fa-file-excel text-green-500 text-5xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Upload File Excel</h3>
                            <p class="text-gray-500 mb-4">Pilih file Excel yang berisi data barang</p>
                        </div>

                        <div class="mb-4">
                            <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" 
                                   class="hidden" required>
                            <label for="file" 
                                   class="cursor-pointer inline-flex items-center px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition duration-200">
                                <i class="fas fa-upload mr-2"></i>
                                Pilih File Excel
                            </label>
                        </div>

                        <div id="fileName" class="text-sm text-gray-600 mb-4"></div>

                        <button type="submit" 
                                class="inline-flex items-center px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                                id="submitBtn" disabled>
                            <i class="fas fa-database mr-2"></i>
                            Import Data
                        </button>
                    </form>
                </div>

                <!-- Informasi Kolom -->
                <div class="mt-6 bg-gray-50 border border-gray-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">ℹ️ Informasi Kolom Template</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                        <div class="space-y-3">
                            <div>
                                <p class="font-medium text-gray-700">nama_barang*</p>
                                <p class="text-gray-600">Nama barang (wajib diisi)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">kategori_barang*</p>
                                <p class="text-gray-600">Pilih dari dropdown: PERABOTAN & FURNITURE, ELEKTRONIK & TEKNOLOGI, dll</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">merk_barang</p>
                                <p class="text-gray-600">Merk barang (opsional)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">harga_rp</p>
                                <p class="text-gray-600">Harga barang dalam Rupiah (opsional)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">jumlah*</p>
                                <p class="text-gray-600">Jumlah barang (wajib, minimal 1)</p>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <div>
                                <p class="font-medium text-gray-700">satuan*</p>
                                <p class="text-gray-600">Pilih dari dropdown: unit, buah, set, lusin, paket</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">kondisi*</p>
                                <p class="text-gray-600">Pilih dari dropdown: Baik Sekali, Baik, Cukup, Rusak Ringan, Rusak Berat</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">sumber_barang*</p>
                                <p class="text-gray-600">Pilih dari dropdown: HIBAH, LEMBAGA, YAYASAN</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">spesifikasi*</p>
                                <p class="text-gray-600">Deskripsi spesifikasi barang (wajib)</p>
                            </div>
                            <div>
                                <p class="font-medium text-gray-700">kodeseri_barang*</p>
                                <p class="text-gray-600">Kode/seri unik barang (wajib)</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Error Display -->
                @if(session('import_errors'))
                <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-red-800 mb-4">❌ Terjadi Kesalahan Import</h3>
                    <div class="space-y-3">
                        @foreach(session('import_errors') as $error)
                        <div class="bg-white border border-red-100 rounded-lg p-4">
                            <p class="font-medium text-red-700">{{ $error }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(session('error'))
                <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-red-800 mb-2">❌ Error</h3>
                    <p class="text-red-700">{{ session('error') }}</p>
                </div>
                @endif

                @if(session('success'))
                <div class="mt-6 bg-green-50 border border-green-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-green-800 mb-2">✅ Sukses</h3>
                    <p class="text-green-700">{{ session('success') }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.getElementById('file').addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name;
            const submitBtn = document.getElementById('submitBtn');
            const fileNameDisplay = document.getElementById('fileName');
            
            if (fileName) {
                fileNameDisplay.textContent = `File terpilih: ${fileName}`;
                submitBtn.disabled = false;
            } else {
                fileNameDisplay.textContent = '';
                submitBtn.disabled = true;
            }
        });

        document.getElementById('importForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengimport...';
        });
    </script>
</x-app-layout>