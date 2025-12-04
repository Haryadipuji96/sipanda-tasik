<x-app-layout>
    <x-slot name="title">Import Data Tenaga Pendidik</x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl rounded-2xl p-6 border border-gray-100">
                <!-- Header -->
                <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 pb-4 border-b">
                    <div class="flex items-center space-x-3 mb-3 md:mb-0">
                        <div class="bg-green-100 text-green-600 p-3 rounded-full">
                            <i class="fas fa-file-import text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">Import Data Tenaga Pendidik</h1>
                            <p class="text-sm text-gray-500">Upload file Excel untuk import data tenaga pendidik</p>
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('tenaga-pendidik.download-template') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600 transition">
                            <i class="fas fa-download mr-2"></i>
                            Download Template
                        </a>
                        <a href="{{ route('tenaga-pendidik.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-500 text-white text-sm rounded-lg hover:bg-gray-600 transition">
                            <i class="fas fa-arrow-left mr-2"></i>
                            Kembali
                        </a>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if (session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-600 mr-3"></i>
                            <p class="text-green-700 font-medium">{{ session('success') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('warning'))
                    <div class="mb-6 bg-yellow-50 border border-yellow-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-yellow-600 mr-3"></i>
                            <p class="text-yellow-700 font-medium">{{ session('warning') }}</p>
                        </div>
                    </div>
                @endif

                @if (session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-xl p-4">
                        <div class="flex items-center">
                            <i class="fas fa-times-circle text-red-600 mr-3"></i>
                            <div>
                                <p class="text-red-700 font-medium">{{ session('error') }}</p>
                                @if (session('error_details'))
                                    <div class="mt-2 text-sm text-red-600">
                                        @foreach (session('error_details') as $detail)
                                            <p class="mb-1">• {{ $detail }}</p>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Upload Form -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-6">
                    <h3 class="text-lg font-semibold text-blue-800 mb-4">📋 Petunjuk Import</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <h4 class="font-medium text-blue-700 mb-2">Format Data</h4>
                            <ul class="list-disc list-inside text-blue-700 space-y-1 text-sm">
                                <li>Kolom berikut wajib diisi: <strong>nama_tendik, status_kepegawaian,
                                        jenis_kelamin</strong></li>
                                <li>Format tanggal: <code>YYYY-MM-DD</code> (contoh: 2024-05-15)</li>
                                <li>Format riwayat golongan: <code>tahun;golongan|tahun;golongan</code></li>
                                <li>Contoh: <code>2023;IV/A|2020;III/B|2017;II/A</code></li>
                                <li>Urutkan dari tahun terbaru ke terlama</li>
                            </ul>
                        </div>
                        <div>
                            <h4 class="font-medium text-blue-700 mb-2">Ketentuan File</h4>
                            <ul class="list-disc list-inside text-blue-700 space-y-1 text-sm">
                                <li>Format file: <strong>.xlsx, .xls, .csv</strong></li>
                                <li>Maksimal ukuran: <strong>5MB</strong></li>
                                <li>Gunakan template yang disediakan</li>
                                <li>Data akan divalidasi saat import</li>
                                <li>NIP/Email/No HP harus unik</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Upload Card -->
                <div
                    class="border-2 border-dashed border-gray-300 rounded-xl p-8 text-center hover:border-blue-400 transition-colors mb-6">
                    <form action="{{ route('tenaga-pendidik.import') }}" method="POST" enctype="multipart/form-data"
                        id="importForm">
                        @csrf

                        <div class="mb-4">
                            <i class="fas fa-file-excel text-green-500 text-5xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-700 mb-2">Upload File Excel</h3>
                            <p class="text-gray-500 mb-4">Pilih file Excel yang berisi data tenaga pendidik</p>
                        </div>

                        <div class="mb-4">
                            <input type="file" name="file" id="file" accept=".xlsx,.xls,.csv" class="hidden"
                                required>
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

                <!-- Error Display from Import -->
                @if (session('import_errors') && is_array(session('import_errors')) && count(session('import_errors')) > 0)
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-exclamation-triangle text-red-600 mr-3 text-xl"></i>
                            <h3 class="text-lg font-semibold text-red-800">❌ Data Gagal Diimport</h3>
                        </div>

                        <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                            @foreach (session('import_errors') as $index => $error)
                                @if (is_array($error))
                                    <div class="bg-white border border-red-100 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-red-700 mb-1">
                                                    @if (isset($error['row']) && $error['row'] !== 'unknown')
                                                        Baris {{ $error['row'] }}:
                                                    @else
                                                        Kesalahan {{ $index + 1 }}:
                                                    @endif
                                                    {{ is_array($error['message'] ?? '') ? implode(', ', $error['message']) : $error['message'] ?? 'Tidak diketahui' }}
                                                </p>
                                                @if (isset($error['data']) && is_array($error['data']) && count($error['data']) > 0)
                                                    <div class="mt-2">
                                                        <p class="text-sm text-gray-600 mb-1">Data terkait:</p>
                                                        <ul class="text-xs text-gray-500 space-y-1">
                                                            @foreach ($error['data'] as $key => $value)
                                                                <li><span
                                                                        class="font-medium">{{ $key }}:</span>
                                                                    {{ is_array($value) ? json_encode($value) : (string) $value }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @endif
                                            </div>
                                            <span
                                                class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Error</span>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-white border border-red-100 rounded-lg p-4">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <p class="font-medium text-red-700 mb-1">
                                                    Error {{ $index + 1 }}:
                                                    {{ is_array($error) ? json_encode($error) : (string) $error }}
                                                </p>
                                            </div>
                                            <span
                                                class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full">Error</span>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Validation Failures from Laravel Excel -->
                @if (session('validation_failures') &&
                        is_array(session('validation_failures')) &&
                        count(session('validation_failures')) > 0)
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                        <div class="flex items-center mb-4">
                            <i class="fas fa-exclamation-circle text-yellow-600 mr-3 text-xl"></i>
                            <h3 class="text-lg font-semibold text-yellow-800">⚠️ Validasi Data Bermasalah</h3>
                        </div>

                        <div class="space-y-3 max-h-96 overflow-y-auto pr-2">
                            @foreach (session('validation_failures') as $failure)
                                <div class="bg-white border border-yellow-100 rounded-lg p-4">
                                    <div class="flex justify-between items-start">
                                        <div>
                                            <p class="font-medium text-yellow-700 mb-1">
                                                Baris {{ $failure['row'] ?? 'Tidak diketahui' }}
                                                ({{ $failure['attribute'] ?? 'Kolom' }})
                                                :
                                                @if (is_array($failure['errors'] ?? null))
                                                    {{ implode(', ', $failure['errors']) }}
                                                @else
                                                    {{ $failure['errors'] ?? 'Tidak diketahui' }}
                                                @endif
                                            </p>
                                            @if (isset($failure['values']) && is_array($failure['values']) && count($failure['values']) > 0)
                                                <div class="mt-2">
                                                    <p class="text-sm text-gray-600 mb-1">Data pada baris ini:</p>
                                                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2">
                                                        @php
                                                            $displayed = 0;
                                                        @endphp
                                                        @foreach ($failure['values'] as $key => $value)
                                                            @if (!empty($value) && $value !== '' && $displayed < 4)
                                                                @php $displayed++; @endphp
                                                                <div class="text-xs">
                                                                    <span
                                                                        class="font-medium text-gray-600">{{ $key }}:</span>
                                                                    <span class="text-gray-500 truncate block">
                                                                        {{ is_array($value) ? json_encode($value) : (string) $value }}
                                                                    </span>
                                                                </div>
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <span
                                            class="bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full">Warning</span>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                

                <!-- Important Note -->
                <div class="mt-6 bg-gray-50 border border-gray-200 rounded-xl p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">💡 Tips & Catatan Penting</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <p>Template sudah menyertakan <strong>3 contoh data</strong> yang bisa dihapus/diubah
                                </p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <p>Kolom dropdown (Program Studi, Status Kepegawaian, dll) sudah tersedia</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                                <p>Format tanggal dan angka sudah diatur otomatis</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-2"></i>
                                <p>Pastikan <strong>tidak ada data duplikat</strong> (NIP, Email, No HP)</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-2"></i>
                                <p>Hapus contoh data jika tidak diperlukan sebelum import</p>
                            </div>
                            <div class="flex items-start">
                                <i class="fas fa-exclamation-triangle text-yellow-500 mt-1 mr-2"></i>
                                <p>Simpan file sebagai <strong>.xlsx</strong> sebelum upload</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('file');
            const submitBtn = document.getElementById('submitBtn');
            const fileNameDisplay = document.getElementById('fileName');
            const importForm = document.getElementById('importForm');

            // File selection handler
            fileInput.addEventListener('change', function(e) {
                const file = e.target.files[0];

                if (file) {
                    // Validasi ukuran file (max 5MB)
                    const maxSize = 5 * 1024 * 1024; // 5MB in bytes
                    if (file.size > maxSize) {
                        alert('Ukuran file terlalu besar! Maksimal 5MB.');
                        fileInput.value = '';
                        fileNameDisplay.textContent = '';
                        submitBtn.disabled = true;
                        return;
                    }

                    // Validasi ekstensi file
                    const allowedExtensions = ['.xlsx', '.xls', '.csv'];
                    const fileName = file.name.toLowerCase();
                    const isValidExtension = allowedExtensions.some(ext => fileName.endsWith(ext));

                    if (!isValidExtension) {
                        alert('Format file tidak didukung! Gunakan .xlsx, .xls, atau .csv');
                        fileInput.value = '';
                        fileNameDisplay.textContent = '';
                        submitBtn.disabled = true;
                        return;
                    }

                    fileNameDisplay.textContent =
                        `File terpilih: ${file.name} (${(file.size / 1024 / 1024).toFixed(2)} MB)`;
                    submitBtn.disabled = false;
                } else {
                    fileNameDisplay.textContent = '';
                    submitBtn.disabled = true;
                }
            });

            // Form submission handler
            importForm.addEventListener('submit', function(e) {
                if (!fileInput.files[0]) {
                    e.preventDefault();
                    alert('Silakan pilih file terlebih dahulu!');
                    return;
                }

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengimport...';

                // Optional: Show progress indicator
                const loadingOverlay = document.createElement('div');
                loadingOverlay.className =
                    'fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50';
                loadingOverlay.innerHTML = `
                    <div class="bg-white rounded-xl p-8 flex flex-col items-center">
                        <i class="fas fa-spinner fa-spin text-blue-500 text-4xl mb-4"></i>
                        <p class="text-lg font-semibold text-gray-700">Sedang mengimport data...</p>
                        <p class="text-sm text-gray-500 mt-2">Harap tunggu, proses mungkin memakan waktu beberapa saat</p>
                    </div>
                `;

                document.body.appendChild(loadingOverlay);
            });

            // Clean up jika ada file yang dipilih sebelumnya
            if (!fileInput.files[0]) {
                submitBtn.disabled = true;
            }
        });
    </script>
</x-app-layout>
