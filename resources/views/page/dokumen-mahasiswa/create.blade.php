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
                <form action="{{ route('dokumen-mahasiswa.store') }}" method="POST" enctype="multipart/form-data" id="dokumenForm">
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
                                    <input type="text" 
                                           name="nim" 
                                           value="{{ old('nim') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="Contoh: 202301001"
                                           required
                                           maxlength="20">
                                    @error('nim')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Lengkap -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lengkap <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="nama_lengkap" 
                                           value="{{ old('nama_lengkap') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="Masukkan nama lengkap"
                                           required>
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
                                        @foreach($prodi as $p)
                                            <option value="{{ $p->id }}" {{ old('prodi_id') == $p->id ? 'selected' : '' }}>
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
                                        <option value="Aktif" {{ old('status_mahasiswa') == 'Aktif' ? 'selected' : '' }}>Aktif</option>
                                        <option value="Lulus" {{ old('status_mahasiswa') == 'Lulus' ? 'selected' : '' }}>Lulus</option>
                                        <option value="Cuti" {{ old('status_mahasiswa') == 'Cuti' ? 'selected' : '' }}>Cuti</option>
                                        <option value="Drop Out" {{ old('status_mahasiswa') == 'Drop Out' ? 'selected' : '' }}>Drop Out</option>
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
                                    <input type="number" 
                                           name="tahun_masuk" 
                                           value="{{ old('tahun_masuk') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="2023"
                                           min="2000"
                                           max="{{ date('Y') + 1 }}"
                                           required>
                                    @error('tahun_masuk')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Tahun Keluar -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tahun Keluar (Opsional)
                                    </label>
                                    <input type="number" 
                                           name="tahun_keluar" 
                                           value="{{ old('tahun_keluar') }}"
                                           class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="2027"
                                           min="2000"
                                           max="{{ date('Y') + 5 }}"
                                           id="tahun_keluar">
                                    <p class="text-gray-500 text-xs mt-1">Hanya diisi untuk mahasiswa yang sudah lulus</p>
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
                                            • Maksimal ukuran: <strong>5MB</strong> per file<br>
                                            • Nama file akan otomatis di-generate
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- File Ijazah -->
                                <div class="file-upload-area">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File Ijazah (Opsional)
                                    </label>
                                    <div class="file-upload" 
                                         id="ijazahUpload"
                                         onclick="document.getElementById('file_ijazah').click()">
                                        <i class="fas fa-file-pdf text-3xl text-red-500 mb-2"></i>
                                        <p class="text-gray-600 mb-2">Klik untuk upload ijazah</p>
                                        <p class="text-gray-400 text-sm">PDF, maks. 5MB</p>
                                        <input type="file" 
                                               name="file_ijazah" 
                                               id="file_ijazah" 
                                               class="hidden" 
                                               accept=".pdf"
                                               onchange="previewFile(this, 'ijazahPreview')">
                                    </div>
                                    <div id="ijazahPreview" class="mt-2 hidden">
                                        <p class="text-green-600 text-sm flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            <span id="ijazahFileName"></span>
                                        </p>
                                    </div>
                                    @error('file_ijazah')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- File Transkrip -->
                                <div class="file-upload-area">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        File Transkrip Nilai (Opsional)
                                    </label>
                                    <div class="file-upload" 
                                         id="transkripUpload"
                                         onclick="document.getElementById('file_transkrip').click()">
                                        <i class="fas fa-file-pdf text-3xl text-green-500 mb-2"></i>
                                        <p class="text-gray-600 mb-2">Klik untuk upload transkrip</p>
                                        <p class="text-gray-400 text-sm">PDF, maks. 5MB</p>
                                        <input type="file" 
                                               name="file_transkrip" 
                                               id="file_transkrip" 
                                               class="hidden" 
                                               accept=".pdf"
                                               onchange="previewFile(this, 'transkripPreview')">
                                    </div>
                                    <div id="transkripPreview" class="mt-2 hidden">
                                        <p class="text-green-600 text-sm flex items-center">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            <span id="transkripFileName"></span>
                                        </p>
                                    </div>
                                    @error('file_transkrip')
                                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
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
        // Preview file upload
        function previewFile(input, previewId) {
            const file = input.files[0];
            const preview = document.getElementById(previewId);
            const fileName = previewId + 'FileName';
            
            if (file) {
                // Validate file type
                if (file.type !== 'application/pdf') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format tidak didukung',
                        text: 'Hanya file PDF yang diizinkan.'
                    });
                    input.value = '';
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'error',
                        title: 'File terlalu besar',
                        text: 'Ukuran file maksimal 5MB.'
                    });
                    input.value = '';
                    return;
                }

                document.getElementById(fileName).textContent = file.name;
                preview.classList.remove('hidden');
                
                // Add visual feedback to upload area
                const uploadArea = input.parentElement;
                uploadArea.classList.add('bg-green-50', 'border-green-300');
            }
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
                    const event = new Event('change', { bubbles: true });
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
    </script>
</x-app-layout>