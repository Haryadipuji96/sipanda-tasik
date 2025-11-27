<x-app-layout>
    <x-slot name="title">Edit Arsip</x-slot>

    <style>
        .form-section {
            background: white;
            border-radius: 0.75rem;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
            border: 1px solid #e5e7eb;
            overflow: hidden;
        }

        .form-header {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
            color: white;
            padding: 1.5rem;
        }

        .form-body {
            padding: 1.5rem;
        }

        .info-box {
            background-color: #fffbeb;
            border: 1px solid #fcd34d;
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
                                <i class="fas fa-edit text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Edit Data Arsip</h1>
                                <p class="text-orange-100 text-xs sm:text-sm mt-1">
                                    Perbarui data arsip dan informasi dokumen
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('arsip.index') }}" 
                           class="text-white hover:text-orange-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('arsip.update', $arsip->id) }}" method="POST" enctype="multipart/form-data" id="arsipForm">
                    @csrf
                    @method('PUT')

                    <div class="form-body">
                        <!-- Informasi Dokumen -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Dokumen
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-amber-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-amber-800 mb-1 text-sm sm:text-base">Informasi Edit</h4>
                                        <p class="text-amber-700 text-xs sm:text-sm">
                                            • Perbarui data arsip dengan informasi yang valid<br>
                                            • Field bertanda <span class="text-red-500">*</span> wajib diisi<br>
                                            • Upload file baru untuk mengganti file lama
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Kategori Arsip -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Kategori Arsip <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_kategori"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                        @foreach ($kategori as $k)
                                            <option value="{{ $k->id }}"
                                                {{ $k->id == $arsip->id_kategori ? 'selected' : '' }}>
                                                {{ $k->nama_kategori }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_kategori')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Judul Dokumen -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Judul Dokumen <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="judul_dokumen" value="{{ old('judul_dokumen', $arsip->judul_dokumen) }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="Masukkan judul dokumen yang jelas dan deskriptif" required
                                        maxlength="255">
                                    @error('judul_dokumen')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Grid: Nomor & Tanggal Dokumen -->
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <!-- Nomor Dokumen -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Nomor Dokumen
                                        </label>
                                        <input type="text" name="nomor_dokumen" value="{{ old('nomor_dokumen', $arsip->nomor_dokumen) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            placeholder="Contoh: SK-001/IAIT/2025" maxlength="100">
                                        @error('nomor_dokumen')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Tanggal Dokumen -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">
                                            Tanggal Dokumen
                                        </label>
                                        <input type="date" name="tanggal_dokumen"
                                            value="{{ old('tanggal_dokumen', $arsip->tanggal_dokumen) }}"
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                        @error('tanggal_dokumen')
                                            <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Tahun Dokumen -->
                                <div class="max-w-xs">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tahun Dokumen
                                    </label>
                                    <input type="text" name="tahun" value="{{ old('tahun', $arsip->tahun) }}"
                                        class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="2025" maxlength="4" pattern="[0-9]{4}">
                                    <p class="text-gray-500 text-xs mt-1">Format: 4 digit angka (contoh: 2025)</p>
                                    @error('tahun')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-file-upload mr-2 text-green-500"></i>
                                Upload Dokumen
                            </h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    File Dokumen Saat Ini
                                </label>
                                
                                @if ($arsip->file_dokumen)
                                    <div class="mb-3 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                        <a href="{{ asset('dokumen_arsip/' . $arsip->file_dokumen) }}" target="_blank" 
                                           class="text-blue-600 hover:text-blue-800 font-medium underline flex items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            {{ $arsip->file_dokumen }}
                                        </a>
                                        <p class="text-gray-500 text-xs mt-1">
                                            Upload file baru untuk mengganti yang lama. <strong>Maks. 2MB</strong>
                                        </p>
                                    </div>
                                @else
                                    <p class="text-gray-500 italic text-sm mb-3">Belum ada file.</p>
                                @endif

                                <input type="file" name="file_dokumen" id="file_dokumen"
                                    class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                    accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                                    onchange="previewFile(this, 'filePreview')">
                                <p class="text-gray-500 text-xs mt-1">
                                    Format: <b>PDF, DOC, DOCX, JPG, PNG</b> | Maksimal <b>2MB</b>
                                </p>
                                <div id="filePreview" class="mt-2 hidden">
                                    <div class="flex items-center p-2 bg-green-50 border border-green-200 rounded">
                                        <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <span id="fileName" class="text-green-700 text-sm font-medium"></span>
                                    </div>
                                </div>
                                @error('file_dokumen')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-sticky-note mr-2 text-purple-500"></i>
                                Keterangan Tambahan
                            </h3>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Keterangan (Opsional)
                                </label>
                                <textarea name="keterangan" rows="4"
                                    class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                    placeholder="Tambahkan catatan, penjelasan, atau informasi tambahan tentang dokumen ini...">{{ old('keterangan', $arsip->keterangan) }}</textarea>
                                <p class="text-gray-500 text-xs mt-1">
                                    Keterangan opsional untuk memberikan informasi tambahan tentang dokumen
                                </p>
                                @error('keterangan')
                                    <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Sistem -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-cogs mr-2 text-green-500"></i>
                                Informasi Sistem
                            </h3>

                            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                                    <div class="flex items-center">
                                        <i class="fas fa-calendar text-blue-500 mr-2 text-sm"></i>
                                        <span class="text-gray-600">Terakhir diupdate:</span>
                                        <span class="ml-2 font-medium">{{ $arsip->updated_at->format('d/m/Y H:i') }}</span>
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
                            <a href="{{ route('arsip.index') }}"
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-1 sm:order-2 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Update Arsip
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
            // Function untuk validasi file
            function validateFile(file) {
                if (!file) return false;

                // Validate file type
                const allowedTypes = ['application/pdf', 'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'image/jpeg', 'image/jpg', 'image/png'
                ];
                if (!allowedTypes.includes(file.type)) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format File Tidak Didukung',
                        text: 'Hanya file PDF, DOC, DOCX, JPG, dan PNG yang diizinkan.'
                    });
                    return false;
                }

                // Validate file size (2MB)
                if (file.size > 2 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File Terlalu Besar',
                        text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024)).toFixed(2) + 'MB'
                    });
                    return false;
                }

                return true;
            }

            // Function untuk preview file
            function previewFile(input, previewId) {
                const file = input.files[0];
                const preview = document.getElementById(previewId);

                if (file) {
                    // Validasi file terlebih dahulu
                    if (!validateFile(file)) {
                        input.value = ''; // Clear input jika validasi gagal
                        return;
                    }

                    // Show file preview
                    const fileName = document.getElementById('fileName');
                    if (fileName) {
                        fileName.textContent = file.name;
                    }
                    if (preview) {
                        preview.classList.remove('hidden');
                    }
                } else {
                    // Hide preview jika tidak ada file
                    if (preview) {
                        preview.classList.add('hidden');
                    }
                }
            }

            // Validasi untuk input file
            const fileInput = document.getElementById('file_dokumen');
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    const preview = document.getElementById('filePreview');

                    if (file) {
                        if (!validateFile(file)) {
                            this.value = ''; // Clear input jika validasi gagal
                            if (preview) {
                                preview.classList.add('hidden');
                            }
                            return;
                        }

                        // Show file preview
                        const fileName = document.getElementById('fileName');
                        if (fileName) {
                            fileName.textContent = file.name;
                        }
                        if (preview) {
                            preview.classList.remove('hidden');
                        }
                    } else {
                        // Hide preview jika tidak ada file
                        if (preview) {
                            preview.classList.add('hidden');
                        }
                    }
                });
            }

            // Validasi form submit
            const form = document.getElementById('arsipForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const kategori = document.querySelector('select[name="id_kategori"]');
                    const judulDokumen = document.querySelector('input[name="judul_dokumen"]');
                    const fileInput = document.getElementById('file_dokumen');

                    let isValid = true;
                    let errorMessage = '';

                    // Validasi required fields
                    if (!kategori.value || !judulDokumen.value.trim()) {
                        isValid = false;
                        errorMessage = 'Kategori Arsip dan Judul Dokumen wajib diisi!';
                    }

                    // Validasi file jika ada
                    if (fileInput && fileInput.files.length > 0) {
                        const file = fileInput.files[0];
                        if (!validateFile(file)) {
                            isValid = false;
                            // Pesan error sudah ditampilkan di validateFile
                        }
                    }

                    if (!isValid && errorMessage) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Belum Lengkap',
                            text: errorMessage
                        });
                    }
                });
            }

            // Auto-capitalize first letter for judul dokumen
            const judulDokumenInput = document.querySelector('input[name="judul_dokumen"]');
            if (judulDokumenInput) {
                judulDokumenInput.addEventListener('blur', function() {
                    if (this.value) {
                        this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
                    }
                });
            }

            // NOTIFIKASI SUKSES UPDATE
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Diupdate!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false,
                    timerProgressBar: true
                });
            @endif

            // NOTIFIKASI ERROR VALIDATION
            @if ($errors->any())
                @if(!session('success'))
                    let errorMessage = '';
                    @foreach ($errors->all() as $error)
                        errorMessage += `• {{ $error }}<br>`;
                    @endforeach
                    
                    Swal.fire({
                        icon: 'error',
                        title: 'Terjadi Kesalahan!',
                        html: errorMessage,
                        confirmButtonColor: '#3b82f6'
                    });
                @endif
            @endif
        });

        // Responsive behavior
        function handleResize() {
            const formBody = document.querySelector('.form-body');
            if (window.innerWidth < 640) {
                formBody.classList.add('px-2');
            } else {
                formBody.classList.remove('px-2');
            }
        }

        // Initial call
        handleResize();
        window.addEventListener('resize', handleResize);
    </script>
</x-app-layout>