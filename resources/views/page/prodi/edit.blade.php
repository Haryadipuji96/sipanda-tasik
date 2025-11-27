<x-app-layout>
    <x-slot name="title">Edit Prodi</x-slot>

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

        /* Select2 Custom Styling */
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db !important;
            border-radius: 0.5rem !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 42px !important;
            padding-left: 12px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px !important;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db !important;
            border-radius: 0.375rem !important;
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #3b82f6 !important;
        }
    </style>

    <!-- Load Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <div class="p-4 sm:p-6">
        <div class="max-w-3xl mx-auto">
            <div class="form-section">
                <!-- Header -->
                <div class="form-header">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div class="flex items-center space-x-3">
                            <div class="bg-white bg-opacity-20 p-2 rounded-full">
                                <i class="fas fa-edit text-white text-lg sm:text-xl"></i>
                            </div>
                            <div>
                                <h1 class="text-lg sm:text-xl font-semibold">Edit Program Studi</h1>
                                <p class="text-orange-100 text-xs sm:text-sm mt-1">
                                    Perbarui data program studi dan informasi fakultas
                                </p>
                            </div>
                        </div>
                        <a href="{{ route('prodi.index') }}" 
                           class="text-white hover:text-orange-100 transition flex items-center space-x-2 self-start sm:self-auto">
                            <i class="fas fa-arrow-left text-sm"></i>
                            <span class="text-sm">Kembali</span>
                        </a>
                    </div>
                </div>

                <!-- Form -->
                <form action="{{ route('prodi.update', $prodi->id) }}" method="POST" id="prodiForm">
                    @csrf
                    @method('PUT')

                    <div class="form-body">
                        <!-- Informasi Program Studi -->
                        <div class="mb-6 sm:mb-8">
                            <h3 class="text-base sm:text-lg font-semibold text-gray-800 mb-4 border-b pb-2">
                                <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                                Informasi Program Studi
                            </h3>

                            <div class="info-box">
                                <div class="flex items-start">
                                    <i class="fas fa-exclamation-circle text-amber-500 mt-0.5 mr-3 text-sm"></i>
                                    <div>
                                        <h4 class="font-medium text-amber-800 mb-1 text-sm sm:text-base">Informasi Edit</h4>
                                        <p class="text-amber-700 text-xs sm:text-sm">
                                            • Perbarui data program studi dengan informasi yang valid<br>
                                            • Field bertanda <span class="text-red-500">*</span> wajib diisi<br>
                                            • Perubahan akan langsung tersimpan di database
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="space-y-4 sm:space-y-6">
                                <!-- Fakultas -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Fakultas <span class="text-red-500">*</span>
                                    </label>
                                    <select name="id_fakultas" 
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                        <option value="">-- Pilih Fakultas --</option>
                                        @foreach ($fakultas as $f)
                                            <option value="{{ $f->id }}" 
                                                {{ old('id_fakultas', $prodi->id_fakultas) == $f->id ? 'selected' : '' }}>
                                                {{ $f->nama_fakultas }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_fakultas')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Nama Program Studi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Program Studi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" 
                                           name="nama_prodi" 
                                           value="{{ old('nama_prodi', $prodi->nama_prodi) }}"
                                           class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                           placeholder="Contoh: Teknik Informatika" 
                                           required 
                                           maxlength="255">
                                    @error('nama_prodi')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Jenjang -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenjang <span class="text-red-500">*</span>
                                    </label>
                                    <select name="jenjang" 
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                                            required>
                                        <option value="">-- Pilih Jenjang --</option>
                                        <option value="S1" {{ old('jenjang', $prodi->jenjang) == 'S1' ? 'selected' : '' }}>S1 - Sarjana</option>
                                        <option value="S2" {{ old('jenjang', $prodi->jenjang) == 'S2' ? 'selected' : '' }}>S2 - Magister</option>
                                        <option value="S3" {{ old('jenjang', $prodi->jenjang) == 'S3' ? 'selected' : '' }}>S3 - Doktor</option>
                                        <option value="D3" {{ old('jenjang', $prodi->jenjang) == 'D3' ? 'selected' : '' }}>D3 - Diploma</option>
                                        <option value="D4" {{ old('jenjang', $prodi->jenjang) == 'D4' ? 'selected' : '' }}>D4 - Diploma IV</option>
                                        <option value="Prof" {{ old('jenjang', $prodi->jenjang) == 'Prof' ? 'selected' : '' }}>Profesi</option>
                                        <option value="Lainnya" {{ old('jenjang', $prodi->jenjang) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                                    </select>
                                    @error('jenjang')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Ketua Prodi dengan Search -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Ketua Program Studi
                                    </label>
                                    <select name="ketua_prodi" 
                                            class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base select2-dosen"
                                            id="ketuaProdiSelect">
                                        <option value="">-- Pilih Ketua Prodi --</option>
                                        @foreach ($dosen as $d)
                                            @php
                                                $namaLengkap = trim(($d->gelar_depan ? $d->gelar_depan . ' ' : '') . $d->nama . ($d->gelar_belakang ? ', ' . $d->gelar_belakang : ''));
                                                if ($d->prodi) {
                                                    $namaLengkap .= ' (' . $d->prodi->nama_prodi . ')';
                                                }
                                            @endphp
                                            <option value="{{ $d->id }}" 
                                                {{ old('ketua_prodi', $prodi->ketua_prodi) == $d->id ? 'selected' : '' }}>
                                                {{ $namaLengkap }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <p class="text-gray-500 text-xs mt-1">
                                        Ketik untuk mencari nama dosen
                                    </p>
                                    @error('ketua_prodi')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Deskripsi Program Studi
                                    </label>
                                    <textarea name="deskripsi" 
                                              rows="4"
                                              class="w-full border border-gray-300 rounded-lg px-3 sm:px-4 py-2 sm:py-3 text-sm sm:text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition resize-none"
                                              placeholder="Masukkan deskripsi singkat tentang program studi...">{{ old('deskripsi', $prodi->deskripsi) }}</textarea>
                                    <p class="text-gray-500 text-xs mt-1">
                                        Deskripsi opsional tentang visi, misi, atau informasi tambahan program studi
                                    </p>
                                    @error('deskripsi')
                                        <p class="text-red-500 text-xs sm:text-sm mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
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
                                        <span class="ml-2 font-medium">{{ $prodi->updated_at->format('d/m/Y H:i') }}</span>
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
                           <a href="{{ route('prodi.index') }}"
                                class="btn-secondary text-center order-2 sm:order-1">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="btn-primary flex items-center justify-center order-1 sm:order-2 px-4 py-2 text-sm sm:text-base">
                                <i class="fas fa-save mr-2"></i>
                                Update Program Studi
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Load JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inisialisasi Select2 untuk dropdown ketua prodi
            $('#ketuaProdiSelect').select2({
                placeholder: "Cari nama dosen...",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Tidak ada dosen yang ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    }
                }
            });

            // Form validation
            const form = document.getElementById('prodiForm');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const namaProdi = document.querySelector('input[name="nama_prodi"]').value.trim();
                    const fakultas = document.querySelector('select[name="id_fakultas"]').value;
                    const jenjang = document.querySelector('select[name="jenjang"]').value;

                    if (!namaProdi || !fakultas || !jenjang) {
                        e.preventDefault();
                        Swal.fire({
                            icon: 'error',
                            title: 'Data belum lengkap',
                            text: 'Harap lengkapi semua field yang wajib diisi!',
                            confirmButtonColor: '#3b82f6'
                        });
                        return;
                    }
                });
            }

            // Auto-capitalize first letter of each word for nama_prodi
            const namaProdiInput = document.querySelector('input[name="nama_prodi"]');
            if (namaProdiInput) {
                namaProdiInput.addEventListener('blur', function() {
                    this.value = this.value.replace(/\w\S*/g, function(txt) {
                        return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                    });
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
                if (formBody) formBody.classList.add('px-2');
            } else {
                if (formBody) formBody.classList.remove('px-2');
            }
        }

        // Initial call
        handleResize();
        // Add resize listener
        window.addEventListener('resize', handleResize);
    </script>
</x-app-layout>