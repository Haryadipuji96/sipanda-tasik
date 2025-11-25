<x-app-layout>
    <x-slot name="title">Tambah Dokumen Mahasiswa</x-slot>

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

        .file-upload {
            border: 2px dashed #d1d5db;
            border-radius: 0.5rem;
            padding: 1.5rem;
            text-align: center;
            transition: all 0.2s;
        }

        .file-upload:hover {
            border-color: #3b82f6;
            background-color: #f8fafc;
        }

        .file-upload.dragover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }
    </style>

    <div class="p-6">
        <div class="max-w-4xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-user-graduate text-white"></i>
                            </div>
                            <div>
                                <h1 class="text-xl font-semibold">Tambah Dokumen Mahasiswa</h1>
                                <p class="text-blue-100 text-sm mt-1">
                                    Input data mahasiswa dan upload dokumen ijazah & transkrip
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('dokumen-mahasiswa.index') }}"
                            class="text-white hover:text-blue-100 transition flex items-center space-x-2">
                            <i class="fas fa-arrow-left"></i>
                            <span>Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('dokumen-mahasiswa.store') }}" method="POST" enctype="multipart/form-data"
                    id="dokumenForm">
                    @csrf

                    <div class="form-body">
                        <!-- Informasi Mahasiswa -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-user mr-2 text-blue-500"></i>
                                Informasi Mahasiswa
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- NIM -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        NIM <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nim" value="{{ old('nim') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="Contoh: 202301001" required maxlength="20">
                                    @error('nim')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Lengkap -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="Masukkan nama lengkap" required>
                                    @error('nama_lengkap')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                <!-- Program Studi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <select name="prodi_id"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                        <option value="">-- Pilih Program Studi --</option>
                                        @foreach ($prodi as $p)
                                            <option value="{{ $p->id }}"
                                                {{ old('prodi_id') == $p->id ? 'selected' : '' }}>
                                                {{ $p->nama_prodi }} - {{ $p->fakultas->nama_fakultas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('prodi_id')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Status Mahasiswa -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Status Mahasiswa <span class="text-red-500">*</span>
                                    </label>
                                    <select name="status_mahasiswa"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        required>
                                        <option value="">-- Pilih Status --</option>
                                        <option value="Aktif"
                                            {{ old('status_mahasiswa') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Lulus"
                                            {{ old('status_mahasiswa') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Cuti"
                                            {{ old('status_mahasiswa') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                        <option value="Drop Out"
                                            {{ old('status_mahasiswa') == 'Drop Out' ? 'selected' : '' }}>Drop Out
                                        </option>
                                    </select>
                                    @error('status_mahasiswa')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                                <!-- Tahun Masuk -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tahun Masuk <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="tahun_masuk" value="{{ old('tahun_masuk') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="2023" min="2000" max="{{ date('Y') + 1 }}" required>
                                    @error('tahun_masuk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tahun Keluar -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tahun Keluar (Opsional)
                                    </label>
                                    <input type="number" name="tahun_keluar" value="{{ old('tahun_keluar') }}"
                                        class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                        placeholder="2027" min="2000" max="{{ date('Y') + 5 }}" id="tahun_keluar">
                                    <p class="text-gray-500 text-xs mt-1">Hanya diisi untuk mahasiswa yang sudah lulus
                                    </p>
                                    @error('tahun_keluar')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-file-upload mr-2 text-green-500"></i>
                                Upload Dokumen
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-info-circle text-blue-500 mt-1 mr-3"></i>
                                    <div>
                                        <h4 class="font-medium text-blue-800 mb-1">Informasi Upload</h4>
                                        <p class="text-blue-700 text-sm">
                                            • Format file: <strong>PDF</strong><br>
                                            • Maksimal ukuran: <strong>2MB</strong> per file<br>
                                            • Nama file akan otomatis di-generate
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- File Ijazah -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File Ijazah (Opsional)
                                    </label>
                                    <input type="file" name="file_ijazah" id="file_ijazah"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf">
                                    <p class="text-gray-500 text-xs mt-1">
                                        Format: <b>PDF</b> | Maksimal <b>2MB</b>
                                    </p>
                                    <div id="ijazahPreview" class="mt-2 hidden">
                                        <div class="flex items-center p-2 bg-green-50 border border-green-200 rounded">
                                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span id="ijazahFileName"
                                                class="text-green-700 text-sm font-medium"></span>
                                        </div>
                                    </div>
                                    @error('file_ijazah')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- File Transkrip -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File Transkrip Nilai (Opsional)
                                    </label>
                                    <input type="file" name="file_transkrip" id="file_transkrip"
                                        class="w-full rounded-md border border-gray-300 bg-white text-sm text-gray-400 file:mr-4 file:py-2 file:px-4 file:border-0 file:bg-blue-600 file:text-white file:text-sm file:font-medium"
                                        accept=".pdf">
                                    <p class="text-gray-500 text-xs mt-1">
                                        Format: <b>PDF</b> | Maksimal <b>2MB</b>
                                    </p>
                                    <div id="transkripPreview" class="mt-2 hidden">
                                        <div class="flex items-center p-2 bg-green-50 border border-green-200 rounded">
                                            <svg class="w-5 h-5 text-green-500 mr-2" fill="currentColor"
                                                viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            <span id="transkripFileName"
                                                class="text-green-700 text-sm font-medium"></span>
                                        </div>
                                    </div>
                                    @error('file_transkrip')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Tombol -->
                        <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t">
                            <a href="{{ route('dokumen-mahasiswa.index') }}"
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit"
                                class="btn-primary flex items-center justify-center order-1 sm:order-2">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Data
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
            // Variabel untuk menyimpan status validasi file
            let fileValidationState = {
                validFiles: [],
                invalidFiles: []
            };

            // Fungsi untuk validasi file
            function validateFile(file, inputElement) {
                if (file) {
                    // Validasi ukuran file (2MB)
                    if (file.size > 2 * 1024 * 1024) {
                        fileValidationState.invalidFiles.push({
                            name: file.name,
                            size: (file.size / (1024 * 1024)).toFixed(2),
                            error: 'size',
                            input: inputElement.name
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'File Terlalu Besar',
                            text: 'Ukuran file maksimal 2MB. File Anda: ' + (file.size / (1024 * 1024))
                                .toFixed(2) + 'MB',
                            confirmButtonColor: '#3b82f6'
                        });
                        inputElement.value = '';
                        return false;
                    }

                    // Validasi tipe file
                    if (file.type !== 'application/pdf') {
                        fileValidationState.invalidFiles.push({
                            name: file.name,
                            type: file.type,
                            error: 'type',
                            input: inputElement.name
                        });

                        Swal.fire({
                            icon: 'error',
                            title: 'Format File Tidak Didukung',
                            text: 'Hanya file PDF yang diizinkan.',
                            confirmButtonColor: '#3b82f6'
                        });
                        inputElement.value = '';
                        return false;
                    }

                    // File valid - tambahkan ke list valid files
                    fileValidationState.validFiles.push({
                        name: file.name,
                        size: (file.size / (1024 * 1024)).toFixed(2),
                        input: inputElement.name
                    });

                    // Preview file
                    previewFile(file, inputElement);
                    return true;
                }
                return false;
            }

            // Fungsi untuk preview file
            function previewFile(file, inputElement) {
                const inputName = inputElement.name;
                const previewId = inputName + 'Preview';
                const fileNameId = inputName + 'FileName';
                const preview = document.getElementById(previewId);
                const fileName = document.getElementById(fileNameId);

                if (file && preview && fileName) {
                    fileName.textContent = file.name;
                    preview.classList.remove('hidden');

                    // Add visual feedback to upload area
                    const uploadArea = inputElement.parentElement;
                    uploadArea.classList.add('bg-green-50', 'border-green-300');
                }
            }

            // Fungsi untuk reset status validasi file
            function resetFileValidation() {
                fileValidationState = {
                    validFiles: [],
                    invalidFiles: []
                };
            }

            // Validasi semua file input
            const fileInputs = document.querySelectorAll('input[type="file"]');
            fileInputs.forEach(input => {
                input.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        // Reset validation state untuk file ini
                        fileValidationState.validFiles = fileValidationState.validFiles.filter(f =>
                            f.input !== this.name);
                        fileValidationState.invalidFiles = fileValidationState.invalidFiles.filter(
                            f => f.input !== this.name);

                        validateFile(file, this);
                    } else {
                        // Jika file dihapus, hapus dari state dan sembunyikan preview
                        fileValidationState.validFiles = fileValidationState.validFiles.filter(f =>
                            f.input !== this.name);
                        fileValidationState.invalidFiles = fileValidationState.invalidFiles.filter(
                            f => f.input !== this.name);

                        const previewId = this.name + 'Preview';
                        const preview = document.getElementById(previewId);
                        if (preview) {
                            preview.classList.add('hidden');
                        }
                    }
                });
            });

            // Validasi form submit
            const form = document.getElementById('dokumenForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    let isValid = true;
                    let errorMessages = [];

                    // Reset validation state
                    resetFileValidation();

                    // Validasi field required
                    const requiredFields = form.querySelectorAll('[required]');
                    requiredFields.forEach(field => {
                        if (!field.value.trim()) {
                            isValid = false;
                            field.classList.add('border-red-500');
                            errorMessages.push(`Field ${field.name} wajib diisi`);
                        } else {
                            field.classList.remove('border-red-500');
                        }
                    });

                    // Validasi semua file sebelum submit
                    const fileInputs = form.querySelectorAll('input[type="file"]');
                    fileInputs.forEach(input => {
                        if (input.files.length > 0) {
                            const file = input.files[0];
                            const fileIsValid = validateFile(file, input);
                            if (!fileIsValid) {
                                isValid = false;
                            }
                        }
                    });

                    if (!isValid) {
                        e.preventDefault();

                        // Tampilkan error messages
                        if (fileValidationState.invalidFiles.length > 0) {
                            let fileErrorMessage = 'Masalah dengan file upload:\n';
                            fileValidationState.invalidFiles.forEach(file => {
                                if (file.error === 'size') {
                                    fileErrorMessage +=
                                        `• ${file.name} - Ukuran file terlalu besar (${file.size}MB)\n`;
                                } else if (file.error === 'type') {
                                    fileErrorMessage +=
                                        `• ${file.name} - Format file tidak didukung\n`;
                                }
                            });

                            Swal.fire({
                                icon: 'error',
                                title: 'Validasi Gagal',
                                html: `
                                    <div class="text-left">
                                        <p class="mb-2">${errorMessages.join('<br>')}</p>
                                        <p class="mt-3">${fileErrorMessage}</p>
                                    </div>
                                `,
                                confirmButtonColor: '#3b82f6'
                            });
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Data Belum Lengkap',
                                text: errorMessages.join('\n'),
                                confirmButtonColor: '#3b82f6'
                            });
                        }
                    } else {
                        // Jika semua valid, tampilkan konfirmasi
                        if (fileValidationState.validFiles.length > 0) {
                            e.preventDefault();

                            let successMessage = 'Data siap disimpan!\n\nFile berikut akan diupload:\n';
                            fileValidationState.validFiles.forEach(file => {
                                successMessage += `• ${file.name} (${file.size}MB)\n`;
                            });

                            Swal.fire({
                                icon: 'success',
                                title: 'Konfirmasi Simpan',
                                text: successMessage,
                                showCancelButton: true,
                                confirmButtonText: 'Ya, Simpan Data',
                                cancelButtonText: 'Periksa Kembali',
                                confirmButtonColor: '#3b82f6',
                                cancelButtonColor: '#6b7280'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    form.submit();
                                }
                            });
                        }
                        // Jika tidak ada file yang diupload, lanjutkan submit normal
                    }
                });
            }

            // Drag and drop functionality
            document.querySelectorAll('.file-upload').forEach(area => {
                area.addEventListener('dragover', function(e) {
                    e.preventDefault();
                    this.classList.add('dragover');
                });

                area.addEventListener('dragleave', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');
                });

                area.addEventListener('drop', function(e) {
                    e.preventDefault();
                    this.classList.remove('dragover');

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        const input = this.querySelector('input[type="file"]');
                        input.files = files;

                        // Trigger change event
                        const event = new Event('change', {
                            bubbles: true
                        });
                        input.dispatchEvent(event);
                    }
                });
            });

            // Auto-hide tahun keluar based on status
            document.querySelector('select[name="status_mahasiswa"]').addEventListener('change', function() {
                const tahunKeluarInput = document.getElementById('tahun_keluar');
                if (this.value === 'Lulus') {
                    tahunKeluarInput.required = true;
                } else {
                    tahunKeluarInput.required = false;
                    tahunKeluarInput.value = '';
                }
            });

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
        });
    </script>
</x-app-layout>
